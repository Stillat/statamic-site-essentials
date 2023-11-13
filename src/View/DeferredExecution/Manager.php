<?php

namespace Stillat\StatamicSiteEssentials\View\DeferredExecution;

use Illuminate\Http\Response;
use Illuminate\Support\Str;

class Manager
{
    /**
     * A collection of registered deferred regions.
     */
    protected array $registeredRegions = [];

    /**
     * Registers a new deferred region.
     *
     * @param  string  $content The content to register.
     * @param  array  $context The context to register.
     * @return string'
     */
    public function registerRegion(string $content, array $context): string
    {
        $regionName = 'deferred_'.Str::random(42);

        $this->registeredRegions[$regionName] = new DeferredRegion($content, $context);

        return $regionName;
    }

    /**
     * Resets the manager's internal state.
     */
    public function reset(): void
    {
        $this->registeredRegions = [];
    }

    /**
     * Applies all registered deferred regions to the provided content.
     *
     * @param  string  $content The content to apply deferred regions to.
     */
    public function applyDeferredRegions(string $content): string
    {
        foreach ($this->registeredRegions as $regionName => $region) {
            $replacement = '';

            if (str_contains($content, $regionName)) {
                $replacement = $region->render();
            }

            $content = str_replace($regionName, $replacement, $content);
        }

        return $content;
    }

    /**
     * Applies all registered deferred regions to the provided response.
     *
     * @param  Response  $response The response to apply deferred regions to.
     */
    public function applyToResponse(Response $response): Response
    {
        $response->setContent(
            $this->applyDeferredRegions($response->getContent())
        );

        return $response;
    }
}
