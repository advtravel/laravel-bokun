<?php

namespace Adventures\LaravelBokun\GraphQL\DTOs;

use Adventures\LaravelBokun\GraphQL\Types\FeeTitle;

class Fee extends DTO
{
    public function __construct(
        public float $amount,
        public ?FeeTitle $name = null,
    ) {
    }
}
