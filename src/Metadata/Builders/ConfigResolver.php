<?php

namespace Stillat\StatamicSiteEssentials\Metadata\Builders;

use Closure;

class ConfigResolver
{
    public static function makeConfigResolver(string $configKey): Closure
    {
        return function (array $context) use ($configKey) {
            return config('site_essentials.metadata.'.$configKey);
        };
    }
}
