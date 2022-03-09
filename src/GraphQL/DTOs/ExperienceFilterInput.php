<?php

namespace Adventures\LaravelBokun\GraphQL\DTOs;

use Adventures\LaravelBokun\GraphQL\Types\ProductVendorRole;

class ExperienceFilterInput extends DTO
{
    public function __construct(
        public int $supplierId,
        public string $searchTerm = '',
        public ?string $lastModifiedAfter = null,
        public ?ProductVendorRole $vendorRole = null,
        public bool $activated = true
    ) {
    }
}
