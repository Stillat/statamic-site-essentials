<?php

namespace Stillat\StatamicSiteEssentials\Tags\Metadata;

use Statamic\Tags\Tags;
use Stillat\StatamicAttributeRenderer\Concerns\CreatesMetaTags;
use Stillat\StatamicSiteEssentials\Metadata\MetaBuilder;
use Stillat\StatamicSiteEssentials\Metadata\MetadataManager;
use Stillat\StatamicSiteEssentials\Support\Facades\Metadata;

class SeMeta extends Tags
{
    use CreatesMetaTags;

    protected MetadataManager $metadataManager;

    public function __construct(MetadataManager $metadataManager)
    {
        $this->metadataManager = $metadataManager;
    }

    public function index(): string
    {
        $additionalMeta = '';
        $contextValues = $this->context->all();

        if ($this->isPair) {
            $additionalMeta = $this->parse();
        } else {
            $additionalMeta .= Metadata::getThirdPartyTemplates();
        }

        return $this->metadataManager->toHtml($contextValues, $additionalMeta);
    }

    public function paginate(): void
    {
        $paginate = $this->context->get('paginate', null);

        if (! is_array($paginate)) {
            return;
        }

        Metadata::ephemeral(function (MetaBuilder $meta) use ($paginate) {
            $meta->general()->pagination($paginate);
        });
    }
}
