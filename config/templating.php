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
        \Stillat\StatamicSiteEssentials\Modifiers\SeGetReadTime::class,
        \Stillat\StatamicSiteEssentials\Modifiers\SeRadiusExcerpt::class,
        \Stillat\StatamicSiteEssentials\Modifiers\SeStrFinish::class,
        \Stillat\StatamicSiteEssentials\Modifiers\Array\SeEach::class,
        \Stillat\StatamicSiteEssentials\Modifiers\Code\SeCodeMirrorToHighlightJs::class,
    ],

];
