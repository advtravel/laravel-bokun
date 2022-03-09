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
        public string $reference,
        public Experience $experience,
        public int $zonedStartDateAndTime,
        public int $totalPassengerCount,
        public int $totalSeatsOccupied,
        public ExperienceStartTime $startTime,
        #[ArrayOf(PassengerBooking::class)]
        public array $passengers,
        public ?BookingStatus $bookingStatus = null,
    ) {
    }
}
