<?php

namespace Adventures\LaravelBokun\GraphQL\Queries;

use Adventures\LaravelBokun\GraphQL\BokunHelpers;
use Adventures\LaravelBokun\GraphQL\Query;

class GetBookingByIdQuery extends Query
{
    public function getName(): string
    {
        return 'booking';
    }

    public function getValidInputs(): array
    {
        return [
            'id' => 'string'
        ];
    }

    public function withId(int $booking_id): static
    {
        $id = BokunHelpers::toID('Booking', $booking_id);

        return $this->withArgument('id', $id);
    }
}
