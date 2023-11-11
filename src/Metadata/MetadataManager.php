<?php

namespace Stillat\StatamicSiteEssentials\Metadata;

use Closure;
use Stillat\StatamicAttributeRenderer\Concerns\CreatesLinksTags;
use Stillat\StatamicAttributeRenderer\Concerns\CreatesMetaTags;
use Stillat\StatamicAttributeRenderer\ValueResolver;
use Stillat\StatamicSiteEssentials\Metadata\Concerns\ProvidesBuilderApi;

class MetadataManager
{
    use CreatesLinksTags, CreatesMetaTags, ProvidesBuilderApi;

    protected array $metadataProviders = [];

    protected array $queuedMetaTags = [];

    protected array $queuedLinkTags = [];

    protected array $ephemeralMetaTags = [];

    protected array $ephemeralLinkTags = [];

    /**
     * @var Closure[]
     */
    protected array $deferredTagCallbacks = [];

    /**
     * @var Closure[]
     */
    protected array $ephemeralTagsCallbacks = [];

    protected MetaBuilder $deferredBuilder;

    protected ValueResolver $valueResolver;

    protected MetadataCleaner $metadataCleaner;

    private bool $isEphemeral = false;

    protected array $thirdPartyCompatibility = [];

    protected array $thirdPartyTemplates = [];

    public function __construct(ValueResolver $valueResolver)
    {
        $this->deferredBuilder = new MetaBuilder($this);
        $this->metadataCleaner = new MetadataCleaner();
        $this->metadataCleaner->withConfiguredRules();
        $this->valueResolver = $valueResolver;

        $this->registerThirdPartyTemplate('statamic/seo-pro', <<<'EOT'
{{ if {installed:statamic/seo-pro} }}
    {{ seo_pro:meta }}
{{ /if }}
EOT
        );
    }

    public function setMetadataRules(array $rules): self
    {
        $this->metadataCleaner->withRules($rules);

        return $this;
    }

    public function seoPro(): MetadataManager
    {
        return $this->useThirdParty('statamic/seo-pro');
    }

    public function registerThirdPartyTemplate(string $packageName, string $template): self
    {
        $this->thirdPartyTemplates[$packageName] = $template;

        return $this;
    }

    public function useThirdParty(string $packageName): self
    {
        if (array_key_exists($packageName, $this->thirdPartyTemplates)) {
            $this->thirdPartyCompatibility[$packageName] = true;
        }

        return $this;
    }

    public function usingThirdParty(string $name): bool
    {
        return array_key_exists($name, $this->thirdPartyCompatibility);
    }

    public function getThirdPartyTemplates(): string
    {
        $templates = '';

        foreach ($this->thirdPartyCompatibility as $packageName => $throwAway) {
            if (array_key_exists($packageName, $this->thirdPartyTemplates)) {
                $templates .= $this->thirdPartyTemplates[$packageName];
            }
        }

        return $templates;
    }

    public function withDefaults(): self
    {
        $this->general()
            ->charset()
            ->xUaCompatible()
            ->viewport()
            ->title()
            ->localeAlternate();

        $this->twitterX()->all();

        $this->openGraph()
            ->title()
            ->description()
            ->type()
            ->url()
            ->siteName()
            ->locale()
            ->localeAlternate();

        return $this;
    }

    public function resolve(string $variableName, Closure $resolver): self
    {
        $this->valueResolver->addResolver($variableName, $resolver);

        return $this;
    }

    public function queue(Closure|array $attributes, bool $isLink = false): self
    {
        if ($isLink) {
            return $this->queueLink($attributes);
        }

        if ($this->isEphemeral) {
            return $this->ephemeralMeta($attributes, $isLink);
        }

        if ($attributes instanceof Closure) {
            $this->deferredTagCallbacks[] = $attributes;
        } else {
            $this->queuedMetaTags[] = $attributes;
        }

        return $this;
    }

