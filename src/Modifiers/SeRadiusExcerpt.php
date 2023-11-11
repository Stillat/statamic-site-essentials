<?php

namespace Stillat\StatamicSiteEssentials\Modifiers;

use Illuminate\Support\Str;
use Statamic\Modifiers\Modifier;

class SeRadiusExcerpt extends Modifier
{
    public function index($value, $params, $context)
    {
        if (! $phrase = $params[0] ?? $context['get']['q'] ?? null) {
            return $value;
        }

        $radius = $params[1] ?? 250;
        $omission = $params[2] ?? '…';

        $excerpt = Str::excerpt($value, $phrase, [
            'radius' => $radius,
            'omission' => $omission,
        ]);

        if (mb_strlen(trim($excerpt)) == 0) {
            if (! Str::contains($phrase, ' ')) {
                return $value;
            }

            $phrases = explode(' ', $phrase);

            foreach ($phrases as $phrase) {
                $excerpt = Str::excerpt($value, $phrase, [
                    'radius' => $radius,
                    'omission' => $omission,
                ]);

                if (mb_strlen(trim($excerpt)) > 0) {
                    break;
                }
            }

            if (mb_strlen(trim($excerpt)) == 0) {
                return $value;
            }
        }

        return $excerpt;
    }
}
