<?php

namespace Adventures\LaravelBokun\GraphQL\DTOs;

class Customer extends DTO
{
    public function __construct(
        public int $id,
        public ?string $firstName = null,
        public ?string $lastName = null,
        public ?string $emailAddress = null,
        public ?string $phoneNumber = null,
    ) {
    }
}
