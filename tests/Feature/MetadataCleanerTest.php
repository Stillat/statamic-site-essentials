<?php

function cleanMetadata(string $input): string
{
    $cleaner = new \Stillat\StatamicSiteEssentials\Metadata\MetadataCleaner();

    return $cleaner->withConfiguredRules()->clean($input);
}

test('multiple title tags', function () {
    $input = <<<'EOT'
<title class="tricky">one</title>
<title>two</title>
EOT;

    expect(cleanMetadata($input))->toBe('<title>two</title>');
});

test('multiple tags are preserved', function () {
    $input = <<<'EOT'
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>My title</title>
<meta property="og:title" content="ÜÜÜÜÜÜÜÜÜÜÜÜÜÜ">
<meta property="og:type" content="website">
<meta property="og:url" content="http://localhost/de">
<meta property="og:locale" content="de_DE">
<meta property="og:locale:alternate" content="en_US">
<meta property="og:locale:alternate" content="fr_FR">
EOT;

    expect(cleanMetadata($input))->toBe($input);
});

test('casing is ignored', function () {
    $input = <<<'EOT'
<META charset="utf-8">
<META http-EQUIV="X-UA-Compatible" content="IE=edge">
EOT;

    $output = <<<'EOT'
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
EOT;

    expect(cleanMetadata($input))->toBe($output);
});

test('extra tags are removed', function () {
    $input = <<<'EOT'
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>My title</title>
<meta property="og:title" content="ÜÜÜÜÜÜÜÜÜÜÜÜÜÜ">
<meta property="og:type" content="website">
<meta property="og:url" content="http://localhost/de">
<meta property="og:locale" content="de_DE">
<meta property="og:locale:alternate" content="en_US">
<meta property="og:locale:alternate" content="fr_FR">
EOT;

    expect(cleanMetadata($input.$input.$input))->toBe($input);
});

test('test multiple meta tags', function () {
    $input = <<<'EOT'
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Tidal Overview | Tidal</title>
<meta property="og:title" content="Some more content">
<meta property="og:type" content="website">
<meta property="og:url" content="http://127.0.0.1:8000">
<meta property="og:locale" content="en_US">
<meta name="og:image" content="/social-media-images/ihome-twitter.png">
<meta property="og:image" content="/social-media-images/ihome-facebook.png">
<meta property="og:image:width" content="1200">
<meta property="og:image:height" content="630">
<meta property="og:image:type" content="image/png">
<link rel="shortcut icon" type="image/x-icon" href="/favicon.ico" sizes="16x16">
<link rel="icon" type="image/png" href="/favicon-16x16.png" sizes="16x16">
<link rel="icon" type="image/png" href="/favicon-32x32.png" sizes="32x32">
<link rel="icon" type="image/png" href="/favicon-192x192.png" sizes="192x192">
<link rel="icon" type="image/png" href="/favicon-512x512.png" sizes="512x512">
<link rel="apple-touch-icon" type="image/png" href="/favicon-180x180.png" sizes="180x180">
<link rel="manifest" crossorigin="anonymous" href="/site.webmanifest">
EOT;

    expect(cleanMetadata($input))->toBe($input);
    expect(cleanMetadata($input.$input))->toBe($input);
});

test('only one robots tag is preserved', function () {
    $input = <<<'EOT'
<meta name="robots" content="index, follow">
<meta name="robots" content="noindex, nofollow">
EOT;

    expect(cleanMetadata($input))->toBe('<meta name="robots" content="noindex, nofollow">');
});

test('wildcard rules can be used to insert current content', function () {
    $input = <<<'EOT'
<meta http-equiv="X-UA-Compatible" content="one">
<meta http-equiv="X-UA-Compatible" content="two">
<meta http-equiv="refresh" content="one">
<meta http-equiv="refresh" content="two">
EOT;

    $expected = <<<'EOT'
<meta http-equiv="X-UA-Compatible" content="two">
<meta http-equiv="refresh" content="two">
EOT;

    expect(cleanMetadata($input))->toBe($expected);
});

test('charset meta tag should appear only once and the last one should be preserved', function () {
    $input = <<<'EOT'
<meta charset="UTF-8">
<meta charset="ISO-8859-1">
EOT;

    $expected = <<<'EOT'
<meta charset="ISO-8859-1">
EOT;

    expect(cleanMetadata($input))->toBe($expected);
});

test('viewport meta tag should appear only once and the last one should be preserved', function () {
    $input = <<<'EOT'
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="viewport" content="width=1024">
EOT;

    $expected = <<<'EOT'
<meta name="viewport" content="width=1024">
EOT;

    expect(cleanMetadata($input))->toBe($expected);
});

test('description meta tag should appear only once and the last one should be preserved', function () {
    $input = <<<'EOT'
<meta name="description" content="First description.">
<meta name="description" content="Second description.">
EOT;

    $expected = <<<'EOT'
<meta name="description" content="Second description.">
EOT;

    expect(cleanMetadata($input))->toBe($expected);
});

test('open graph title should appear only once and the last one should be preserved', function () {
    $input = <<<'EOT'
<meta property="og:title" content="First Title">
<meta property="og:title" content="Second Title">
EOT;

    $expected = <<<'EOT'
<meta property="og:title" content="Second Title">
EOT;

    expect(cleanMetadata($input))->toBe($expected);
});

test('author meta tag should appear only once and the last one should be preserved', function () {
    $input = <<<'EOT'
<meta name="author" content="First Author">
<meta name="author" content="Second Author">
EOT;

    $expected = <<<'EOT'
<meta name="author" content="Second Author">
EOT;

    expect(cleanMetadata($input))->toBe($expected);
});

test('canonical link should appear only once and the last one should be preserved', function () {
    $input = <<<'EOT'
<link rel="canonical" href="http://example.com/page1">
<link rel="canonical" href="http://example.com/page2">
EOT;

    $expected = <<<'EOT'
<link rel="canonical" href="http://example.com/page2">
EOT;

    expect(cleanMetadata($input))->toBe($expected);
});

test('favicon link should appear only once and the last one should be preserved', function () {
    $input = <<<'EOT'
<link rel="icon" type="image/png" href="favicon1.png">
<link rel="icon" type="image/png" href="favicon2.png">
EOT;

    $expected = <<<'EOT'
<link rel="icon" type="image/png" href="favicon2.png">
EOT;

    expect(cleanMetadata($input))->toBe($expected);
});
