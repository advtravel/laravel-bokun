<?php

namespace Adventures\LaravelBokun\GraphQL\Types;

enum AppPricePlanEnumType: string
{
    case Free = 'FREE';
    case OneTimeCharge = 'ONE_TIME_CHARGE';
    case MonthlyCharge = 'MONTHLY_CHARGE';
    case YearlyCharge = 'YEARLY_CHARGE';
}
