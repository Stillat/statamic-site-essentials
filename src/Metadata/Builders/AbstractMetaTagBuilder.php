<?php

namespace Stillat\StatamicSiteEssentials\Metadata\Builders;

use Stillat\StatamicSiteEssentials\Metadata\MetadataManager;

class AbstractMetaTagBuilder
{
    protected MetadataManager $metadataManager;

    public function __construct(MetadataManager $metadataManager)
    {
        $this->metadataManager = $metadataManager;
    }

    protected function add(array $attributes): self
    {
        $this->metadataManager->queue($attributes);

        return $this;
    }

    protected function property(string $property, $value): self
    {
        return $this->add([
            'property' => $property,
            'content' => $this->value($value),
        ]);
    }

    protected function value($value): array
    {
        return [
            'reject_empty' => true,
            'value' => $value,
        ];
    }

    protected function getManager(): MetadataManager
    {
        return $this->metadataManager;
    }
}
