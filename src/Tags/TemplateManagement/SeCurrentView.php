<?php

namespace Stillat\StatamicSiteEssentials\Tags\TemplateManagement;

use Statamic\Tags\Tags;
use Statamic\View\Antlers\Language\Runtime\GlobalRuntimeState;

class SeCurrentView extends Tags
{
    public function index()
    {
        if (count(GlobalRuntimeState::$templateFileStack) == 0) {
            return '';
        }

        $lastItem = GlobalRuntimeState::$templateFileStack[count(GlobalRuntimeState::$templateFileStack) - 1];

        if (! $lastItem || count($lastItem) == 0) {
            return '';
        }

        $path = str_replace('\\', '/', $lastItem[0]);
        $basePath = str_replace('\\', '/', base_path());

        return mb_substr($path, mb_strlen($basePath) + 1);
    }

    public function wrap()
    {
        if (app()->isProduction()) {
            return '';
        }

        $currentView = $this->index();

        if ($currentView == '') {
            return '';
        }

        $content = '<!-- START: '.$currentView.' -->';
        $content .= $this->parse();
        $content .= '<!-- END:   '.$currentView.' -->';

        return $content;
    }

    public function start()
    {
        if (app()->isProduction()) {
            return '';
        }

        $currentView = $this->index();

        if ($currentView == '') {
            return '';
        }

        return '<!-- START: '.$currentView.' -->';
    }

    public function end()
    {
        if (app()->isProduction()) {
            return '';
        }

        $currentView = $this->index();

        if ($currentView == '') {
            return '';
        }

        return '<!-- END:   '.$currentView.' -->';
    }
}
