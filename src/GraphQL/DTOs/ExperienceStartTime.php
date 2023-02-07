<?php

namespace Adventures\LaravelBokun\GraphQL\DTOs;

use DateInterval;

class ExperienceStartTime extends DTO
{
    public function __construct(
        public int $id,
        public ?string $time = null,
        public ?string $duration = null,
        public ?string $isoDuration = null,
    ) {
    }

    public function getDurationInSeconds(): int
    {
        if (is_null($this->isoDuration)) {
            return 0;
        }

        $interval = new DateInterval($this->isoDuration);

        return ($interval->d * 24 * 3600)
             + ($interval->h * 3600)
             + ($interval->m * 60)
             + $interval->s;
    }
}
