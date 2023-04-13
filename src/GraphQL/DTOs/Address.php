<?php

namespace Adventures\LaravelBokun\GraphQL\DTOs;

use Adventures\LaravelBokun\GraphQL\Types\LocationOrigin;

class Address
{
    public function __construct(
        public int $id,
        public ?string $addressLine1 = null,
        public ?string $addressLine2 = null,
        public ?string $addressLine3 = null,
        public ?string $city = null,
        public ?string $countryCode = null,
        public ?GeoPoint $geoPoint = null,
        public ?LocationOrigin $locationOrigin = null,
        public ?string $originId = null,
        public ?string $postalCode = null,
        public ?string $state = null,
    ) {
    }
}
