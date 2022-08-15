<?php

namespace Adventures\LaravelBokun\GraphQL\DTOs;

use Adventures\LaravelBokun\ArrayOf;

class Experience extends DTO
{
    public function __construct(
        public int $id,
        public ?string $productCode = null,
        public ?string $name = null,
        public ?string $timeZone = null,
        public ?Vendor $supplier = null,
        #[ArrayOf(ExperienceStartTime::class)]
        public ?array $startTimes = null,
        #[ArrayOf(ExperienceRate::class)]
        public ?array $rates = null,
        public ?ExperienceRate $defaultRate = null,
        public ?int $boxedExperienceId = null,
    ) {
    }
}
