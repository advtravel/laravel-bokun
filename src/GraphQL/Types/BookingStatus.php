<?php

namespace Adventures\LaravelBokun\GraphQL\Types;

enum BookingStatus: string
{
    case Cart = 'Cart';
    case Requested = 'Requested';
    case Reserved = 'Reserved';
    case Confirmed = 'Confirmed';
    case Timeout = 'Timeout';
    case Aborted = 'Aborted';
    case Cancelled = 'Cancelled';
    case Error = 'Error';
    case Arrived = 'Arrived';
    case NoShow = 'NoShow';
    case Rejected = 'Rejected';
}
