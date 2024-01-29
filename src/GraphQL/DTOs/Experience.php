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
        #[ArrayOf(PickupPlace::class)]
        public ?array $pickupPlaces = null,
        public ?bool $pickupAllowsCustomLocation = null,
        public ?bool $pickupCapacityLimited = null,
        public ?int $pickupMinutesBefore = null,
        public ?bool $pickupService = null,
        public ?bool $pickupTimeIsLocationBased = null,
        public ?int $pickupTimeWindowInMinutes = null,
        public ?bool $privateExperience = null,
    ) {
    }
}