    public function queueLink(Closure|array $attributes): self
    {
        if ($this->isEphemeral) {
            return $this->ephemeralLink($attributes);
        }

        if ($attributes instanceof Closure) {
            $this->deferredTagCallbacks[] = $attributes;
        } else {
            $this->queuedLinkTags[] = $attributes;
        }

        return $this;
    }

    public function ephemeral(Closure $closure): self
    {
        $this->isEphemeral = true;

        $closure($this->deferredBuilder);

        $this->isEphemeral = false;

        return $this;
    }

    public function ephemeralMeta(Closure|array $attributes, bool $isLink = false): self
    {
        if ($isLink) {
            return $this->ephemeralLink($attributes);
        }

        if ($attributes instanceof Closure) {
            $this->ephemeralTagsCallbacks[] = $attributes;
        } else {
            $this->ephemeralMetaTags[] = $attributes;
        }

        return $this;
    }

    public function ephemeralLink(Closure|array $attributes): self
    {
        if ($attributes instanceof Closure) {
            $this->ephemeralTagsCallbacks[] = $attributes;
        } else {
            $this->ephemeralLinkTags[] = $attributes;
        }

        return $this;
    }

    public function queueMany(array $metaTags, bool $isLink = false): self
    {
        if ($isLink) {
            return $this->queueManyLinks($metaTags);
        }

        foreach ($metaTags as $tag) {
            $this->queue($tag);
        }

        return $this;
    }

    public function queueManyLinks(array $linkTags): self
    {
        foreach ($linkTags as $tag) {
            $this->queueLink($tag);
        }

        return $this;
    }

    public function addProvider(string $provider): self
    {
        $this->metadataProviders[] = $provider;

        return $this;
    }

    public function addProviders(array $providers): self
    {
        foreach ($providers as $provider) {
            $this->metadataProviders[] = $provider;
        }

        return $this;
    }

    public function getTags(): array
    {
        return $this->queuedMetaTags;
    }

    public function toHtml(array $context, string $additionalMetaTags = ''): string
    {
        $stashedTags = $this->queuedMetaTags;
        $stashedLinkTags = $this->queuedLinkTags;

        foreach (array_merge($this->deferredTagCallbacks, $this->ephemeralTagsCallbacks) as $callback) {
            $callback($context, $this->deferredBuilder);
        }

        $this->ephemeralTagsCallbacks = [];

        $result = implode("\n", $this->createMetaTags(array_merge($this->queuedMetaTags, $this->ephemeralMetaTags), $context));
        $linkResult = implode("\n", $this->createLinkTags(array_merge($this->queuedLinkTags, $this->ephemeralLinkTags), $context));

        if ($linkResult !== '') {
            if ($result !== '') {
                $result .= "\n";
            }

            $result .= $linkResult;
        }

        $this->ephemeralMetaTags = [];

        if (count($this->metadataProviders) > 0) {
            foreach ($this->metadataProviders as $provider) {
                // Create an instance of the provider.
                $providerInstance = app($provider);

                if (method_exists($providerInstance, 'getMetaTags')) {
                    $providerResult = implode("\n", $providerInstance->getMetaTags($context));

                    if ($providerResult !== '') {
                        if ($result !== '') {
                            $result .= "\n";
                        }

                        $result .= $providerResult;
                    }
                }

                if (method_exists($providerInstance, 'getLinkTags')) {
                    $providerResult = implode("\n", $providerInstance->getLinkTags($context));

                    if ($providerResult !== '') {
                        if ($result !== '') {
                            $result .= "\n";
                        }

                        $result .= $providerResult;
                    }
                }
            }
        }

        $this->queuedMetaTags = $stashedTags;
        $this->queuedLinkTags = $stashedLinkTags;

        $this->valueResolver->clear();

        return $this->metadataCleaner->clean($result.$additionalMetaTags);
    }

    public function clear(): self
    {
        $this->queuedMetaTags = [];

        return $this;
    }

    protected function getManager(): MetadataManager
    {
        return $this;
    }
}
