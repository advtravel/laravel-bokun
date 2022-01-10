<?php

namespace Adventures\LaravelBokun\GraphQL\DTOs;

use Adventures\LaravelBokun\GraphQL\BokunHelpers;
use InvalidArgumentException;
use ReflectionObject;
use ReflectionProperty;

abstract class DTO
{
    public function toArray(): array
    {
        $data = [];
        $rothis = new ReflectionObject($this);
        foreach ($rothis->getProperties(ReflectionProperty::IS_PUBLIC) as $property) {
            $name = $property->name;
            $value = $this->encode($property->getValue($this), $name);

            // Special cases where we encode something in PHP differently from the API
            if ($name === 'dateTimestamp') {
                $name = 'date';
                $value = date('Y-m-d', $value);
            }
            if ($name === 'pickupPlaceId') {
                $data['pickup'] = true;
            }
            if ($name === 'dropoffPlaceId') {
                $data['dropoff'] = true;
            }

            // Optional properties
            if (is_null($value)) {
                continue;
            }

            $data[$name] = $value;
        }
        return $data;
    }
    public function __toString(): string
    {
        $lines = [];
        foreach($this->toArray() as $key => $value) {
            if (!preg_match('/^[a-zA-Z_]+$/', $key)) {
                throw new InvalidArgumentException("$key contains invalid characters as a GraphQL key.");
            }
            $encodeArray = function(array $input) use (&$encode) {
                $output = [];
                foreach($input as $item) {
                    $output[] = $encode($item);
                }
                return '[ ' . implode(', ', $output) . ' ]';
            };
            $encode = function($value) use (&$encode, &$encodeArray) {
                return match(gettype($value)) {
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

    private function encode(mixed $input, ?string $name = null): string|int|array|null|self|bool|float
    {
        $isId = !is_null($name) && str_ends_with($name, 'Id');

        if (is_null($input) || is_string($input) || is_float($input) || is_bool($input)) {
            return $input;
        }
        
        if (is_int($input) && !$isId) {
            return $input;
        }

        if ($input instanceof self) {
            return $input;
        }

        if (is_int($input) && $isId) {
            // experienceBookingId => ExperienceBooking
            $class = ucfirst(substr($name, 0, -2));
            
            return BokunHelpers::toID($class, $input);
        }

        if (is_array($input)) {
            foreach($input as $k => $v) {
                $input[$k] = $this->encode($v);
            }
            return $input;
        }


        throw new InvalidArgumentException("Can't encode input: " . json_encode($input));
    }
}
