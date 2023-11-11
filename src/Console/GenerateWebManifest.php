<?php

namespace Stillat\StatamicSiteEssentials\Console;

use Illuminate\Console\Command;
use Stillat\StatamicSiteEssentials\Support\Facades\WebManifest;

class GenerateWebManifest extends Command
{
    protected $signature = 'site-essentials:generate-web-manifest';

    protected $description = 'Generates a web manifest for the site.';

    public function handle()
    {
        $this->info('Generating web manifest...');

        WebManifest::generate();

        $this->info('Generating web manifest... done!');
    }
}
