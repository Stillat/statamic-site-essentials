<?php

namespace Stillat\StatamicSiteEssentials\Support\Facades;

use Closure;
use Illuminate\Support\Facades\Facade;
use Stillat\StatamicSiteEssentials\Metadata\Builders\GeneralBuilder;
use Stillat\StatamicSiteEssentials\Metadata\Builders\OpenGraphBuilder;
use Stillat\StatamicSiteEssentials\Metadata\Builders\RobotsBuilder;
use Stillat\StatamicSiteEssentials\Metadata\Builders\TwitterXBuilder;
use Stillat\StatamicSiteEssentials\Metadata\MetadataManager;

/**
 * @method static MetadataManager resolve(string $variableName, Closure $resolver)
 * @method static MetadataManager withDefaults()
 * @method static MetadataManager queue(Closure|array $attributes, bool $isLink = false)
 * @method static MetadataManager queueLink(Closure|array $attributes)
 * @method static MetadataManager ephemeral(Closure $closure)
 * @method static MetadataManager ephemeralMeta(Closure|array $attributes, bool $isLink = false)
 * @method static MetadataManager ephemeralLink(Closure|array $attributes)
 * @method static MetadataManager queueMany(array $metaTags, bool $isLink = false)
 * @method static MetadataManager queueManyLinks(array $linkTags)
 * @method static MetadataManager clear()
 * @method static MetadataManager addProvider(string $provider)
 * @method static MetadataManager addProviders(array $providers)
 * @method static array getTags()
 * @method static string toHtml(array $context)
 * @method static OpenGraphBuilder openGraph()
 * @method static RobotsBuilder robots()
 * @method static GeneralBuilder general()
 * @method static TwitterXBuilder twitterX()
 * @method
 */
class Metadata extends Facade
{
    protected static function getFacadeAccessor()
    {
        return MetadataManager::class;
    }
}
