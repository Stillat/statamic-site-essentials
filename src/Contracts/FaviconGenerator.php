<?php

namespace Stillat\StatamicSiteEssentials\Contracts;

interface FaviconGenerator
{
    public function resize(string $sourcePath, string $destinationPath, int $height, int $width);
}
