<?php

namespace Adventures\LaravelBokun\GraphQL\DTOs;

use Adventures\LaravelBokun\ArrayOf;
use Adventures\LaravelBokun\GraphQL\BokunHelpers;
use InvalidArgumentException;
use ReflectionClass;
use ReflectionNamedType;
use ReflectionObject;
use ReflectionProperty;
use RuntimeException;

abstract class DTO
{
    private array $raw = [];

    public function setRaw(array $rawData)
    {
        $this->raw = $rawData;
    }

    private static array $onlyUseFields = [];

    /**
     * Is a given property name an id that needs to be B64 encoded to Bókun?
     *
     * Recognized formats:
     * - ExperienceStartTime::ExperienceId = 42 => Experience:42
     * - ExperienceStartTime::id = 42 => ExperienceStartTime:42
     * - Experience::experienceStartTimeIds = [42] => [ExperienceStartTime:42]
     */
    protected static function isId(string $name): bool
    {
        return ($name === 'id') || str_ends_with($name, 'Id') || str_ends_with($name, 'Ids');
    }

    /**
     * Mapping of fields from PHP -> GraphQL for fields that are different
     *
     * This function takes care of IDs, derived classes can extend it.
     */
    protected function encodeSpecialFields(string $name, mixed $value): array
    {
        $isId = self::isId($name);

        if (is_int($value) && $isId) {
            if ($name === 'id') {
                // Experience::id => Experience
                $reflection = new ReflectionClass($this);
                $class = $reflection->getShortName();
            } else {
                // experienceBookingId => ExperienceBooking
                $class = ucfirst(substr($name, 0, -2));
            }

            return [$name => BokunHelpers::toID($class, $value)];
        }

        if (is_array($value) && $isId) {
            $class = ucfirst(substr($name, 0, -3));
            // experienceBookingIds => ExperienceBooking

            return [$name => collect($value)->map(
                fn ($v) => BokunHelpers::toID($class, $v)
            )->toArray()];
        }

        return [$name => $value];
    }

    /**
     * Mapping of fields from GraphQL -> PHP
     *
     * This is the counterpart to encodeSpecialFields.
     * It's static because creation of an object is done in a static
     * context, e.g. Experience::fromArray(array $GraphQLResponse)
     */
    protected static function decodeSpecialFields(string $name, mixed $value): array
    {
        if (! self::isId($name)) {
            return [$name => $value];
        }

        if (is_null($value) || is_numeric($value)) {
            return [$name => $value];
        }

        if (is_string($value)) {
            $id = array_values(BokunHelpers::parseID($value))[0];

            return [$name => $id];
        }

        if (is_array($value)) {
            $ids = [];
            foreach ($value as $v) {
                $ids[] = array_values(BokunHelpers::parseID($v))[0];
            }

            return [$name => $ids];
        }

        throw new RuntimeException("a field that's an ID has to be string or array in API return.");
    }

    /**
     * Encodes this DTO into an array suitable for the Bókun GraphQL API
     */
    public function toArray(): array
    {
        $data = [];
        $rothis = new ReflectionObject($this);
        foreach ($rothis->getProperties(ReflectionProperty::IS_PUBLIC) as $property) {
            $name = $property->name;
            $value = $property->getValue($this);

            // $type = $property->getType();
            // if ($type instanceof ReflectionNamedType) {
            //     if (enum_exists($type->getName())) {
            //         $value = $value?->value;
            //     }
            // }

            $processed = $this->encodeSpecialFields($name, $value);
            $processed = array_filter($processed, fn ($v) => ! is_null($v));
            $data = $processed + $data;
        }

        return $data;
    }

    /**
     * Serializes the toArray() representation of this object into a GraphQL string
     */
    public function __toString(): string
    {
        $lines = [];
        foreach ($this->toArray() as $key => $value) {
            if (! preg_match('/^[a-zA-Z_]+$/', $key)) {
                throw new InvalidArgumentException("$key contains invalid characters as a GraphQL key.");
            }
            /** @var \Closure $encode */
            $encodeArray = function (array $input) use (&$encode) {
                $output = [];
                foreach ($input as $item) {
                    // @phpstan-ignore-next-line
                    $output[] = $encode($item);
                }

                return '[ ' . implode(', ', $output) . ' ]';
            };
            $encode = function ($value) use (&$encodeArray) {
                return match (gettype($value)) {
                    "object" => enum_exists($value::class) ? $value->value : (string) $value,
                    "array" => $encodeArray($value),
                    "boolean" => $value ? 'true' : 'false',
                    default => json_encode($value)
                };
            };
            $lines[] = $key . ': ' . $encode($value);
        }

        return '{ ' . implode(', ', $lines) . ' }';
    }

