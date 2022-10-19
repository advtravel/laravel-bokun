<?php

namespace Adventures\LaravelBokun\GraphQL\DTOs;

use Adventures\LaravelBokun\GraphQL\Types\AppPricePlanEnumType;

class AppPricePlan extends DTO
{
    public function __construct(
        public int $id,
        public string $name,
        public int $appId,
        public ?float $monthlyAmount = null,
        public ?float $yearlyAmount = null,
        public ?float $oneTimeAmount = null,
        public ?AppPricePlanEnumType $type = null,
    ) {
    }
}
