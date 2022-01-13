<?php

namespace Adventures\LaravelBokun\GraphQL\Mutations;

use Adventures\LaravelBokun\GraphQL\Query;

class CheckoutReserveMutation extends Query
{
    public function getName(): string
    {
        return 'checkoutReserve';
    }

    public function getValidInputs(): array
    {
        return ['id' => 'string'];
    }
}
