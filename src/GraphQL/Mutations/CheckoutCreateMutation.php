<?php

namespace Adventures\LaravelBokun\GraphQL\Mutations;

use Adventures\LaravelBokun\GraphQL\DTOs\CheckoutCreateInput;
use Adventures\LaravelBokun\GraphQL\Query;

class CheckoutCreateMutation extends Query
{
    public function getName(): string
    {
        return "checkoutCreate";
    }

    public function getValidInputs(): array
    {
        return [
            'input' => CheckoutCreateInput::class,
        ];
    }
}
