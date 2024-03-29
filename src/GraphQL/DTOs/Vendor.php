<?php

namespace Adventures\LaravelBokun\GraphQL\DTOs;

class Vendor extends DTO
{
    public function __construct(
        public int $id,
        public string $name,
        public string $domain,
        public string $bookingPrefix,
        public ?string $description = null,
        public ?string $websiteUrl = null,
        public ?VendorPricePlan $pricing = null,
    ) {
    }
}
