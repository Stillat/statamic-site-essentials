<?php

namespace Stillat\StatamicSiteEssentials\Tags\TemplateManagement;

use Statamic\Tags\Tags;
use Stillat\StatamicSiteEssentials\View\DeferredExecution\Manager;

class SeDeferred extends Tags
{
    protected Manager $manager;

    public function __construct(Manager $manager)
    {
        $this->manager = $manager;
    }

    public function index()
    {
        if (! $this->isPair) {
            return '';
        }

        $content = $this->content;
        $context = $this->context->all();

        return $this->manager->registerRegion($content, $context);
    }
}
