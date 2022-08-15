<?php

namespace Adventures\LaravelBokun\GraphQL\DTOs;

use Adventures\LaravelBokun\ArrayOf;

class ExperienceRate extends DTO
{
    public function __construct(
        public int $id,
        public ?string $description = null,
        public ?string $name = null,
        public ?int $minPassengersPerBooking = null,
        public ?int $maxPassengersPerBooking = null,
        public ?bool $pricedPerPassenger = null,
        public ?string $rateCode = null,
        #[ArrayOf(Extra::class)]
        public ?array $extras = null,
    ) {
    }
}
