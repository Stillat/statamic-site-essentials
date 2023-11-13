<?php

namespace Stillat\StatamicSiteEssentials\Listeners;

use Stillat\StatamicSiteEssentials\View\DeferredExecution\Manager;
use Stillat\StatamicSiteEssentials\View\ViewObserver;

class StatamicResponseCreated
{
    public function handle($event)
    {
        /** @var Manager $deferredManager */
        $deferredManager = app(Manager::class);
        $deferredManager->applyToResponse($event->response);
        $deferredManager->reset();

        app(ViewObserver::class)->reset();
    }
}
