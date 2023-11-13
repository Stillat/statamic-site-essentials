<?php

namespace Stillat\StatamicSiteEssentials\Listeners;

use Stillat\StatamicSiteEssentials\View\ViewObserver;

class StatamicResponseCreated
{
    public function handle()
    {
        app(ViewObserver::class)->reset();
    }
}
