<?php

namespace Stillat\StatamicSiteEssentials\Support\Facades;

use Closure;
use Illuminate\Support\Facades\Facade;
use Stillat\StatamicSiteEssentials\Favicons\FaviconManager;

/**
 * @method static FaviconManager getSourceUsing(Closure $resolver)
 * @method static void generate()
 */
class Favicons extends Facade
{
    protected static function getFacadeAccessor()
    {
        return FaviconManager::class;
    }
}
