# Laravel Bókun Appstore connector

Adds support for the Bókun appstore and GraphQL API to a laravel installation.

## Installation

You can install the package via composer:

```bash
composer require advtravel/laravel-bokun
```

You can publish the config file with:

```bash
php artisan vendor:publish --tag="laravel-bokun-config"
```

This is the contents of the published config file:

```php
return [
];
```

## Usage

```php
$laravel-bokun = new Adventures\LaravelBokun();
echo $laravel-bokun->echoPhrase('Hello, Adventures!');
```

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Credits

- [Florian Stascheck](https://github.com/levu42)
