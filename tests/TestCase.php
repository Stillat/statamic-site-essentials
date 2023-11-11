<?php

namespace Tests;

use Orchestra\Testbench\TestCase as BaseTestCase;
use Statamic\Extend\Manifest;
use Stillat\StatamicSiteEssentials\ServiceProvider;

abstract class TestCase extends BaseTestCase
{
    protected function getEnvironmentSetUp($app)
    {
        parent::getEnvironmentSetUp($app);

        $app->make(Manifest::class)->manifest = [
            'stillat/statamic-site-essentials' => [
                'id' => 'stillat/statamic-site-essentials',
                'namespace' => 'Stillat\\StatamicSiteEssentials',
            ],
        ];

        $viewPaths = $app['config']->get('view.paths');
        $viewPaths[] = __DIR__.'/__fixtures__/views/';

        $app['config']->set('view.paths', $viewPaths);
    }

    protected function getPackageProviders($app)
    {
        return [
            \Statamic\Providers\StatamicServiceProvider::class,
            \Rebing\GraphQL\GraphQLServiceProvider::class,
            \Wilderborn\Partyline\ServiceProvider::class,
            \Archetype\ServiceProvider::class,
            ServiceProvider::class,
        ];
    }

    protected function getPackageAliases($app)
    {
        return [
            'Statamic' => 'Statamic\Statamic',
        ];
    }
}
