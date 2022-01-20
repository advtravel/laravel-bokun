<?php

namespace Adventures\LaravelBokun\GraphQL\DTOs;

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
        public string $bookingStatus,
        public int $zonedStartDateAndTime,
        public int $totalPassengerCount,
        public int $totalSeatsOccupied,
        public Experience $experience,
    ) {
    }
}
