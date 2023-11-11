<?php

namespace Stillat\StatamicSiteEssentials\Metadata\Builders;

class RobotsBuilder extends AbstractMetaTagBuilder
{
    public function noIndex(): self
    {
        return $this->property('robots', 'noindex');
    }
}
