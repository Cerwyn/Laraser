# Laraser

[![Latest Version on Packagist](https://img.shields.io/packagist/v/cerwyn/laraser.svg?style=flat-square)](https://packagist.org/packages/cerwyn/laraser)
[![Build Status](https://img.shields.io/travis/cerwyn/laraser/master.svg?style=flat-square)](https://travis-ci.org/cerwyn/laraser)
[![Quality Score](https://img.shields.io/scrutinizer/g/cerwyn/laraser.svg?style=flat-square)](https://scrutinizer-ci.com/g/cerwyn/laraser)
[![Total Downloads](https://img.shields.io/packagist/dt/cerwyn/laraser.svg?style=flat-square)](https://packagist.org/packages/cerwyn/laraser)

Simply remove your soft deleted data

## Installation

You can install the package via composer:

```bash
composer require cerwyn/laraser
```

## Usage
Publish the configuration
``` php
php artisan vendor:publish --tag=laraser
```
Then ```php artisan laraser:remove``` to start removing the soft deleted data

### Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

### Security

If you discover any security related issues, please email cerwyneliata.c@gmail.com instead of using the issue tracker.

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
