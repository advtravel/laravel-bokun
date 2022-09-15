<?php

namespace Adventures\LaravelBokun\GraphQL\DTOs;

use Adventures\LaravelBokun\GraphQL\Types\ProductLineItemType;
use Adventures\LaravelBokun\GraphQL\Types\TicketCategory;

class LineItem extends DTO
{
    public function __construct(
        public int $id,
        public float $unitPrice,
        public int $quantity,
        // public ?TicketCategory $ticketCategory = null,
        public ?string $name = null,
        public ?ProductLineItemType $type = null,
    ) {
    }
}
