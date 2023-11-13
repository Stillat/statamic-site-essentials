<?php

namespace Stillat\StatamicSiteEssentials\Listeners;

use Illuminate\Http\RedirectResponse;
use Statamic\Statamic;
use Stillat\StatamicSiteEssentials\View\DeferredExecution\Manager;
use Stillat\StatamicSiteEssentials\View\ViewObserver;

class StatamicResponseCreated
{
    public function handle($event)
    {
        $this->runFrontEndResponseHandlers($event->response);

        app(ViewObserver::class)->reset();
    }

    protected function runFrontEndResponseHandlers($response)
    {
        if (! $response) {
            return;
        }
        if ($response instanceof RedirectResponse) {
            return;
        }
        if (Statamic::isCpRoute()) {
            return;
        }

        /** @var Manager $deferredManager */
        $deferredManager = app(Manager::class);
        $deferredManager->applyToResponse($response);
        $deferredManager->reset();
    }
}
