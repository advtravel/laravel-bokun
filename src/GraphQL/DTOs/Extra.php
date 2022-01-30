<?php

namespace Adventures\LaravelBokun\GraphQL\DTOs;

class Extra extends DTO
{
    public function __construct(
        public int $id,
        public ?string $productCode = null,
        public ?string $name = null,
        public ?string $description = null,
    ) {
    }
}
