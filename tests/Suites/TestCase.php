<?php

declare(strict_types=1);

namespace Rschoonheim\LaravelApiIntegration\Tests\Suites;

class TestCase extends \Orchestra\Testbench\TestCase
{
    protected function getPackageProviders($app)
    {
        return [
            \Rschoonheim\LaravelApiIntegration\LaravelApiIntegrationServiceProvider::class,
        ];
    }
}