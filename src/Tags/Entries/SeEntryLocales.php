<?php

namespace Stillat\StatamicSiteEssentials\Tags\Entries;

use Statamic\Entries\Entry;
use Statamic\Facades\Entry as EntryApi;
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

        return $this->output(array_values($this->entryLocales->getLocaleVariants($entry)));
    }
}
