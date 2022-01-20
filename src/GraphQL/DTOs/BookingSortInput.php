<?php

namespace Adventures\LaravelBokun\GraphQL\DTOs;

class BookingSortInput extends DTO
{
    /**
     * @param string $bookingSortField either "CREATED_DATE" or "TRAVEL_DATE"
     */
    public function __construct(
        public ?string $bookingSortField = null,
        public bool $descending = false,
    ) {
    }
}
