<?php

namespace Stillat\StatamicSiteEssentials\Favicons\Drivers;

use Imagick;
use Stillat\StatamicSiteEssentials\Contracts\FaviconGenerator;

class ImagickDriver implements FaviconGenerator
{
    public function resize(string $sourcePath, string $destinationPath, int $height, int $width)
    {
        $imagick = new Imagick();
        $imagick->readImage($sourcePath);
        $imagick->scaleImage($width, $height, true);
        $imagick->writeImage($destinationPath);
        $imagick->clear();
        $imagick->destroy();
    }
}
