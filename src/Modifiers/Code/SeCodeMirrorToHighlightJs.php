<?php

namespace Stillat\StatamicSiteEssentials\Modifiers\Code;

use Statamic\Modifiers\Modifier;

class SeCodeMirrorToHighlightJs extends Modifier
{
    protected static $handle = 'se_cm_to_hljs';

    protected array $languageMappings = [
        'htmlmixed' => 'html',
        'javascript' => 'js',
        'python' => 'python',
        'clike' => 'cpp',
        'php' => 'php',
        'shell' => 'bash',
        'sass' => 'scss',
        'coffeescript' => 'coffeescript',
        'markdown' => 'md',
        'vb' => 'vbnet',
    ];

    public function index($value, $params, $context)
    {
        $value = (string) $value;

        if (array_key_exists($value, $this->languageMappings)) {
            $value = $this->languageMappings[$value];
        }

        return $value;
    }
}
