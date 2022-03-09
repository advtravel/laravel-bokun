<?php

namespace Adventures\LaravelBokun\GraphQL\Types;

enum ProductVendorRole: string
{
    case Supplier = 'SUPPLIER';
    case Reseller = 'RESELLER';
}
