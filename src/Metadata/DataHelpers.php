<?php

namespace Stillat\StatamicSiteEssentials\Metadata;

use Closure;
use Statamic\Entries\Entry;
use Statamic\Fields\Value;
use Stillat\StatamicAttributeRenderer\RepeatableValue;
use Stillat\StatamicSiteEssentials\Data\Entries\EntryLocales;

class DataHelpers
{
    public static function getEntryFromContext(array $context): ?Entry
    {
        $id = $context['id'] ?? null;

        if ($id == null) {
            return null;
        }

        if (! $id instanceof Value) {
            return null;
        }

        $augmentedObject = $id->augmentable();

        if (! $augmentedObject instanceof Entry) {
            return null;
        }

        return $augmentedObject;
    }

    public static function localeAlternates(): Closure
    {
        return function (array $context) {
            $entry = DataHelpers::getEntryFromContext($context);

            if (! $entry) {
                return new RepeatableValue([]);
            }

            /** @var EntryLocales $entryLocales */
            $entryLocales = app(EntryLocales::class);
            $locales = $entryLocales->getLocalesForEntry($entry);

            return new RepeatableValue($locales);
        };
    }
}
