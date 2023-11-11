<?php

namespace Stillat\StatamicSiteEssentials\Events;

use Illuminate\Foundation\Events\Dispatchable;

class GeneratedNewFavicon
{
    use Dispatchable;

    public function __construct(public readonly string $path)
    {
    }
}
