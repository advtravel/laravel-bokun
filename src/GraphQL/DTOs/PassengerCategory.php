<?php

namespace Adventures\LaravelBokun\GraphQL\DTOs;

use Adventures\LaravelBokun\GraphQL\Types\TicketCategory;

class PassengerCategory extends DTO
{
    public function __construct(
        public int $id,
        public int $occupancyPerPassenger,
        public ?TicketCategory $type = null,
        public ?string $name = null,
    ) {
    }
}
