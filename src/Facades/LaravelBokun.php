<?php

namespace Adventures\LaravelBokun\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Adventures\LaravelBokun\LaravelBokun
 */
class LaravelBokun extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'laravel-bokun';
    }
}
