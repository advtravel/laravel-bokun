<?php

namespace Adventures\LaravelBokun\GraphQL\DTOs;

use Adventures\LaravelBokun\ArrayOf;
use Adventures\LaravelBokun\GraphQL\BokunHelpers;
use InvalidArgumentException;
use ReflectionClass;
use ReflectionObject;
use ReflectionProperty;
use RuntimeException;

abstract class DTO
{
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

            return collect($value)->map(
                fn ($v) => BokunHelpers::toID($class, $v)
            )->toArray();
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
            $encodeArray = function (array $input) use (&$encode) {
                $output = [];
                foreach ($input as $item) {
                    $output[] = $encode($item);
                }

                return '[ ' . implode(', ', $output) . ' ]';
            };
            $encode = function ($value) use (&$encode, &$encodeArray) {
                return match (gettype($value)) {
                    "object" => (string) $value,
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
    private static function getArrayOfType(ReflectionProperty $property): string
    {
        $attributes = $property->getAttributes(ArrayOf::class);
        if (count($attributes) !== 1) {
            throw new RuntimeException("Can't serialize an array into fields without #[ArrayOf(abc::class)].");
        }
        $attribute = $attributes[0]->newInstance();

        return $attribute->getClassName();
    }

    /**
     * List all properties (recursively) of this DTO so that they can be used
     * as a list of fields to retrieve from the Bókun GraphQL API.
     * Works very well with the ::fromArray() method as the result of a query
     * constructed by this method can directly be used to construct the DTOs
     * for the results.
     */
    public static function listFieldsForQuery(): string
    {
        $data = [];
        $self = new ReflectionClass(static::class);
        foreach ($self->getProperties(ReflectionProperty::IS_PUBLIC) as $property) {
            $name = $property->name;
            $type = (string) $property->getType();
            $string_representation = $name;
            if (is_subclass_of($type, self::class)) {
                $string_representation =
                    $name . ' { ' . $type::listFieldsForQuery() . ' }';
            } elseif (($type === 'array') || ($type === '?array')) {
                $arrayOf = self::getArrayOfType($property);
                $fields = $arrayOf::listFieldsForQuery();
                $string_representation =
                    $name . ' { ' . $fields . ' }';
            }

            $data[] = $string_representation;
        }

        return implode(', ', $data);
    }

    /**
     * Constructs a DTO from an array. Properties that are DTOs again itself
     * are treated correctly, just like arrays of properties.
     * Can't deal with arrays of scalars currently, haven't seen them in the
     * Bókun API so far anyways.
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

            if (! array_key_exists($name, $processed)) {
                if (! $type->allowsNull()) {
                    throw new RuntimeException("Property $name needs to be filled but not present in data");
                }
                $arguments[$name] = null;

                continue;
            }

            $type = (string) $type;
            if (is_subclass_of($type, self::class)) {
                $arguments[$name] = $type::fromArray($processed[$name]);
            } elseif (is_array($processed[$name])) {
                $arrayOf = self::getArrayOfType($property);
                $arguments[$name] = [];
                foreach ($processed[$name] as $item) {
                    $arguments[$name][] = $arrayOf::fromArray($item);
                }
            } else {
                $arguments[$name] = $processed[$name];
                settype($arguments[$name], $type);
            }
        }

        return new static(...$arguments);
    }
}
