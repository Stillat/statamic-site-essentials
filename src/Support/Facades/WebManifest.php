<?php

namespace Stillat\StatamicSiteEssentials\Support\Facades;

use Illuminate\Support\Facades\Facade;
use Stillat\StatamicSiteEssentials\WebManifest\WebManifestGenerator;

/**
 * @method static void generate()
 * @method static void generateQuietly()
 */
class WebManifest extends Facade
{
    protected static function getFacadeAccessor()
    {
        return WebManifestGenerator::class;
    }
}
