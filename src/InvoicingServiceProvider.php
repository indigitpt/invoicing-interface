<?php

namespace Indigit\Invoicing;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class InvoicingServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package
            ->name('invoicing')
            ->hasConfigFile()
            ->hasRoute('api');
    }
}
