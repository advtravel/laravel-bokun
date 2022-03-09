<?php

namespace Adventures\LaravelBokun\GraphQL\DTOs;

use Adventures\LaravelBokun\ArrayOf;

class ProductInvoice extends DTO
{
    public function __construct(
        public int $id,
        public float $totalInvoiceAmount,
        public string $name,
        #[ArrayOf(CustomLineItem::class)]
        public array $customLineItems,
        #[ArrayOf(Fee::class)]
        public array $fees,
        #[ArrayOf(LineItem::class)]
        public array $lineItems,
    ) {
    }
}
