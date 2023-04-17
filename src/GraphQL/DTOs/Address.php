<?php

namespace Adventures\LaravelBokun\GraphQL\DTOs;

use Adventures\LaravelBokun\GraphQL\Types\LocationOrigin;

class Address extends DTO
{
    protected static function decodeSpecialFields(string $name, mixed $value): array
    {
        if ($name === 'originId') {
            return [$name => $value];
        }

        return parent::decodeSpecialFields($name, $value);
    }

    protected function encodeSpecialFields(string $name, mixed $value): array
    {
        if ($name === 'originId') {
            return [$name => $value];
        }

        return parent::encodeSpecialFields($name, $value);
    }

    public function __construct(
        public int $id,
        public ?string $addressLine1 = null,
        public ?string $addressLine2 = null,
        public ?string $addressLine3 = null,
        public ?string $city = null,
        public ?string $countryCode = null,
        public ?GeoPoint $geoPoint = null,
        public ?LocationOrigin $origin = null,
        public ?string $originId = null,
        public ?string $postalCode = null,
        public ?string $state = null,
    ) {
    }
}
