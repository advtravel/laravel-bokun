<?php

namespace Adventures\LaravelBokun\GraphQL\Types;

enum CustomLineItemType: string
{
    case BookingFee = 'BOOKING_FEE';
    case RefundProtectionFee = 'REFUND_PROTECTION_FEE';
    case OtaSale = 'OTA_SALE';
    case CustomPrice = 'CUSTOM_PRICE';
    case Discount = 'DISCOUNT';
    case CancellationFee = 'CANCELLATION_FEE';
    case Other = 'OTHER';
}
