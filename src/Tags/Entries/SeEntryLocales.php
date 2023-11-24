<?php

namespace Stillat\StatamicSiteEssentials\Tags\Entries;

use Statamic\Entries\Entry;
use Statamic\Facades\Entry as EntryApi;
use Statamic\Facades\Site;
use Statamic\Fields\Value;
use Statamic\Tags\Concerns\OutputsItems;
use Statamic\Tags\Tags;
use Stillat\StatamicSiteEssentials\Data\Entries\EntryLocales;

class SeEntryLocales extends Tags
{
    use OutputsItems;

    protected EntryLocales $entryLocales;

    public function __construct(EntryLocales $entryLocales)
    {
        $this->entryLocales = $entryLocales;
    }

    private function getEntryFromContext(): ?Entry
    {
        $entry = $this->params->get('id', null);

        if ($entry === null) {
            $entry = $this->context['id'];
        }

        if ($entry instanceof Value) {
            $augmented = $entry->augmentable();

            if ($augmented instanceof Entry) {
                $entry = $augmented;
            } else {
                $id = $entry->value();

                if (! is_string($id)) {
                    return null;
                }

                $entry = EntryApi::find($id);

                if ($entry === null) {
                    return null;
                }
            }
        }

        return $entry;
    }

    public function index()
    {
        $entry = $this->getEntryFromContext();

        if ($entry === null) {
            return $this->output([]);
        }

        $fallback = $this->params->get('fallback', false);

        $results = [];
        $currentLocale = Site::current()->locale();
        $sites = Site::all()->keyBy('locale')->all();
        $entryLocales = $this->entryLocales->getAllLocales($entry);

        if ($fallback) {
            foreach ($sites as $siteLocale => $site) {
                $siteUrl = $site->url();

                $results[$siteLocale] = [
                    'has_locale' => false,
                    'url' => $siteUrl,
                    'site' => $site,
                    'is_current' => $siteLocale === $currentLocale,
                    'locale' => $site->handle(),
                ];
            }
        }

        foreach ($entryLocales as $entryLocale => $localizedEntry) {
            // Only include locales that are available in a site.
            if (! isset($sites[$entryLocale])) {
                continue;
            }

            if (! $fallback) {
                $results[$entryLocale] = [
                    'has_locale' => true,
                    'url' => $localizedEntry->url(),
                    'site' => $sites[$entryLocale],
                    'is_current' => $entryLocale === $currentLocale,
                    'locale' => $sites[$entryLocale]->handle(),
                ];
            } else {
                $results[$entryLocale]['has_locale'] = true;
                $results[$entryLocale]['url'] = $localizedEntry->url();
            }

            $results[$entryLocale] = array_merge($results[$entryLocale], $localizedEntry->toAugmentedArray());
        }

        return $this->output(array_values($results));
    }

    public function variants()
    {
        $entry = $this->getEntryFromContext();

        if ($entry === null) {
            return $this->output([]);
        }

        return $this->output(array_values($this->entryLocales->getLocaleVariants($entry)));
    }
}