    /**
     * For a property that has the #[ArrayOf] attribute, return the classname
     * that this is an array of.
     */
    private static function getArrayOf(ReflectionProperty $property): ArrayOf
    {
        $attributes = $property->getAttributes(ArrayOf::class);
        if (count($attributes) !== 1) {
            $class = get_called_class();

            throw new RuntimeException("Can't serialize an array ($class::{$property->name}) into fields without #[ArrayOf(abc::class)].");
        }
        $attribute = $attributes[0]->newInstance();

        return $attribute;
    }

    /**
     * List all properties (recursively) of this DTO so that they can be used
     * as a list of fields to retrieve from the Bókun GraphQL API.
     * Works very well with the ::fromArray() method as the result of a query
     * constructed by this method can directly be used to construct the DTOs
     * for the results.
     */
    public static function listFieldsForQuery(array $excludeKeys = []): string
    {
        $data = [];
        $self = new ReflectionClass(static::class);

        foreach ($self->getProperties(ReflectionProperty::IS_PUBLIC) as $property) {
            $name = $property->name;

            if (in_array($name, $excludeKeys)) {
                continue;
            }

            if (
                array_key_exists(static::class, self::$onlyUseFields)
                && ! in_array($name, self::$onlyUseFields[static::class])
            ) {
                continue;
            }

            $type = (string) $property->getType();
            if (str_starts_with($type, '?')) {
                $type = substr($type, 1);
            }

            $string_representation = $name;
            if (is_subclass_of($type, self::class)) {
                $string_representation =
                    $name . ' { ' . $type::listFieldsForQuery() . ' }';
            } elseif ($type === 'array') {
                $arrayOf = self::getArrayOf($property);
                $arrayOfType = $arrayOf->getClassName();
                if (! in_array($arrayOfType, ['string', 'int', 'float', 'bool'])) {
                    $fields = $arrayOfType::listFieldsForQuery($arrayOf->getExcludeKeys());
                    $string_representation =
                        $name . ' { ' . $fields . ' }';
                }
            }

            $data[] = $string_representation;
        }

        return implode(', ', $data);
    }

    /**
     * Limits the fields of this DTO to those that are actually used.
     *
     * If this function is called without arguments, it resets the state to "all fields".
     *
     * @param string ...$fields Fields that should be included in queries
     */
    public static function onlyUse(string ...$fields): void
    {
        foreach ($fields as $field) {
            if (! property_exists(static::class, $field)) {
                throw new RuntimeException("Can't use $field on " . static::class . " since it's not a defined property.");
            }
        }

        if ((count($fields) > 0)) {
            self::$onlyUseFields[static::class] = $fields;

            return;
        }

        if (array_key_exists(static::class, self::$onlyUseFields)) {
            unset(self::$onlyUseFields[static::class]);
        }
    }

    /**
     * Constructs a DTO from an array. Properties that are DTOs again itself
     * are treated correctly, just like arrays of properties.
     */
    public static function fromArray(array $data): static
    {
        $arguments = [];
        $self = new ReflectionClass(static::class);

        $processed = [];
        foreach ($data as $name => $value) {
            $processed = static::decodeSpecialFields($name, $value) + $processed;
        }

        foreach ($self->getProperties(ReflectionProperty::IS_PUBLIC) as $property) {
            $name = $property->name;
            $type = $property->getType();
            if (! $type instanceof ReflectionNamedType) {
                throw new RuntimeException("Property $name needs to have a type. Union types and intersection types are not supported.");
            }

            if (! array_key_exists($name, $processed)) {
                if (! $type->allowsNull()) {
                    throw new RuntimeException("Property $name needs to be filled but not present in data");
                }
                $arguments[$name] = null;

                continue;
            }

            $type = $type->getName();
            if (is_subclass_of($type, self::class)) {
                $arguments[$name] = is_null($processed[$name])
                    ? null
                    : $type::fromArray($processed[$name]);
            } elseif (is_array($processed[$name])) {
                $arrayOf = self::getArrayOf($property)->getClassName();
                $arguments[$name] = [];
                foreach ($processed[$name] as $item) {
                    $arguments[$name][] = match ($arrayOf) {
                        'string' => (string) $item,
                        'int' => (int) $item,
                        'float' => (float) $item,
                        'bool' => ! ! $item,
                        default => $arrayOf::fromArray($item)
                    };
                }
            } else {
                $typeRef = class_exists($type) ? new ReflectionClass($type) : null;
                if ($typeRef?->isEnum()) {
                    $arguments[$name] = is_null($processed[$name])
                        ? null
                        : $type::from($processed[$name]);
                } else {
                    $arguments[$name] = $processed[$name];
                    settype($arguments[$name], $type);
                }
            }
        }

        // https://phpstan.org/blog/solving-phpstan-error-unsafe-usage-of-new-static
        // We ignore the error since we know exactly what we're doing
        // @phpstan-ignore-next-line
        $dto = new static(...$arguments);
        $dto->setRaw($data);

        return $dto;
    }
}
