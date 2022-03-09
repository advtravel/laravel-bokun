<?php

namespace Adventures\LaravelBokun\GraphQL\Types;

enum BookingRole: string
{
    case Seller = 'SELLER';
    case Supplier = 'SUPPLIER';
    case ComboSupplier = 'COMBO_SUPPLIER';
    case OtaSeller = 'OTA_SELLER';
    case OtaSupplier = 'OTA_SUPPLIER';
    case Affiliate = 'AFFILIATE';
    case Customer = 'CUSTOMER';
    case None = 'NONE';
}
