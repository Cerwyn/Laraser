# Laraser

[![Latest Version on Packagist](https://img.shields.io/packagist/v/cerwyn/laraser.svg?style=flat-square)](https://packagist.org/packages/cerwyn/laraser)
[![Build Status](https://img.shields.io/travis/cerwyn/laraser/master.svg?style=flat-square)](https://travis-ci.org/cerwyn/laraser)
[![Quality Score](https://img.shields.io/scrutinizer/g/cerwyn/laraser.svg?style=flat-square)](https://scrutinizer-ci.com/g/cerwyn/laraser)
[![Total Downloads](https://img.shields.io/packagist/dt/cerwyn/laraser.svg?style=flat-square)](https://packagist.org/packages/cerwyn/laraser)

Simply Hard Delete your soft deleted data

## Installation

You can install the package via composer:

```bash
composer require cerwyn/laraser
```

## Usage
1. Publish the configuration
``` php
php artisan vendor:publish --tag=laraser
```
2. The configuration should look like this
```
[
    'remove_in' => 30, //days
    'only' => [
        'App\Models\User',
    ],
    'log' => true,
    'storage' => 'local'
];
```
The ```remove_in``` is the old of your soft deleted data that want to be deleted.
The ```only``` is the models that take effect. If you want to make all of your models take effect, then you should fill with ```['*']```
The ```log``` is whether you want to log the data before being removed
The ```storage``` is where you want your log to be stored. If you want to have another place to save your log data, you should add another disks inside ```config/filesystems.php```
```
'disks' => [
        // Add new disks
        'laraser' => [
            'driver' => 'local',
            'root' => storage_path('app/laraser'),
        ],
```
Then inside the laraser configuration file, 
```
'storage' => 'laraser',
```
3. Then you can schedule the command inside ```app/Console/Kernel.php```
```
protected function schedule(Schedule $schedule)
{
    $schedule->command('laraser:remove')->weekly();
}
```
4. Or run the ```php artisan laraser:remove``` manually, to start removing your soft deleted data based on your configuration

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.