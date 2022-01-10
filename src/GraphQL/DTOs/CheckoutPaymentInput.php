<?php

namespace Adventures\LaravelBokun\GraphQL\DTOs;

class CheckoutPaymentInput extends DTO
{
    public function __construct(
        public float $amount,
        public ?string $currencyCode = null,
        public ?string $identifier = null,
    ) {
    }
}
