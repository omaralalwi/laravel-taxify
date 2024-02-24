# Laravel Taxify

Laravel Taxify provides a set of helper functions and classes to simplify tax (VAT) calculations within Laravel applications. that allow developers to easily integrate tax calculation functionalities into their projects with multi tax profiles settings and (fixed, percentage) ways. it's offers a straightforward and efficient solution Designed to streamline the process of handling taxes.

### Note: this package still under development.

## Installation

You can install the package via Composer:

```bash
composer require omaralalwi/laravel-taxify
````

## Usage

#### config keys EX: (Optional)

add these default config keys to env file , also add any additional config keys as needed.
it's up to you, if you did not add them, the default values will taken (default profile `default`, default rate `0.10` (10%) , default type `percentage`)
```json
DEFAULT_TAXIFY_PROFILE="default"
TAXIFY_DEFAULT_RATE="0.10"
TAXIFY_DEFAULT_TYPE="percentage"
```

OR like this if the type `fixed`.

```json
DEFAULT_TAXIFY_PROFILE="default"
TAXIFY_DEFAULT_RATE=50
TAXIFY_DEFAULT_TYPE="fixed"
```

**Note** the `TAXIFY_DEFAULT_RATE` , it is number alternate of rate number in second case, because the `type` is `fixed`.

#### Examples usage

- get Tax Amount as number
- ```json
$amount = 250;
getTaxAmount($amount);
// Result : 25
```

- get Tax Rate or amount (according to tax profile type in config file)

```json
getTaxRate()
// retuls 0.1
```

```json
getTaxRate('profileName')
// retuls if profile tax type is fixed will return the amount , else will return the rate
```
- get Tax Type
```json
getTaxType('profileName')
// Result: fixed or percentage // according to profile settings
```

- get Tax As object (default)
by default the function return result as object
```json
$amount = 250;
$tax = calculateTax($amount,'profileName'); // profileName is optional
```
Result
```
    amount_with_tax: 275
    tax_amount: 25
    tax_rate: 0.1
```
access it as object property
```json
$taxAmount = $tax->tax_amount
// 25
$AmountWithTax = $tax->amount_with_tax
// 275
$taxRate = $tax->tax_rate
// 0.1
```

Or simpilify
```json
$amount = 250;
$taxAmount = calculateTax($amount,'profileName')->tax_amount; // profileName is optional
```

- get Tax As Array
you can pass $asArray param as true to get result as array
```json
$amount = 250;
$tax = calculateTax($amount,'profileName',true); // profileName is profile name param
```
Result
```
  array (
    'amount_with_tax' => 220.0,
    'tax_amount' => 20.0,
    'tax_rate' => 0.1,
  );
```
access it as object property
```json
$taxAmount = $tax['tax_amount']
 // 25
$AmountWithTax = $tax['amount_with_tax']
// 275
$taxRate = $tax['tax_rate']
// 0.1
```

Or simpilify
```json
$amount = 250;
$taxAmount = calculateTax($amount,'',true)['tax_amount']; // the second param refer to profile, we mad it null to take default profile
```
like calculateTax but this for a many amounts .
- get a tax for a collection of amounts by passing amounts as array (first param).
```json
// you can pass number as float or integer
$productAmount = 250;
$featureAmount = 70.5;
$sarrantyAmount = 30.60;
$chargeAmount = 90;

$tax = calculateTaxForCollection([$productAmount,$featureAmount, $sarrantyAmount, $chargeAmount]);
```
Result
```json
     'amount_with_tax' => 485.21,
     'tax_amount' => 44.11,
     'tax_rate' => 0.1,
```

access it as object property
```json
$taxAmount = $tax->tax_amount
// 485.21
$AmountWithTax = $tax->amount_with_tax
// 44.11
$taxRate = $tax->tax_rate
// 0.1
```

- get Tax Rate As Percentage
- you can get a tax rate percentage (for percentage type only)
```json 
 getTaxRateAsPercentage(); // for default profile no need to pass it
```
Result
```json
'10.00%'
```

### Testing

```bash
composer test
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

-   [omar alalwi](https://github.com/omaralalwi)
-   [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
