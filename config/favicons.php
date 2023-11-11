<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Favicon Generation Feature Toggle
    |--------------------------------------------------------------------------
    |
    | The 'Enabled' configuration key activates the Site Essentials' favicon
    | generation feature. When set to true, generated favicons will be
    | added to generated manifest files, as well as other features.
    |
    */

    'enabled' => true,

    /*
    |--------------------------------------------------------------------------
    | Image Resize Driver Configuration for Favicons
    |--------------------------------------------------------------------------
    |
    | The 'Driver' setting identifies the specific image resizing driver
    | the favicon generator will use. This driver handles the scaling of
    | images to the appropriate dimensions for all favicons created.
    |
    */

    'driver' => \Stillat\StatamicSiteEssentials\Favicons\Drivers\ImagickDriver::class,

    /*
    |--------------------------------------------------------------------------
    | Temporary Path
    |--------------------------------------------------------------------------
    |
    | A temporary path where meta-data about the favicon generation process
    | will be stored. This path should be writable by the web server.
    |
    */

    'tmp_path' => storage_path('statamic-site-essentials'),

    /*
    |--------------------------------------------------------------------------
    | Remove Existing Images
    |--------------------------------------------------------------------------
    |
    | Determines whether existing favicons should be removed before
    | generating new ones. This feature relies on the temporary
    | path being writable by the web server, as it contains
    | the file paths to the existing favicon images.
    |
    */

    'remove_existing' => true,

    /*
    |--------------------------------------------------------------------------
    | Favicon Icons Configuration
    |--------------------------------------------------------------------------
    |
    | The 'icons' array contains the set of favicon sizes to be generated.
    |
    | Icons must include:
    | * 'rel': The relation attribute for the link element in HTML.
    | * 'size': The dimensions of the favicon, like '16x16'.
    | * 'format': The file format for the icon, e.g., 'png', 'jpg'.
    |
    */

    'icons' => [
        [
            'rel' => 'shortcut icon',
            'size' => '16x16',
            'format' => 'ico',
        ],
        [
            'rel' => 'icon',
            'size' => '16x16',
            'format' => 'png',
        ],
        [
            'rel' => 'icon',
            'size' => '32x32',
            'format' => 'png',
        ],
        [
            'rel' => 'icon',
            'size' => '192x192',
            'format' => 'png',
        ],
        [
            'rel' => 'icon',
            'size' => '512x512',
            'format' => 'png',
        ],
        [
            'rel' => 'apple-touch-icon',
            'size' => '180x180',
            'format' => 'png',
        ],
    ],

];
