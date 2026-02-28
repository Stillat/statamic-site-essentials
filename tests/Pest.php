<?php

use Statamic\Facades\Antlers;

uses(Tests\TestCase::class)->in('Feature');

function antlers(string $template, array $data = []): string
{
    return (string) Antlers::parse($template, $data, true);
}

function antlersTag(string $tag, array $data = []): string
{
    return (string) Antlers::parse("{{ {$tag} }}", $data, true);
}
