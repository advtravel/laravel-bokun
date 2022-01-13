<?php

namespace Adventures\LaravelBokun\GraphQL\DTOs;

class ExperienceBooking extends DTO
{
    public function __construct(
        public int $id,
        public string $reference,
        public string $bookingStatus,
        public string $zonedStartDate,
        public int $totalPassengerCount,
        public int $totalSeatsOccupied,
    ) {
    }
}
