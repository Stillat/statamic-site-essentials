<?php

namespace Stillat\StatamicSiteEssentials\View\DeferredExecution;

use Statamic\Facades\Antlers;

class DeferredRegion
{
    public function __construct(
        public string $content,
        public array $context
    ) {
    }

    /**
     * Renders the deferred region.
     */
    public function render(): string
    {
        return (string) Antlers::parse($this->content, $this->context);
    }
}
