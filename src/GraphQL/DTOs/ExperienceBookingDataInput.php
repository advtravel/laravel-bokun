<?php

namespace Adventures\LaravelBokun\GraphQL\DTOs;

class ExperienceBookingDataInput extends DTO
{
    /**
     * @param array<PassengerBookingDataInput> $passengerBookingData
     */
    public function __construct(
        public int $bookingId,
        public ?array $passengerBookingData = null,
    )
    {
    }
}
