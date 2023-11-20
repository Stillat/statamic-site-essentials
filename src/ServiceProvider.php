<?php

namespace Stillat\StatamicSiteEssentials;

use Statamic\Providers\AddonServiceProvider;
use Stillat\StatamicAttributeRenderer\ValueResolver;
use Stillat\StatamicSiteEssentials\Contracts\FaviconGenerator;
use Stillat\StatamicSiteEssentials\Listeners\StatamicResponseCreated;
use Stillat\StatamicSiteEssentials\Metadata\MetadataManager;
use Stillat\StatamicSiteEssentials\View\AssetQueues\QueueManager;
use Stillat\StatamicSiteEssentials\View\DeferredExecution\Manager;
use Stillat\StatamicSiteEssentials\View\ViewObserver;

class ServiceProvider extends AddonServiceProvider
{
    protected $commands = [
        Console\GenerateFavicons::class,
        Console\GenerateWebManifest::class,
        Console\RemoveFields::class,
    ];

    protected $listen = [
        \Statamic\Events\ResponseCreated::class => [
            StatamicResponseCreated::class,
        ],
        \Illuminate\Foundation\Http\Events\RequestHandled::class => [
            StatamicResponseCreated::class,
        ],
    ];

    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/webmanifest.php', 'site_essentials.webmanifest');
        $this->mergeConfigFrom(__DIR__.'/../config/favicons.php', 'site_essentials.favicons');
        $this->mergeConfigFrom(__DIR__.'/../config/templating.php', 'site_essentials.templating');
        $this->mergeConfigFrom(__DIR__.'/../config/metadata_rules.php', 'site_essentials.metadata_rules');
        $this->mergeConfigFrom(__DIR__.'/../config/metadata.php', 'site_essentials.metadata');

        $this->app->singleton(MetadataManager::class, function () {
            $valueResolver = app(ValueResolver::class);

            return new MetadataManager($valueResolver);
        });

        $this->app->singleton(ViewObserver::class, function () {
            return new ViewObserver();
        });

        $this->app->singleton(Manager::class, function () {
            return new Manager();
        });

        $this->app->singleton(QueueManager::class, function () {
            return new QueueManager();
        });

        $this->app->bind(FaviconGenerator::class, config('site_essentials.favicons.driver', null));

        $this->publishes([
            __DIR__.'/../config/webmanifest.php' => config_path('site_essentials/webmanifest.php'),
            __DIR__.'/../config/favicons.php' => config_path('site_essentials/favicons.php'),
            __DIR__.'/../config/templating.php' => config_path('site_essentials/templating.php'),
            __DIR__.'/../config/metadata_rules.php' => config_path('site_essentials/metadata_rules.php'),
            __DIR__.'/../config/metadata.php' => config_path('site_essentials/metadata.php'),
        ], 'statamic-site-essentials-config');
    }

    public function bootAddon()
    {
        // Create temporary directory, if it doesn't exist.
        $tmpPath = config('site_essentials.favicons.tmp_path', storage_path('site-essentials'));

        if (! file_exists($tmpPath)) {
            mkdir($tmpPath, 0755, true);
        }

        if (config('site_essentials.templating.observe_view', true)) {
            ViewObserver::setupObserver();
        }

        // Do this here since Statamic boots tags/modifiers after config.
        foreach (config('site_essentials.templating.modifiers', []) as $modifier) {
            $modifier::register();
        }

        foreach (config('site_essentials.templating.tags', []) as $tag) {
            $tag::register();
        }
    }
}
