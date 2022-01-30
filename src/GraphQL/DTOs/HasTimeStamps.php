<?php

namespace Adventures\LaravelBokun\GraphQL\DTOs;

trait HasTimeStamps
{
    abstract protected static function getTimeStampColumnNames(): array;

    protected function encodeSpecialFields(string $name, mixed $value): array
    {
        if (!is_null($value) && in_array($name, static::getTimeStampColumnNames())) {
            return [$name => date('Y-m-d\TH:i:s', $value)];
        }

        return parent::encodeSpecialFields($name, $value);
    }

    protected static function decodeSpecialFields(string $name, mixed $value): array
    {
        if (in_array($name, static::getTimeStampColumnNames())) {
            if (strpos($value, '[') !== false) {
                $value = substr($value, 0, strpos($value, '['));
            }
            return [$name => strtotime($value)];
        }

        return parent::decodeSpecialFields($name, $value);
    }
}
