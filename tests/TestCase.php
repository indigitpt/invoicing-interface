<?php

namespace Indigit\Invoicing\Tests;

use Indigit\Invoicing\InvoicingServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;

class TestCase extends Orchestra
{
    protected function getPackageProviders($app): array
    {
        return [
            InvoicingServiceProvider::class,
        ];
    }

    public function getEnvironmentSetUp($app): void
    {
        config()->set('database.default', 'sqlite');
        config()->set('database.connections.sqlite', [
            'driver' => 'sqlite',
            'database' => ':memory:',
            'prefix' => '',
        ]);
        config()->set('app.key', '6rE9Nz59bGRbeMATftriyQjrpF7DcOQm');
    }
}
