<?php

namespace Adventures\LaravelBokun\GraphQL\DTOs;

class ExperienceSortInput extends DTO
{
    public function __construct(
        public string $orderBy = '',
        public bool $descending = false,
    ) {
    }
}
