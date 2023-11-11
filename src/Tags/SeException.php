<?php

namespace Stillat\StatamicSiteEssentials\Tags;

use Exception;
use Statamic\Tags\Tags;

class SeException extends Tags
{
    protected static $aliases = ['500'];

    /**
     * @throws Exception
     */
    public function index()
    {
        $message = $this->params->get('message', 'This is a test exception.');

        throw new Exception($message);
    }
}
