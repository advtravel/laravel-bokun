<?php

namespace Adventures\LaravelBokun\GraphQL\DTOs;

use Adventures\LaravelBokun\GraphQL\Types\BookingSortField;

class BookingSortInput extends DTO
{
    public function __construct(
        public ?BookingSortField $bookingSortField = null,
        public bool $descending = false,
    ) {
    }
}
