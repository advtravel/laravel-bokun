<?php

namespace Adventures\LaravelBokun\GraphQL\DTOs;

use Adventures\LaravelBokun\ArrayOf;

class Experience extends DTO
{
    public function __construct(
        public int $id,
        public string $productCode,
        public string $name,
        public string $timeZone,
        public Supplier $supplier,
        #[ArrayOf(ExperienceStartTime::class)]
        public ?array $startTimes = null
    ) {
    }
}
