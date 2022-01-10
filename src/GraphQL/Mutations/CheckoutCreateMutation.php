<?php

namespace Adventures\LaravelBokun\GraphQL\Mutations;

use Adventures\LaravelBokun\GraphQL\DTOs\CheckoutCreateInput;

class CheckoutCreateMutation extends Mutation
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
