<?php
// config for Adventures/LaravelBokun

return [
    'api_id' => env('BOKUN_ID'),
    'api_secret' => env('BOKUN_SECRET'),
    'scope' => 'BOOKINGS_READ,CHECKOUTS_READ,CUSTOMERS_READ,CUSTOMERS_CONTACT_READ,PRODUCTS_READ',
    'domain' => env('BOKUN_DOMAIN', '%s.bokuntest.com'),
    'operator_default_logo_url' => env('BOKUN_OPERATOR_DEFAULT_LOGO_URL'),
];