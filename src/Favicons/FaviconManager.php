<?php

namespace Stillat\StatamicSiteEssentials\Favicons;

use Closure;
use Exception;

class FaviconManager
{
    protected Generator $generator;

    protected ?Closure $sourceImageResolver = null;

    public function __construct(Generator $generator)
    {
        $this->generator = $generator;
    }

    public function getSourceUsing(Closure $resolver): self
    {
        $this->sourceImageResolver = $resolver;

        return $this;
    }

    /**
     * @throws Exception
     */
    public function generate(): void
    {
        if ($this->sourceImageResolver == null) {
            throw new Exception('An image source resolver must be provided.');
        }

        $sourceImage = (string) $this->sourceImageResolver->__invoke();

        $this->generator->setIcons(config('site_essentials.favicons.icons', []));
        $this->generator->setRemoveExisting(config('site_essentials.favicons.remove_existing', true));
        $this->generator->setTmpDirectory(config('site_essentials.favicons.tmp_path', storage_path('statamic-site-essentials')));

        $this->generator->generateFavicons($sourceImage);
    }
}
