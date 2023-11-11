<?php

namespace Stillat\StatamicSiteEssentials\Metadata\Builders;

use Statamic\Assets\Asset;
use Statamic\Facades\Site;
use Stillat\StatamicSiteEssentials\Metadata\DataHelpers;

class OpenGraphBuilder extends AbstractMetaTagBuilder
{
    public function title(mixed $title = '$title'): self
    {
        return $this->property('og:title', $title);
    }

    public function type($type = 'website'): self
    {
        return $this->property('og:type', $type);
    }

    public function url($url = '$current_url'): self
    {
        return $this->property('og:url', $url);
    }

    public function description($description = ''): self
    {
        return $this->property('og:description', $description);
    }

    public function siteName($siteName = ''): self
    {
        return $this->add([
            'name' => 'site_name',
            'property' => 'og:site_name',
            'content' => $this->value($siteName),
        ]);
    }

    public function locale($locale = null): self
    {
        if ($locale == null) {
            $locale = function (array $context) {
                return Site::current()->locale();
            };
        }

        return $this->property('og:locale', $locale);
    }

    public function localeAlternate($localeAlternate = null): self
    {
        if ($localeAlternate == null) {
            $localeAlternate = DataHelpers::localeAlternates();
        }

        return $this->property('og:locale:alternate', $localeAlternate);
    }

    public function image($image = ''): self
    {
        return $this->add([
            'name' => 'image',
            'property' => 'og:image',
            'content' => $this->value($image),
        ]);
    }

    public function imageAsset(?Asset $asset): self
    {
        if (! $asset) {
            return $this;
        }

        return $this->image($asset->url())
            ->imageWidth($asset->width())
            ->imageHeight($asset->height())
            ->imageType($asset->mimeType())
            ->imageAlt($asset->get('alt'));
    }

    public function videoAsset(?Asset $asset): self
    {
        if (! $asset) {
            return $this;
        }

        return $this->video($asset->url())
            ->videoType($asset->mimeType())
            ->videoWidth($asset->width())
            ->videoHeight($asset->height());
    }

    public function imageType($imageType = ''): self
    {
        return $this->property('og:image:type', $imageType);
    }

    public function imageWidth($imageWidth = ''): self
    {
        return $this->property('og:image:width', $imageWidth);
    }

    public function imageHeight($imageHeight = ''): self
    {
        return $this->property('og:image:height', $imageHeight);
    }

    public function imageAlt($imageAlt = ''): self
    {
        return $this->property('og:image:alt', $imageAlt);
    }

    public function video($video = ''): self
    {
        return $this->add([
            'name' => 'video',
            'property' => 'og:video',
            'content' => $this->value($video),
        ]);
    }

    public function videoType($videoType = ''): self
    {
        return $this->property('og:video:type', $videoType);
    }

    public function videoWidth($videoWidth = ''): self
    {
        return $this->property('og:video:width', $videoWidth);
    }

    public function videoHeight($videoHeight = ''): self
    {
        return $this->property('og:video:height', $videoHeight);
    }
}
