<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Site Essentials Tags
    |--------------------------------------------------------------------------
    |
    | Specifies which Site Essentials tags are to be loaded.
    |
    */

    'tags' => [
        \Stillat\StatamicSiteEssentials\Tags\TemplateManagement\SeCapture::class,
        \Stillat\StatamicSiteEssentials\Tags\SeRandomId::class,
        \Stillat\StatamicSiteEssentials\Tags\Metadata\SeMeta::class,
        \Stillat\StatamicSiteEssentials\Tags\Metadata\SeWebManifest::class,
        \Stillat\StatamicSiteEssentials\Tags\Metadata\SeGetFavicons::class,
        \Stillat\StatamicSiteEssentials\Tags\SeException::class,
        \Stillat\StatamicSiteEssentials\Tags\Entries\SeEntryLocales::class,
        \Stillat\StatamicSiteEssentials\Tags\TemplateManagement\SeCurrentView::class,
        \Stillat\StatamicSiteEssentials\Tags\TemplateManagement\SeView::class,
        \Stillat\StatamicSiteEssentials\Tags\TemplateManagement\SeDeferred::class,
        \Stillat\StatamicSiteEssentials\Tags\TemplateManagement\SeAssetQueue::class,
    ],

    /*
    |--------------------------------------------------------------------------
    | Site Essentials Modifiers
    |--------------------------------------------------------------------------
    |
    | Specifies which Site Essentials modifiers are to be loaded.
    |
    */

    'modifiers' => [
        \Stillat\StatamicSiteEssentials\Modifiers\SeRadiusExcerpt::class,
        \Stillat\StatamicSiteEssentials\Modifiers\SeStrFinish::class,
        \Stillat\StatamicSiteEssentials\Modifiers\Array\SeEach::class,
        \Stillat\StatamicSiteEssentials\Modifiers\Array\SeIsSetType::class,
        \Stillat\StatamicSiteEssentials\Modifiers\Code\SeCodeMirrorToHighlightJs::class,
    ],

    /*
    |--------------------------------------------------------------------------
    | Observe Views
    |--------------------------------------------------------------------------
    |
    | When true, the Site Essentials view observer will be enabled. This
    | will allow you to use the `{{ se_view }}` tag related features.
    |
    */

    'observe_views' => true,
];
