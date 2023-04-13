<?php

namespace Adventures\LaravelBokun\GraphQL\DTOs;

class PickupPlace extends DTO
{
    public function __construct(
        public int $id,
        public ?Location $location = null,
        public ?int $minutesBeforeStartTime = null,
        public ?int $timeWindowInMinutes = null,
    ) {
    }
}
