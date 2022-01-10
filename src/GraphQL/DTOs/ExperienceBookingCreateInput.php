<?php

namespace Adventures\LaravelBokun\GraphQL\DTOs;

class ExperienceBookingCreateInput extends DTO
{
    /**
     * @param array<PassengerBookingCreateInput> $passengers
     */
    public function __construct(
        public int $experienceId,
        public int $rateId,
        public int $startTimeId,
        public int $dateTimestamp,
        public array $passengers,
        public ?int $pickupPlaceId = null,
        public ?int $dropoffPlaceId = null,
    )
    {
    }
}
