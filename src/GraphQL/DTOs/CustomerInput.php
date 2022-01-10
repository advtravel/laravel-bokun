<?php

namespace Adventures\LaravelBokun\GraphQL\DTOs;

class CustomerInput extends DTO
{
    public function __construct(
        public string $firstName,
        public string $lastName,
        public string $emailAddress,
        public ?string $phoneNumber = null
    ) {
    }
}
