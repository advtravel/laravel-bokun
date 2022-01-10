<?php

namespace Adventures\LaravelBokun\GraphQL\Mutations;

use Adventures\LaravelBokun\GraphQL\DTOs\CheckoutCompleteInput;

class CheckoutCompleteMutation extends Mutation
{
    public function getName(): string
    {
        return 'checkoutComplete';
    }

    public function getValidInputs(): array
    {
        return [
            'id' => 'string',
            'input' => CheckoutCompleteInput::class,
        ];
    }
}
