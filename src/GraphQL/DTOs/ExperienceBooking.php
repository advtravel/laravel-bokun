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
        public BookingStatus $bookingStatus,
        public int $zonedStartDateAndTime,
        public int $totalPassengerCount,
        public int $totalSeatsOccupied,
        public ExperienceStartTime $startTime,
        public Experience $experience,
        #[ArrayOf(PassengerBooking::class)]
        public array $passengers,
    ) {
    }
}
