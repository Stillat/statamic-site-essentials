<?php

namespace Stillat\StatamicSiteEssentials\Tags\TemplateManagement;

use Statamic\Fields\Value;
use Statamic\Tags\Tags;
use Stillat\StatamicSiteEssentials\View\ViewObserver;

class SeView extends Tags
{
    protected ViewObserver $observer;

    public function __construct(ViewObserver $observer)
    {
        $this->observer = $observer;
    }

    public function rendered()
    {
        $name = $this->params->get('name');

        if ($name == null) {
            return false;
        }

        if ($name instanceof Value) {
            $name = $name->value();
        }

        return $this->observer->hasObserved((string) $name);
    }
}
