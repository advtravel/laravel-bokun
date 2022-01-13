<?php

namespace Adventures\LaravelBokun\GraphQL\DTOs;

class ExperienceScheduleEvent extends DTO
{
    public function __construct(
        public Experience $experience,
        public int $seatsAvailable,
        public string $status,
    ) {
    }
}
