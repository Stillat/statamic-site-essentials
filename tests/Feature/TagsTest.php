<?php

test('se random accepts a length', function () {
    expect(antlersTag('se_random_id'))->toHaveLength(16);
    expect(antlersTag('se_random_id length="29"'))->toHaveLength(29);

    // Four is the minimum length.
    expect(antlersTag('se_random_id length="1"'))->toHaveLength(4);
});

test('the capture tag captures content', function () {
    $template = <<<'EOT'
A
{{ se_capture:region_name }}
The captured content.
{{ /se_capture:region_name }}
B
{{ se_capture:region_name }}
C
EOT;

    $expected = <<<'EXP'
A

B

The captured content.

C
EXP;

    expect(antlers($template))->toBe($expected);
});
