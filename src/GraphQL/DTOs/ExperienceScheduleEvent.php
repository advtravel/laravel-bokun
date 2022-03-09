<?php

namespace Adventures\LaravelBokun\GraphQL\DTOs;

use Adventures\LaravelBokun\GraphQL\Types\ExperienceAvailabilityStatus;

class ExperienceScheduleEvent extends DTO
{
    public function __construct(
        public Experience $experience,
        public int $seatsAvailable,
        public ExperienceAvailabilityStatus $status,
    ) {
    }
}
