<?php

namespace Stillat\StatamicSiteEssentials\View\AssetQueues;

use DOMDocument;
use DOMXPath;

class QueueManager
{
    protected array $queues = [];

    protected array $queueItems = [];

    public function getQueueContent(string $queueName): string
    {
        if (! array_key_exists($queueName, $this->queues)) {
            return '';
        }

        return implode("\n", $this->queues[$queueName]);
    }

    public function queueScript(string $script): void
    {
        $this->addToQueue('scripts', $script);
    }

    public function queueStyle(string $style): void
    {
        $this->addToQueue('styles', $style);
    }

    protected function parseHtml(string $content): DOMDocument
    {
        $html = '<html><meta http-equiv="Content-Type" content="text/html; charset=utf-8"><body>'.$content.'</body></html>';
        $dom = new DOMDocument();
        @$dom->loadHTML($html, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);

        return $dom;
    }

    public function queueGeneral(string $general): void
    {
        $dom = $this->parseHtml($general);

        $xpath = new DOMXPath($dom);

        $tags = $xpath->query('//body/*');

        for ($i = 0; $i < $tags->length; $i++) {
            $tag = $tags->item($i);

            // Normalize items.
            if ($tag->tagName == 'script') {
                $this->addItemToQueue('scripts', $dom->saveHTML($tag));
            } elseif ($tag->tagName == 'style') {
                $this->addItemToQueue('styles', $dom->saveHTML($tag));
            }
        }
    }

    protected function addItemToQueue(string $queueName, string $item): void
    {
        if (! array_key_exists($queueName, $this->queues)) {
            $this->queues[$queueName] = [];
        }

        if (! array_key_exists($queueName, $this->queueItems)) {
            $this->queueItems[$queueName] = [];
        }

        $normalizedHtml = trim($item);
        $hashedContent = md5($normalizedHtml);

        if (! in_array($hashedContent, $this->queueItems[$queueName])) {
            $this->queueItems[$queueName][] = $hashedContent;
            $this->queues[$queueName][] = $normalizedHtml;
        }
    }

    public function addToQueue(string $queueName, string $script): void
    {
        $dom = $this->parseHtml($script);

        $xpath = new DOMXPath($dom);

        $tags = $xpath->query('//body/*');

        for ($i = 0; $i < $tags->length; $i++) {
            $tag = $tags->item($i);

            // Normalize items.
            $this->addItemToQueue($queueName, $dom->saveHTML($tag));
        }
    }

    public function reset(): void
    {
        $this->queueItems = [];
        $this->queues = [];
    }
}
