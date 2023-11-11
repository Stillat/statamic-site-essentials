<?php

namespace Stillat\StatamicSiteEssentials\Console;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Event;
use Stillat\StatamicSiteEssentials\Events\GeneratedNewFavicon;
use Stillat\StatamicSiteEssentials\Events\GeneratingNewFavicons;
use Stillat\StatamicSiteEssentials\Events\RemovedGeneratedFavicon;
use Stillat\StatamicSiteEssentials\Events\RemovingGeneratedFavicons;
use Stillat\StatamicSiteEssentials\Support\Facades\Favicons;

use function Laravel\Prompts\progress;

class GenerateFavicons extends Command
{
    protected $signature = 'site-essentials:generate-favicons';

    protected $description = 'Generates favicons for the site.';

    public function handle()
    {
        if (! config('site_essentials.favicons.enabled', false)) {
            $this->info('Favicons are disabled.');

            return;
        }

        $progress = progress(
            label: 'Preparing to generate favicons...',
            steps: 1,
            hint: 'This may take some time.'
        );

        Event::listen(RemovingGeneratedFavicons::class, function (RemovingGeneratedFavicons $event) use ($progress) {
            $progress->label = 'Removing existing favicons...';
            $progress->total = count($event->paths);
        });

        Event::listen(RemovedGeneratedFavicon::class, function (RemovedGeneratedFavicon $event) use ($progress) {
            $progress->advance();
            $progress->hint = $event->path;
        });

        Event::listen(GeneratingNewFavicons::class, function (GeneratingNewFavicons $event) use ($progress) {
            $progress->label = 'Preparing to generate new favicons...';
            $progress->progress = 0;
            $progress->total = count($event->icons);
        });

        $basePathLen = mb_strlen(public_path());

        Event::listen(GeneratedNewFavicon::class, function (GeneratedNewFavicon $event) use ($progress, $basePathLen) {
            $progress->label = 'Generating new favicons...';
            $progress->advance();
            $progress->hint = mb_substr($event->path, $basePathLen);
        });

        Favicons::generate();

        $progress->hint = '';

        $progress->finish();
    }
}
