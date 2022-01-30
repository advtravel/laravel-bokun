<?php

namespace Adventures\LaravelBokun\GraphQL\DTOs;

use Adventures\LaravelBokun\ArrayOf;

class PassengerBooking extends DTO
{
    public function __construct(
        public int $id,
        public PassengerCategory $category,
        public ?Customer $passengerInfo,
        public ?string $externalReference = null,
        #[ArrayOf(ExtraBooking::class)]
        public ?array $extras = null,
        #[ArrayOf(ExperienceQuestionAnswer::class)]
        public ?array $passengerQuestions = null,
        #[ArrayOf(ExperienceQuestionAnswer::class)]
        public ?array $bookingQuestions = null,
    ) {
    }
}
