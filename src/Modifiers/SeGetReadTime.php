<?php

namespace Stillat\StatamicSiteEssentials\Modifiers;

use Statamic\Modifiers\CoreModifiers;
use Statamic\Modifiers\Modifier;

class SeGetReadTime extends Modifier
{
    public function index($value, $params, $context)
    {
        $core = app(CoreModifiers::class);

        if (is_array($value)) {
            $value = $core->bardText($value);
        }

        return $core->readTime($value, $params);
    }
}
