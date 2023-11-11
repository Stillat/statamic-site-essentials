<?php

namespace Stillat\StatamicSiteEssentials\Metadata;

use Closure;
use Stillat\StatamicSiteEssentials\Metadata\Builders\AbstractMetaTagBuilder;
use Stillat\StatamicSiteEssentials\Metadata\Concerns\ProvidesBuilderApi;

class MetaBuilder extends AbstractMetaTagBuilder
{
    use ProvidesBuilderApi;

    private bool $isEphemeral = false;

    public function queue(Closure|array $attributes, bool $isLink = false): self
    {
        $this->getManager()->queue($attributes, $isLink);

        return $this;
    }

    public function queueLink(Closure|array $attributes): self
    {
        $this->getManager()->queueLink($attributes);

        return $this;
    }

    public function queueMany(array $attributes, bool $isLink = false): self
    {
        $this->getManager()->queueMany($attributes, $isLink);

        return $this;
    }

    public function queueManyLinks(array $attributes): self
    {
        $this->getManager()->queueManyLinks($attributes);

        return $this;
    }

    public function addProvider(string $provider): self
    {
        $this->getManager()->addProvider($provider);

        return $this;
    }

    public function addProviders(array $providers): self
    {
        $this->getManager()->addProviders($providers);

        return $this;
    }

    public function ephemeralMeta(Closure|array $attributes, bool $isLink = false): self
    {
        $this->getManager()->ephemeralMeta($attributes, $isLink);

        return $this;
    }

    public function ephemeralLink(Closure|array $attributes): self
    {
        $this->getManager()->ephemeralLink($attributes);

        return $this;
    }
}
