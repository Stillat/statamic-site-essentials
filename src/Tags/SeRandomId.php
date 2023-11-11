<?php

namespace Stillat\StatamicSiteEssentials\Tags;

use Illuminate\Support\Str;
use Statamic\Tags\Tags;

class SeRandomId extends Tags
{
    public function index()
    {
        $length = $this->params->get('length', 16);

        if ($length < 4) {
            $length = 4;
        }

        $length -= 2;

        return 'el'.Str::random($length);
    }
}
