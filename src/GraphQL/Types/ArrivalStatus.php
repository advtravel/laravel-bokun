<?php

namespace Adventures\LaravelBokun\GraphQL\Types;

enum ArrivalStatus: string
{
    case NotSet = 'NOT_SET';
    case Arrived = 'ARRIVED';
    case NoShow = 'NO_SHOW';
}
