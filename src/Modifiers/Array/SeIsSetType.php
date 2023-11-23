<?php

namespace Stillat\StatamicSiteEssentials\Modifiers\Array;

use Statamic\Fields\Values;
use Statamic\Modifiers\Modifier;

class SeIsSetType extends Modifier
{
    public function index($value, $params, $context): bool
    {
        if (! is_array($value)) {
            return false;
        }

        $checkIndex = $params[1] ?? 0;

        if (! isset($value[$checkIndex])) {
            return false;
        }

        $checkType = $params[0] ?? null;

        if ($checkType === null) {
            return false;
        }

        $value = $value[$checkIndex];

        if ($value instanceof Values) {
            $value = $value->toArray();
        }

        if (! array_key_exists('type', $value)) {
            return false;
        }

        if (is_array($checkType)) {
            return in_array($value['type'], $checkType);
        }

        return $value['type'] === $checkType;
    }
}
