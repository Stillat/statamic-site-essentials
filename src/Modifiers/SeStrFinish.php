<?php

namespace Stillat\StatamicSiteEssentials\Modifiers;

use Illuminate\Support\Str;
use Statamic\Modifiers\Modifier;

class SeStrFinish extends Modifier
{
    public function index($value, $params, $context)
    {
        return Str::finish($value, (string) $params[0]);
    }
}
