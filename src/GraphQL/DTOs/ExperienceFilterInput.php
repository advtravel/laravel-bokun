<?php

namespace Adventures\LaravelBokun\GraphQL\DTOs;

class ExperienceFilterInput extends DTO
{
    public function __construct(
        public int $supplierId,
        public string $searchTerm = '',
        public ?string $lastModifiedAfter = null,
        public ?string $vendorRole = null,
        public bool $activated = true
    ) {
    }
}
