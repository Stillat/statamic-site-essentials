<?php

namespace Stillat\StatamicSiteEssentials\Favicons;

use GuzzleHttp\Psr7\MimeType;

class Icons
{
    public static function getFileName($sizeString, $format)
    {
        if ($format == 'ico' && $sizeString == '16x16') {
            return 'favicon.ico';
        }

        return "favicon-{$sizeString}.{$format}";
    }

    public static function getFavicons()
    {
        $configuredFavicons = config('site_essentials.favicons.icons', []);
        $favicons = [];

        foreach ($configuredFavicons as $favicon) {
            $rel = $favicon['rel'];
            $sizeString = $favicon['size'];
            $type = MimeType::fromExtension($favicon['format']);
            $fileName = self::getFileName($sizeString, $favicon['format']);

            if (! file_exists(public_path($fileName))) {
                continue;
            }

            $href = '/'.$fileName;

            $favicons[] = [
                'rel' => $rel,
                'type' => $type,
                'href' => $href,
                'sizes' => $sizeString,
            ];
        }

        return $favicons;
    }
}
