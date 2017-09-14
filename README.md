# ObserverMaker

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Software License][ico-license]](LICENSE.md)
[![Total Downloads][ico-downloads]][link-downloads]


ObserverMaker creates an artisan command that lets you quickly create a observer stub.

## Install

Via Composer

```
composer require ajayexpert/artisan-observer-maker
```

In your app/config/app.php file, add the following to the providers array:

```
AjayExpert\ObserverMaker\ObserverMakerServiceProvider::class,
```

## Usage

Once installed, you should see make:observer as one of the artisan commands when you run:

```
php artisan list
```

To use this command, supply it with two arguments, the first being the name of the observer, and the 
second being the name of the folder you want it to reside in.  If the folder does not exist, it will be created for you.

For example:

```
php artisan make:observer TestObserver
```

This would create a directory named Observers in your app directory with a php file
named TestObserver.php, which would contain the following stub:
   
```
<?php
namespace App\Observers;

use App\Test;

class TestObserver 
{
    
}
```

Please note, the package currently only supports observer folders that are in the app folder, for example:

```
app/Observers
```

Use Observers in laravel see the [Documentation](https://laravel.com/docs/5.5/eloquent#observers)

## Security

If you discover any security related issues, please email ajay.expert@live.com instead of using the issue tracker.

## Credits

- [Ajay Kumar](https://ajayexpert.github.io)


## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

[ico-version]: https://img.shields.io/packagist/v/ajayexpert/artisan-observer-maker.svg?style=flat-square
[ico-license]: https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square
[ico-travis]: https://img.shields.io/travis/ajayexpert/artisan-observer-maker/master.svg?style=flat-square
[ico-scrutinizer]: https://img.shields.io/scrutinizer/coverage/g/ajayexpert/artisan-observer-maker.svg?style=flat-square
[ico-code-quality]: https://img.shields.io/scrutinizer/g/ajayexpert/artisan-observer-maker.svg?style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/ajayexpert/artisan-observer-maker.svg?style=flat-square

[link-packagist]: https://packagist.org/packages/ajayexpert/artisan-observer-maker
[link-downloads]: https://packagist.org/packages/ajayexpert/artisan-observer-maker/stats
[link-author]: https://github.com/ajayexpert

