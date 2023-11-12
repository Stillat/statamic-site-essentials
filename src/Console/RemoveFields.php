<?php

namespace Stillat\StatamicSiteEssentials\Console;

use Illuminate\Console\Command;
use Statamic\Facades\Collection;
use Statamic\Facades\Entry;

use function Laravel\Prompts\multiselect;
use function Laravel\Prompts\progress;
use function Laravel\Prompts\text;

class RemoveFields extends Command
{
    protected $signature = 'site-essentials:remove-fields';

    protected $description = 'Helps remove fields from entries.';

    public function handle()
    {
        $collections = Collection::all();
        $options = collect($collections)->mapWithKeys(function ($collection) {
            return [$collection->handle() => $collection->title()];
        })->toArray();

        $selection = multiselect(
            label: 'Which collections would you like to remove fields from?',
            options: array_prepend($options, 'All Collections', '*'),
        );

        if (in_array('*', $selection)) {
            $selection = array_keys($options);
        }

        if (count($selection) == 0) {
            return;
        }

        $fields = text(
            label: 'Which fields would you like to remove? Seperate with commas.',
            placeholder: 'field1, field2, field3',
        );

        $fields = collect(explode(',', $fields))->map(function ($field) {
            return trim($field);
        })->filter(function ($field) {
            return $field != '';
        })->toArray();

        if (count($fields) == 0) {
            return;
        }

        $entries = Entry::whereInCollection($selection)->all();

        $progress = progress(
            label: 'Removing fields...',
            steps: count($entries),
        );

        /** @var \Statamic\Entries\Entry $entry */
        foreach ($entries as $entry) {
            $progress->hint = 'Processing '.(string) $entry['title'];
            $data = $entry->data();
            $changesMade = false;

            foreach ($fields as $field) {
                if (isset($data[$field])) {
                    unset($data[$field]);
                    $changesMade = true;
                }
            }

            if (! $changesMade) {
                $progress->advance();

                continue;
            }

            $entry->data($data);
            $entry->saveQuietly();
            $progress->advance();
        }
    }
}
