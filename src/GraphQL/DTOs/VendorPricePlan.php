<?php

namespace Adventures\LaravelBokun\GraphQL\DTOs;

class VendorPricePlan extends DTO
{
    public function __construct(
        public ?AppPricePlan $pricePlan = null,
    ) {
    }
}
