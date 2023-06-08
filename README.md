# laravel-custom-fields

[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE.md)
[![CircleCI](https://circleci.com/gh/OnrampLab/laravel-custom-fields.svg?style=shield)](https://circleci.com/gh/OnrampLab/laravel-custom-fields)
[![Total Downloads](https://img.shields.io/packagist/dt/onramplab/laravel-custom-fields.svg?style=flat-square)](https://packagist.org/packages/onramplab/laravel-custom-fields)

The purpose of this package is to enable custom field support for any Laravel models.

Custom fields can be utilized to extend a model and offer a more flexible approach for incorporating additional fields, without requiring the addition of new attributes to the database model.
## Requirements

- PHP >= 8;
- Laravel >= 8
- composer.

## Features

- PSR-4 autoloading compliant structure;
- PSR-2 compliant code style;
- Unit-Testing with PHPUnit 6;
- Comprehensive guide and tutorial;
- Easy to use with any framework or even a plain php file;
- Useful tools for better code included.

## Installation

Install the package via composer

```
composer require onramplab/laravel-custom-fields
```
Publish migration files and run command to build tables needed in the package

```
 php artisan vendor:publish --tag="custom-fields-migrations"
```

## Usage


## Running Tests:

    composer test


## Contributing

1. Fork it.
2. Create your feature branch (git checkout -b my-new-feature).
3. Make your changes.
4. Run the tests, adding new ones for your own code if necessary (phpunit).
5. Commit your changes (git commit -am 'Added some feature').
6. Push to the branch (git push origin my-new-feature).
7. Create new pull request.

Also please refer to [CONTRIBUTION.md](https://github.com/Onramplab/laravel-custom-fields/blob/master/CONTRIBUTION.md).

## License

Please refer to [LICENSE](https://github.com/Onramplab/laravel-custom-fields/blob/master/LICENSE).
