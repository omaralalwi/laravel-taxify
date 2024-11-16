# Laravel Taxify

<p align="center">
  <a href="https://github.com/omaralalwi/laravel-taxify" target="_blank">
    <img src="https://raw.githubusercontent.com/omaralalwi/laravel-taxify/master/public/images/taxify.jpg" alt="Laravel Taxify">
  </a>
</p>

Laravel Taxify provides a set of helper functions and classes to simplify tax (VAT) calculations within Laravel applications. that allow developers to easily integrate tax calculation functionalities into their projects with multi tax profiles settings and (fixed, percentage) ways. it's offers a straightforward and efficient solution Designed to streamline the process of handling taxes.
## Requirements
`Laravel 8.x or up` , for version 2.x .

## Installation

```bash
composer require omaralalwi/laravel-taxify
```
publish the package's configuration file:

```php
php artisan vendor:publish --tag=laravel-taxify-config
```

## Compatibility

For applications running Laravel versions `7.x` and older, use version `1.0.4`.

```bash
composer require omaralalwi/laravel-taxify:^1.0.4
```

## Usage

### Available Helper Functions

laravel taxify many of helper functions to simplify usage.

- `calculateTax()`.
- `calculateTaxForCollection()`.
- `getTaxAmount()` .
- `getTaxRate()` .
- `getTaxType()` .
- `getTaxRateAsPercentage()` .

---

### calculate tax for an amount:

- use `calculateTax` to get Tax As object (default).

```php
$amount = 250;
$taxAmount = calculateTax($amount,'profileName')->tax_amount; // 37.5
````

---

**Another way to get Detailed Result**.
```php
$amount = 250;
$tax = calculateTax($amount,'profileName');
```
Result (Object)
```php
 $tax = {
    "amount_with_tax": 287.5,
    "tax_amount": 37.5,
    "tax_rate": 0.15,
  }
```
---

**Another way**  you can pass $asArray (third param) as true to get result as array
```php
$amount = 250;
$tax = calculateTax($amount,'profileName',true);
```
Result
```
$tax = [
    "amount_with_tax" => 287.5,
    "tax_amount" => 37.5,
    "tax_rate" => 0.15,
  ]
```

---
**Another way get tax_amount only , as array**
```php
$amount = 250;
$taxAmount = calculateTax($amount,'',true)['tax_amount'];
```

**Note**: the second param refer to profile, we mad it null to take default profile, second param can take (`default`, null,''') all three values mean `default`.

---
### Calculate tax for a collection of amounts:

like calculateTax but this for a many amounts .

- use `calculateTaxForCollection` to get a tax for a collection of amounts by passing amounts as array (first param) -> Result wanted as object (default).

```php
// you can pass number as float or integer
$productAmount = 250;
$featureAmount = 70.5;
$sarrantyAmount = 30.60;
$chargeAmount = 90;

$tax = calculateTaxForCollection([$productAmount,$featureAmount, $sarrantyAmount, $chargeAmount]);
```
Result (object)
```php
$tax = {
    "amount_with_tax": 507.265,
    "tax_amount": 66.165,
    "tax_rate": 0.15,
  }
```
```php
$taxAmount = $tax->tax_amount // 507.265
```

to get a tax for a collection of amounts as array result , just pass third param as `true` like this.

```php
$tax = calculateTaxForCollection([$productAmount,$featureAmount, $sarrantyAmount, $chargeAmount],'',true);
```
Result (array)
```php
$tax = [
    "amount_with_tax" => 507.265,
    "tax_amount" => 66.165,
    "tax_rate" => 0.15,
  ]
```
---

### Get Tax Amount as numeric value

- use `getTaxAmount` to get Tax Amount as number

```php
$amount = 250;
getTaxAmount($amount); // Result 25
```

---

### Get tax rate or tax amount:

- use `getTaxRate` to get Tax Rate or amount (according to tax type for specified profile in config file)

```php
getTaxRate()
// Result 0.15
```

```php
getTaxRate('sales') // fore specific profile
// Result 50 , here the result is fixed number because the profile type is fixed amount Not percentage
```

if profile tax type is `fixed` will return the amount (read the tax rate as amount), else will return the tax rate.

**Note**: for default profile no need to pass `profileName.

