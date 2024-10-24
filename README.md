# Invoicing Integration with Laravel

This is where your description should go. Limit it to a paragraph or two. Consider adding a small example.

We invest a lot of resources into creating [best in class open source packages](https://spatie.be/open-source). You can support us by [buying one of our paid products](https://spatie.be/open-source/support-us).

We highly appreciate you sending us a postcard from your hometown, mentioning which of our package(s) you are using. You'll find our address on [our contact page](https://spatie.be/about-us). We publish all received postcards on [our virtual postcard wall](https://spatie.be/open-source/postcards).

## Installation

Register it to use locally by changing your composer.json file to include

```bash
"repositories": [
  {
    "type": "path",
    "url": "../PATH/TO/REPO"
  }
],
```

You can install the package via composer:

```bash
composer require indigitpt/invoicing-interface
```

You can publish the config file with:

```bash
php artisan vendor:publish --tag="invoicing-config"
```

## Usage

Add the following to your AppServiceProvider

```php
use App\Services\Invoicing as InvoicingService;
use Indigit\Invoicing\Invoicing;

public function register()
{
    $this->app->singleton(Invoicing::class, function () {
        return new Invoicing(
            new InvoicingService\PaymentDocuments,
            new InvoicingService\RefundDocuments,
            new InvoicingService\InvoiceDocuments,
        );
    });
}
```

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [Flavorly](https://github.com/flavorly)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
