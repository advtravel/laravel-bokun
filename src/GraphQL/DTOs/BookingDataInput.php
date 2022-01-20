<?php

namespace Adventures\LaravelBokun\GraphQL\DTOs;

use Adventures\LaravelBokun\ArrayOf;
use Adventures\LaravelBokun\GraphQL\DTOs\ExperienceBookingDataInput;

class BookingDataInput extends DTO
{
    public function __construct(
        public CustomerInput $customer,
        #[ArrayOf(ExperienceBookingDataInput::class)]
        public array $experienceBookingData
    ) {
    }
}
