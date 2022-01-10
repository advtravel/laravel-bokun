<?php

namespace Adventures\LaravelBokun\GraphQL\DTOs;

class PassengerBookingDataInput extends DTO
{
    public function __construct(
        public int $bookingId,
        public CustomerInput $passenger,
    ) {
    }
}
