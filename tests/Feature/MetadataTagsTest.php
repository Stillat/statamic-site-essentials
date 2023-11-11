<?php

use Stillat\StatamicSiteEssentials\Support\Facades\Metadata;

test('meta tag renders queued meta tags', function () {
    $template = <<<'EOT'
{{ se_meta /}}
EOT;

    Metadata::general()
        ->charset()
        ->title('Hello World')
        ->self('http://localhost');

    expect(antlers($template))->toContain(
        '<meta charset="utf-8">',
        '<title>Hello World</title>',
        '<link rel="self" href="http://localhost">',
    );
});
