<?php

namespace Stillat\StatamicSiteEssentials\WebManifest;

use Illuminate\Support\Str;
use Stillat\StatamicAttributeRenderer\Concerns\CreatesLinksTags;
use Stillat\StatamicAttributeRenderer\LinkTagRenderer;
use Stillat\StatamicSiteEssentials\Events\WebManifestGenerated;
use Stillat\StatamicSiteEssentials\Events\WebManifestGenerating;
use Stillat\StatamicSiteEssentials\Favicons\Icons;

class WebManifestGenerator
{
    use CreatesLinksTags;

    protected bool $withEvents = true;

    public function generateQuietly()
    {
        $this->withEvents = false;

        $this->generate();
    }

    public function generate()
    {
        if ($this->withEvents) {
            WebManifestGenerating::dispatch();
        }

        $manifest = config('site_essentials.webmanifest.manifest', []);

        $manifestIcons = $manifest['icons'] ?? [];

        if (config('site_essentials.favicons.enabled') === true) {
            $favicons = Icons::getFavicons();

            foreach ($favicons as $icon) {
                $manifestIcons[] = [
                    'src' => $icon['href'],
                    'sizes' => $icon['sizes'],
                    'type' => $icon['type'],
                ];
            }
        }

        $manifest['icons'] = $manifestIcons;

        $manifestJson = json_encode($manifest, JSON_PRETTY_PRINT);

        file_put_contents(config('site_essentials.webmanifest.path'), $manifestJson);

        if ($this->withEvents) {
            WebManifestGenerated::dispatch();
        }
    }

    public static function getManifestLink(array $context): ?string
    {
        $manifestPath = config('site_essentials.webmanifest.path');

        if (! file_exists($manifestPath)) {
            return null;
        }

        $path = Str::start(basename($manifestPath), '/');
        $tagAttributes = config('site_essentials.webmanifest.tag_attributes', []) ?? [];
        if (count($tagAttributes) == 0) {
            $tagAttributes['rel'] = 'manifest';
        }

        $tagAttributes['href'] = $path;

        /** @var LinkTagRenderer $linkRenderer */
        $linkRenderer = app(LinkTagRenderer::class);

        return $linkRenderer->getTag($tagAttributes, $context);
    }
}
