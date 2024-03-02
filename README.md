# Laravel Taxify

<p align="center">
  <a href="https://omaralalwi.github.io/laravel-taxify" target="_blank">
    <img src="https://raw.githubusercontent.com/omaralalwi/laravel-taxify/master/public/images/taxify.jpg" alt="Laravel Taxify">
  </a>
</p>

Laravel Taxify provides a set of helper functions and classes to simplify tax (VAT) calculations within Laravel applications. that allow developers to easily integrate tax calculation functionalities into their projects with multi tax profiles settings and (fixed, percentage) ways. it's offers a straightforward and efficient solution Designed to streamline the process of handling taxes.

## [Documentation](https://omaralalwi.github.io/laravel-taxify)

## Installation

You can install latest stable version of package via Composer:

**Note**: version2.0.x support Laravel v8.x and Later , and PHPv8.0.x and up, if your app use older version , please see Compatibility section.
```bash
composer require omaralalwi/laravel-taxify
````

publish all package resource

```markdown
php artisan vendor:publish --provider="Omaralalwi\LaravelTaxify\LaravelTaxifyServiceProvider"
```

publish only config file
```markdown
php artisan vendor:publish --tag=laravel-taxify-config
```

## Features

- Calculate tax for individual amounts or a collection of amounts
- Retrieve tax amount, rate, and type for any profile as individual.
- Retrieve tax `amount_with_tax` and `tax_amount`  and `tax_rate` for any profile as individual for one amount or a collection of amounts
- Get tax rate as a percentage (for percentage type only)
- Customizable configuration options through environment variables easy.
- helper functions easy-to-use.
- support all php and laravel versions.
- Exception Handling: Robust error handling to ensure smooth operation and easy debugging.
- Logging: Automatic logging of errors and exceptions for better error tracking and debugging.
- Unit Tests.

### Testing

```bash
php artisan test --filter TaxifyTest
```

### Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## TODO
this todo list , contain the tasks that we planning to working on them, you can choose one of them and develop it if you want to contribute.

### Security

If you discover any security related issues, please email `omaralwi2010@gmail.com`.

## Credits

-   [omar alalwi](https://omaralalwi.info)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
