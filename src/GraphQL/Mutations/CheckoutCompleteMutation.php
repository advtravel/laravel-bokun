<?php

namespace Adventures\LaravelBokun\GraphQL\Mutations;

use Adventures\LaravelBokun\GraphQL\DTOs\CheckoutCompleteInput;
use Adventures\LaravelBokun\GraphQL\Query;

class CheckoutCompleteMutation extends Query
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
