<?php

namespace Stillat\StatamicSiteEssentials\Data\Entries;

use Statamic\Entries\Entry;
use Statamic\Statamic;

class EntryLocales
{
    public function getLocaleVariants(Entry $entry): array
    {
        return $this->getLocales($entry, true);
    }

    public function getAllLocales(Entry $entry): array
    {
        return $this->getLocales($entry, false);
    }

    public function getLocalesForEntry(Entry $entry)
    {
        return array_keys($this->getLocaleVariants($entry));
    }

    protected function getDescendants(Entry $entry)
    {
        $origin = $entry->origin();

        return $origin ? $origin->descendants() : $entry->descendants();
    }

    protected function getLocales(Entry $entry, bool $excludeCurrent): array
    {
        if (! Statamic::pro()) {
            return [];
        }

        $descendants = $this->getDescendants($entry);
        if (! $descendants) {
            return [];
        }

        $variants = [];
        $currentLocale = $entry->site()?->locale();
        $origin = $entry->origin();
        $originLocale = $origin?->site()?->locale() ?? '';

        if ($origin && $originLocale !== $currentLocale) {
            $variants[$originLocale] = $origin;
        }

        if (! $origin && ! $excludeCurrent) {
            $variants[$currentLocale] = $entry;
        }

        foreach ($descendants as $descendant) {
            $descendantLocale = $descendant->site()?->locale();
            if ($excludeCurrent && $descendantLocale === $currentLocale) {
                continue;
            }

            $variants[$descendantLocale] = $descendant;
        }

        return $variants;
    }
}
