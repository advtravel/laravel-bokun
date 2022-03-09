<?php

namespace Adventures\LaravelBokun\GraphQL\DTOs;

use Adventures\LaravelBokun\ArrayOf;

class CustomerInvoice extends DTO
{
    public function __construct(
        public int $id,
        public float $totalDue,
        #[ArrayOf(ProductInvoice::class)]
        public ?array $productInvoices = null,
        #[ArrayOf(CustomLineItem::class)]
        public ?array $customLineItems = null,
        public ?Customer $recipient = null,
        public ?string $currency = null,
        public ?Vendor $issuer = null,
    ) {
    }
}
