<?php

namespace Adventures\LaravelBokun\GraphQL\DTOs;

class BookingDataInput extends DTO
{
    /**
     * @param array<ExperienceBookingDataInput> $experienceBookingData
     */
    public function __construct(
        public CustomerInput $customer,
        public array $experienceBookingData
    ) {  
    }
}
