<?php

namespace Stillat\StatamicSiteEssentials\Tags\Metadata;

use Statamic\Tags\Tags;
use Stillat\StatamicAttributeRenderer\Concerns\CreatesAttributeStrings;
use Stillat\StatamicSiteEssentials\WebManifest\WebManifestGenerator;

class SeWebManifest extends Tags
{
    use CreatesAttributeStrings;

    public function index()
    {
        return WebManifestGenerator::getManifestLink($this->context->all());
    }
}