---

### Get tax type:

- use `getTaxType` to you can get Tax Type

```php
getTaxType('profileName')
// Result: fixed or percentage // depend on profile settings
```
---

### Get tax rate as Percentage number (10%, 15%) - for percentage profiles Only:

you can get Tax Rate As Percentage
- you can get a tax rate percentage (for percentage type only)

```php 
getTaxRateAsPercentage();  // Result '10.00%'
```

**Note**: for default profile no need to pass it

## Configuration

### Environment Variables
after you published config file .

You can configure Laravel Taxify by adding the following default configuration keys to your `.env` file. If you do not add these, the default values will be used.

For a percentage tax type:

```dotenv
DEFAULT_TAXIFY_PROFILE="default"
TAXIFY_DEFAULT_RATE="0.10"
TAXIFY_DEFAULT_TYPE="percentage"
```

example configuration for fixed tax type:

```dotenv
DEFAULT_TAXIFY_PROFILE="default"
TAXIFY_DEFAULT_RATE=50
TAXIFY_DEFAULT_TYPE="fixed"
```

**Note:** The `TAXIFY_DEFAULT_RATE` is a number representing the rate when the type is `percentage` or the amount when type is `fixed`.

You can add more than one of tax profile in config/taxify.php .

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

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## TODO
this todo list , contain the tasks that we planning to working on them, you can choose one of them and develop it if you want to contribute.

### Security

If you discover any security related issues, please email `omaralwi2010@gmail.com`.

## Credits

-   [omar alalwi](https://github.com/omaralalwi)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

---

 
## 📚 Helpful Open Source Packages

- <a href="https://github.com/omaralalwi/lexi-translate"><img src="https://raw.githubusercontent.com/omaralalwi/lexi-translate/master/public/images/lexi-translate-banner.jpg" width="26" height="26" style="border-radius:13px;" alt="lexi translate" /> Lexi Translate </a> simplify managing translations for multilingual Eloquent models with power of morph relationships and caching .
  
- <a href="https://github.com/omaralalwi/Gpdf"><img src="https://raw.githubusercontent.com/omaralalwi/Gpdf/master/public/images/gpdf-banner-bg.jpg" width="26" height="26" style="border-radius:13px;" alt="laravel Taxify" /> Gpdf </a> Open Source HTML to PDF converter for PHP & Laravel Applications, supports Arabic content out-of-the-box and other languages..

- <a href="https://github.com/omaralalwi/laravel-deployer"><img src="https://raw.githubusercontent.com/omaralalwi/laravel-deployer/master/public/images/deployer.jpg" width="26" height="26" style="border-radius:13px;" alt="laravel Deployer" /> **laravel Deployer** </a> Streamlined Deployment for Laravel and Node.js apps, with Zero-Downtime and various environments and branches.

- <a href="https://github.com/omaralalwi/laravel-trash-cleaner"><img src="https://raw.githubusercontent.com/omaralalwi/laravel-trash-cleaner/master/public/images/laravel-trash-cleaner.jpg" width="26" height="26" style="border-radius:13px;" alt="laravel Trash Cleaner" /> **laravel Trash Cleaner** </a>clean logs and debug files for debugging packages.

- <a href="https://github.com/omaralalwi/laravel-time-craft"><img src="https://raw.githubusercontent.com/omaralalwi/laravel-time-craft/master/public/images/laravel-time-craft.jpg" width="26" height="26" style="border-radius:13px;" alt="laravel Trash Cleaner" /> **laravel Time Craft** </a>simple trait and helper functions that allow you, Effortlessly manage date and time queries in Laravel apps.

- <a href="https://github.com/omaralalwi/laravel-startkit"><img src="https://raw.githubusercontent.com/omaralalwi/laravel-startkit/master/public/screenshots/backend-rtl.png" width="26" height="26" style="border-radius:13px;" alt="Laravel Startkit" /> **Laravel Startkit** </a>  Laravel Admin Dashboard, Admin Template with Frontend Template, for scalable Laravel projects.

