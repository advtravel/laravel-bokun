<?php

namespace Adventures\LaravelBokun\GraphQL\Mutations;

class CheckoutReserveMutation extends Mutation
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
