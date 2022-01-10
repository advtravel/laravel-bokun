<?php

namespace Adventures\LaravelBokun\GraphQL;

class BokunHelpers
{
    public static function parseID($base64id): array
    {
        $text = base64_decode($base64id);
        [$key, $value] = explode(':', $text, 2);

        return [$key => (int) $value];
    }

    public static function toID(string $key, int $value): string
    {
        return base64_encode($key . ':' . $value);
    }
}
