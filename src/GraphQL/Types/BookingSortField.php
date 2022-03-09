<?php

namespace Adventures\LaravelBokun\GraphQL\Types;

enum BookingSortField: string
{
    case CreatedDate = 'CREATED_DATE';
    case TravelDate = 'TRAVEL_DATE';
}
