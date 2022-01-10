<?php

namespace Adventures\LaravelBokun\GraphQL\DTOs;

class PassengerBookingCreateInput extends DTO
{
    public function __construct(
        public int $passengerCategoryId
    )
    {
    }
}
