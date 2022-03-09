<?php

namespace Adventures\LaravelBokun\GraphQL\Types;

enum ExperienceAvailabilityStatus: string
{
    case SoldOut = 'SOLD_OUT';
    case Available = 'AVAILABLE';
}
