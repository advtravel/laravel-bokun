<?php

namespace Adventures\LaravelBokun\GraphQL\DTOs;

class CheckoutCreateInput extends DTO
{
    /**
     * @param array<ExperienceBookingCreateInput> $experiences
     */
    public function __construct(
        public array $experiences,
        public ?string $email = null,
    ) {
    }
}
