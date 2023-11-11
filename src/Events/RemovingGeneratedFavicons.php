<?php

namespace Stillat\StatamicSiteEssentials\Events;

use Illuminate\Foundation\Events\Dispatchable;

class RemovingGeneratedFavicons
{
    use Dispatchable;

    public function __construct(public readonly array $paths)
    {
    }
}
