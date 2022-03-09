<?php

namespace Adventures\LaravelBokun\GraphQL\DTOs;

use DateInterval;

class ExperienceStartTime extends DTO
{
    public function __construct(
        public int $id,
        public ?string $time = null,
        public ?string $duration = null,
    ) {
    }

    public function getDurationInSeconds(): int
    {
        $interval = new DateInterval($this->duration);

        return ($interval->d * 24 * 3600)
             + ($interval->h * 3600)
             + ($interval->m * 60)
             + $interval->s;
    }
}
