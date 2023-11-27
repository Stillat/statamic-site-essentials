<?php

namespace Stillat\StatamicSiteEssentials\Tags\Metadata;

use Statamic\Tags\Tags;
use Statamic\View\State\ResetsState;
use Stillat\StatamicAttributeRenderer\Concerns\CreatesMetaTags;
use Stillat\StatamicSiteEssentials\Metadata\MetaBuilder;
use Stillat\StatamicSiteEssentials\Metadata\MetadataManager;
use Stillat\StatamicSiteEssentials\Support\Facades\Metadata;

class SeMeta extends Tags implements ResetsState
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
            $additionalMeta .= $this->metadataManager->getThirdPartyTemplates();
        }

        $additionalMeta .= $this->metadataManager->getAppendedContent();

        if (config('site_essentials.metadata.guard_index_follow', true) && ! app()->isProduction()) {
            $additionalMeta .= '<meta name="robots" content="noindex, nofollow">';
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

    public function append(): void
    {
        if (! $this->isPair) {
            return;
        }

        $this->metadataManager->appendContent((string) $this->parse());
    }

    public static function resetStaticState()
    {
        Metadata::clearAppendedContent();
    }
}
