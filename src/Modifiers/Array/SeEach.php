<?php

namespace Stillat\StatamicSiteEssentials\Modifiers\Array;

use Statamic\Facades\Antlers;
use Statamic\Modifiers\Modifier;

class SeEach extends Modifier
{
    public function index($value, $params, $context): ?string
    {
        $name = $params[0];

        if (! $name) {
            return null;
        }

        $view = view($name);

        if (! $view || $view == '') {
            return null;
        }

        $path = $view->getPath();

        if (! file_exists($path)) {
            return null;
        }

        $template = file_get_contents($path);
        $eachData = [];

        foreach ($value as $tVal) {

            $eachData[] = array_merge($context, $tVal);
        }

        $data = [
            '__each_data' => $eachData,
        ];

        $template = '{{ __each_data }}'.$template.' {{ /__each_data }}';

        return Antlers::parse($template, $data, true);
    }
}
