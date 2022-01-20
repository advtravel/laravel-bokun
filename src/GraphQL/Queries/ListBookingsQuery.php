<?php

namespace Adventures\LaravelBokun\GraphQL\Queries;

use Adventures\LaravelBokun\GraphQL\DTOs\BookingFilterInput;
use Adventures\LaravelBokun\GraphQL\DTOs\BookingSortInput;
use Adventures\LaravelBokun\GraphQL\PagedQuery;

class ListBookingsQuery extends PagedQuery
{
    public function getName(): string
    {
        return 'bookings';
    }

    public function getValidInputs(): array
    {
        return [
            'sort' => BookingSortInput::class,
            'filter' => BookingFilterInput::class,
        ] + parent::oneWayPagedValidInputs();
    }
}
