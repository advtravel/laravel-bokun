<?php

namespace Adventures\LaravelBokun;

use Adventures\LaravelBokun\Commands\LaravelBokunCommand;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class LaravelBokunServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('laravel-bokun')
            ->hasConfigFile()
            ->hasViews()
            ->hasMigration('create_laravel-bokun_table')
            ->hasCommand(LaravelBokunCommand::class);
    }
}
