<?php

namespace Adventures\LaravelBokun\GraphQL\DTOs;

use Adventures\LaravelBokun\GraphQL\Types\ExperienceSortField;

class ExperienceSortInput extends DTO
{
    public function __construct(
        public ?ExperienceSortField $orderBy = null,
        public bool $descending = false,
    ) {
    }
}
