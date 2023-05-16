<?php

namespace Onramplab\LaravelPackageTemplate\Tests;

use Illuminate\Foundation\Testing\RefreshDatabase;
use OnrampLab\LaravelPackageTemplate\LaravelPackageTemplateServiceProvider;
use Orchestra\Testbench\TestCase as OrchestraTestCase;

class TestCase extends OrchestraTestCase
{
    use RefreshDatabase;

    /**
     * @param \Illuminate\Foundation\Application $app
     * @return void
     */
    protected function defineEnvironment($app)
    {
        $app['config']->set('database.default', 'testing_sqlite');
        $app['config']->set('database.connections.testing_sqlite', [
            'driver' => 'sqlite',
            'database' => ':memory:',
            'prefix' => '',
        ]);
    }

    /**
     * @param \Illuminate\Foundation\Application $app
     * @return array
     */
    protected function getPackageProviders($app)
    {
        return [
            LaravelPackageTemplateServiceProvider::class,
        ];
    }
}
