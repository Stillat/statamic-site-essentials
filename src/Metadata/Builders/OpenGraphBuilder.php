<?php

namespace Stillat\StatamicSiteEssentials\Metadata\Builders;

use Statamic\Assets\Asset;
use Statamic\Facades\Site;
use Stillat\StatamicSiteEssentials\Metadata\DataHelpers;

class OpenGraphBuilder extends AbstractMetaTagBuilder
{
    /**
     * Queues a <meta property="og:title" content="..."> tag.
     *
     * Variable: $title
     */
    public function title(mixed $title = '$title'): self
    {
        return $this->property('og:title', $title);
    }

    /**
     * Queues a <meta property="og:type" content="..."> tag.
     *
     * Defaults to "website".
     */
    public function type($type = 'website'): self
    {
        return $this->property('og:type', $type);
    }

    /**
     * Queues a <meta property="og:url" content="..."> tag.
     *
     * Variable: $current_url
     */
    public function url($url = '$current_full_url'): self
    {
        return $this->property('og:url', $url);
    }

    /**
     * Queues a <meta property="og:description" content="..."> tag.
     *
     * Variable: $meta_description
     */
    public function description($description = '$meta_description'): self
    {
        return $this->property('og:description', $description);
    }

    /**
     * Queues a <meta name="site_name" property="og:site_name" content="..."> tag.
     *
     * Variable: $meta_site_name
     */
    public function siteName($siteName = '$meta_site_name'): self
    {
        return $this->add([
            'name' => 'site_name',
            'property' => 'og:site_name',
            'content' => $this->value($siteName),
        ]);
    }

    /**
     * Queues a <meta property="og:locale" content="..."> tag.
     *
     * Defaults to the current site's locale.
     */
    public function locale($locale = null): self
    {
        if ($locale == null) {
            $locale = function (array $context) {
                return Site::current()->locale();
            };
        }

        return $this->property('og:locale', $locale);
    }

    /**
     * Queues a <meta property="og:locale:alternate" content="..."> tag.
     */
    public function localeAlternate($localeAlternate = null): self
    {
        if ($localeAlternate == null) {
            $localeAlternate = DataHelpers::localeAlternates();
        }

        return $this->property('og:locale:alternate', $localeAlternate);
    }

    /**
     * Queues a <meta name="image" property="og:image" content="..."> tag.
     */
    public function image($image = ''): self
    {
        return $this->add([
            'name' => 'image',
            'property' => 'og:image',
            'content' => $this->value($image),
        ]);
    }

    /**
     * Uses information from the provided asset to queue the following tags:
     *
     * <meta name="image" property="og:image" content="...">
     * <meta property="og:image:width" content="...">
     * <meta property="og:image:height" content="...">
     * <meta property="og:image:type" content="...">
     * <meta property="og:image:alt" content="...">
     */
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

    /**
     * Uses information from the provided asset to queue the following tags:
     *
     * <meta name="video" property="og:video" content="...">
     * <meta property="og:video:type" content="...">
     * <meta property="og:video:width" content="...">
     * <meta property="og:video:height" content="...">
     */
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

    /**
     * Queues a <meta property="og:image:type" content="..."> tag.
     */
    public function imageType($imageType = ''): self
    {
        return $this->property('og:image:type', $imageType);
    }

    /**
     * Queues a <meta property="og:image:width" content="..."> tag.
     */
    public function imageWidth($imageWidth = ''): self
    {
        return $this->property('og:image:width', $imageWidth);
    }

    /**
     * Queues a <meta property="og:image:height" content="..."> tag.
     */
    public function imageHeight($imageHeight = ''): self
    {
        return $this->property('og:image:height', $imageHeight);
    }

    /**
     * Queues a <meta property="og:image:alt" content="..."> tag.
     */
    public function imageAlt($imageAlt = ''): self
    {
        return $this->property('og:image:alt', $imageAlt);
    }

    /**
     * Queues a <meta name="video" property="og:video" content="..."> tag.
     */
    public function video($video = ''): self
    {
        return $this->add([
            'name' => 'video',
            'property' => 'og:video',
            'content' => $this->value($video),
        ]);
    }

    /**
     * Queues a <meta property="og:video:type" content="..."> tag.
     */
    public function videoType($videoType = ''): self
    {
        return $this->property('og:video:type', $videoType);
    }

    /**
     * Queues a <meta property="og:video:width" content="..."> tag.
     */
    public function videoWidth($videoWidth = ''): self
    {
        return $this->property('og:video:width', $videoWidth);
    }

    /**
     * Queues a <meta property="og:video:height" content="..."> tag.
     */
    public function videoHeight($videoHeight = ''): self
    {
        return $this->property('og:video:height', $videoHeight);
    }
}
