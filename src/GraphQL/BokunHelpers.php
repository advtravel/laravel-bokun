<?php

namespace Adventures\LaravelBokun\GraphQL;

use RuntimeException;
use Throwable;

class BokunHelpers
{
    public static function parseID(string $base64id): array
    {
        $text = base64_decode($base64id);
        [$key, $value] = explode(':', $text, 2);

        return [$key => (int) $value];
    }

    public static function toID(string $key, int $value): string
    {
        return base64_encode($key . ':' . $value);
    }

    public static function getIdOrThrow(string $base64id, string $idKey): int
    {
        $parsed = self::parseID($base64id);

        if (! array_key_exists($idKey, $parsed)) {
            $json = json_encode($parsed);

            throw new RuntimeException("Can't parse $base64id: The parsed ID ($json) doesn't contain $idKey");
        }

        if (! is_int($parsed[$idKey])) {
            throw new RuntimeException("Can't parse $base64id: The parsed ID of {$parsed[$idKey]} is not an integer.");
        }

        return $parsed[$idKey];
    }

    /**
     * @return int|false
     */
    public static function getIdOrFalse(string $base64id, string $idKey): int|bool
    {
        try {
            return self::getIdOrThrow($base64id, $idKey);
        } catch (Throwable) {
            return false;
        }
    }
}
