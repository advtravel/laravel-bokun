<?php

namespace Adventures\LaravelBokun\GraphQL\Types;

enum BookingPaymentStatus: string
{
    case Deposit = 'DEPOSIT';
    case Free = 'FREE';
    case Invoices = 'INVOICED';
    case NotPaid = 'NOT_PAID';
    case PaidInFull = 'PAID_IN_FULL';
}
