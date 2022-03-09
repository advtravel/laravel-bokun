<?php

namespace Adventures\LaravelBokun\GraphQL\DTOs;

use Adventures\LaravelBokun\GraphQL\Types\CustomLineItemType;

class CustomLineItem extends DTO
{
    public function __construct(
        public int $id,
        public float $unitPrice,
        public int $quantity,
        public ?string $name = null,
        public ?CustomLineItemType $type = null,
    ) {
    }
}
