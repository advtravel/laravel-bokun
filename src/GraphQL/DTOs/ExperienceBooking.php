<?php

namespace Adventures\LaravelBokun\GraphQL\DTOs;

use Adventures\LaravelBokun\ArrayOf;
use Adventures\LaravelBokun\GraphQL\Types\BookingStatus;

class ExperienceBooking extends DTO
{
    use HasTimeStamps;

    protected static function getTimeStampColumnNames(): array
    {
        return [
            'zonedStartDateAndTime',
        ];
    }

    public function __construct(
        public int $id,
        public ?int $zonedStartDateAndTime = null,
        public ?Experience $experience = null,
        #[ArrayOf(PassengerBooking::class)]
        public ?array $passengers = null,
        public ?int $totalPassengerCount = null,
        public ?int $totalSeatsOccupied = null,
        public ?string $reference = null,
        public ?ExperienceStartTime $startTime = null,
        public ?BookingStatus $bookingStatus = null,
    ) {
    }
}
