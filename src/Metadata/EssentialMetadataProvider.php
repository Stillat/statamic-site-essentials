<?php

namespace Stillat\StatamicSiteEssentials\Metadata;

use Stillat\StatamicAttributeRenderer\Concerns\CreatesLinksTags;
use Stillat\StatamicSiteEssentials\Favicons\Icons;
use Stillat\StatamicSiteEssentials\WebManifest\WebManifestGenerator;

class EssentialMetadataProvider
{
    use CreatesLinksTags;

    public function getMetaTags(array $context): array
    {
        $metaTags = [];

        if (config('site_essentials.favicons', false)) {
            foreach ($this->createLinkTags(Icons::getFavicons(), $context) as $linkTag) {
                $metaTags[] = $linkTag;
            }
        }

        if ($manifest = WebManifestGenerator::getManifestLink($context)) {
            $metaTags[] = $manifest;
        }

        return $metaTags;
    }
}
