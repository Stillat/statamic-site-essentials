<?php

namespace Stillat\StatamicSiteEssentials\Tags\TemplateManagement;

use Statamic\Tags\Tags;
use Stillat\StatamicSiteEssentials\View\AssetQueues\QueueManager;

class SeAssetQueue extends Tags
{
    protected QueueManager $queueManager;

    public function __construct(QueueManager $queueManager)
    {
        $this->queueManager = $queueManager;
    }

    public function index()
    {
        $queues = $this->params->get('queue');
        $queues = explode('|', $queues);

        $queueContent = '';

        foreach ($queues as $queue) {
            $queueContent .= $this->queueManager->getQueueContent($queue);
        }

        return $queueContent;
    }

    public function queue()
    {
        $this->queueManager->queueGeneral($this->parse());
    }

    public function style()
    {
        $this->queueManager->queueStyle($this->parse());
    }

    public function script()
    {
        $this->queueManager->queueScript($this->parse());
    }
}
