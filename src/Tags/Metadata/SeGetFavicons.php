<?php

namespace Stillat\StatamicSiteEssentials\Tags\Metadata;

use Statamic\Tags\Tags;
use Stillat\StatamicSiteEssentials\Favicons\Icons;

class SeGetFavicons extends Tags
{
    public function index()
    {
        return Icons::getFavicons();
    }
}
