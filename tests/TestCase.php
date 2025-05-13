<?php

namespace Maximzhurkin\Containers\Tests;

use Orchestra\Testbench\TestCase as BaseTestCase;
use Maximzhurkin\Containers\Providers\ContainerServiceProvider;

abstract class TestCase extends BaseTestCase
{
    protected function getPackageProviders($app)
    {
        return [
            ContainerServiceProvider::class,
        ];
    }
}