<?php

namespace Stillat\StatamicSiteEssentials\Events;

use Illuminate\Foundation\Events\Dispatchable;

class GeneratingNewFavicons
{
    use Dispatchable;

    public function __construct(public readonly array $icons)
    {
    }
}
