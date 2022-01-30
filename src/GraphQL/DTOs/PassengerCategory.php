<?php

namespace Adventures\LaravelBokun\GraphQL\DTOs;

class PassengerCategory extends DTO
{
    public function __construct(
        public int $id,
        public string $type,
        public int $occupancyPerPassenger,
        public ?string $name = null,
    ) {
    }
}
