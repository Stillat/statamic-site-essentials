<?php

namespace Stillat\StatamicSiteEssentials\Metadata\Builders;

class ViewportBuilder
{
    protected array $attributes = [];

    public function deviceWidth(): self
    {
        return $this->width('device-width');
    }

    public function deviceHeight(): self
    {
        return $this->height('device-height');
    }

    public function width(string $width): self
    {
        return $this->attribute('width', $width);
    }

    public function height(string $height): self
    {
        return $this->attribute('height', $height);
    }

    public function initialScale(float $scale): self
    {
        return $this->attribute('initial-scale', (string) $scale);
    }

    public function minimumScale(float $scale): self
    {
        return $this->attribute('minimum-scale', (string) $scale);
    }

    public function maximumScale(float $scale): self
    {
        return $this->attribute('maximum-scale', (string) $scale);
    }

    public function userScalable(bool $scalable): self
    {
        return $this->attribute('user-scalable', $scalable ? 'yes' : 'no');
    }

    public function fixedScale(): self
    {
        return $this->initialScale(1)
            ->maximumScale(1)
            ->minimumScale(1)
            ->userScalable(false);
    }

    public function defaultMobileScaling(): self
    {
        return $this->width('device-width')
            ->initialScale(1);
    }

    public function disableUserZoom(): self
    {
        return $this->maximumScale(1)
            ->userScalable(false);
    }

    public function forceLandscape(): self
    {
        return $this->attribute('orientation', 'landscape');
    }

    public function forcePortrait(): self
    {
        return $this->attribute('orientation', 'portrait');
    }

    public function defaultViewport(): self
    {
        return $this->deviceWidth()
            ->initialScale(1)
            ->userScalable(true);
    }

    public function reset(): self
    {
        $this->attributes = [];

        return $this;
    }

    public function attribute(string $name, string $value): self
    {
        $this->attributes[$name] = $value;

        return $this;
    }

    public function __toString(): string
    {
        if (count($this->attributes) === 0) {
            return '';
        }

        $viewportAttributes = collect($this->attributes)->map(function ($value, $name) {
            return $name.'='.$value;
        })->toArray();

        return implode(', ', $viewportAttributes);
    }
}
