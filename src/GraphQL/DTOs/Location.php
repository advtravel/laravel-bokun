<?php

namespace Adventures\LaravelBokun\GraphQL\DTOs;

use Adventures\LaravelBokun\GraphQL\Types\LocationType;

class Location extends DTO
{
    public function __construct(
        public int $id,
        public ?Address $address = null,
        public ?string $name = null,
        public ?LocationType $type = null,
    ) {
    }
}
