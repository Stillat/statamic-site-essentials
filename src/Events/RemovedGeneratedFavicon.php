<?php

namespace Stillat\StatamicSiteEssentials\Events;

use Illuminate\Foundation\Events\Dispatchable;

class RemovedGeneratedFavicon
{
    use Dispatchable;

    public function __construct(public readonly string $path)
    {
    }
}
