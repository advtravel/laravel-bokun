<?php

namespace Adventures\LaravelBokun\GraphQL\DTOs;

trait HasTimeStamps
{
    abstract static protected function getTimeStampColumnNames(): array;

    protected function encodeSpecialFields(string $name, mixed $value): array
    {
        if (in_array($name, static::getTimeStampColumnNames())) {
            return [$name => date('Y-m-d\TH:i:s', $value)];
        }

        return parent::encodeSpecialFields($name, $value);
    }

    protected static function decodeSpecialFields(string $name, mixed $value): array
    {
        if (in_array($name, static::getTimeStampColumnNames())) {
            return [$name => strtotime($value)];
        }

        return parent::decodeSpecialFields($name, $value);
    }
}
