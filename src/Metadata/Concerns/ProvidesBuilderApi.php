<?php

namespace Stillat\StatamicSiteEssentials\Metadata\Concerns;

use Stillat\StatamicSiteEssentials\Metadata\Builders\GeneralBuilder;
use Stillat\StatamicSiteEssentials\Metadata\Builders\OpenGraphBuilder;
use Stillat\StatamicSiteEssentials\Metadata\Builders\RobotsBuilder;
use Stillat\StatamicSiteEssentials\Metadata\Builders\TwitterXBuilder;

trait ProvidesBuilderApi
{
    public function openGraph(): OpenGraphBuilder
    {
        return new OpenGraphBuilder($this->getManager());
    }

    public function robots(): RobotsBuilder
    {
        return new RobotsBuilder($this->getManager());
    }

    public function general(): GeneralBuilder
    {
        return new GeneralBuilder($this->getManager());
    }

    public function twitterX(): TwitterXBuilder
    {
        return new TwitterXBuilder($this->getManager());
    }
}
