<?php

test('se radius excerpt modifier', function () {
    $input = 'one two three four five six seven eight nine ten eleven twelve thirteen fourteen fifteen sixteen seventeen eighteen nineteen twenty';
    $modifier = new \Stillat\StatamicSiteEssentials\Modifiers\SeRadiusExcerpt();

    expect($modifier->index($input, [], []))->toBe($input);
    expect($modifier->index($input, ['one', 10], []))->toBe('one two three…');
    expect($modifier->index($input, ['one', 10, '...'], []))->toBe('one two three...');
});

test('str finish modifier', function () {
    $modifier = new \Stillat\StatamicSiteEssentials\Modifiers\SeStrFinish();

    expect($modifier->index('one', ['/'], []))->toBe('one/');
    expect($modifier->index('one/', ['/'], []))->toBe('one/');
});

test('each modifier will apply a partial to each item in an array', function () {
    $template = <<<'EOT'
{{ data | se_each('partials/each') }}
EOT;

    $data = [
        [
            'name' => 'one',
        ],
        [
            'name' => 'two',
        ],
        [
            'name' => 'three',
        ],
    ];

    expect(antlers($template, ['data' => $data]))->toBe('The Name: one The Name: two The Name: three ');
});
