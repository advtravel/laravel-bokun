<?php

namespace Adventures\LaravelBokun\GraphQL\DTOs;

use Adventures\LaravelBokun\GraphQL\Types\ArrivalStatus;

class ExperienceBookingUpdateArrivalStatusInput extends DTO
{
    public function __construct(
        public int $experienceBookingId,
        public ArrivalStatus $arrivalStatus
    ) {
    }
}
