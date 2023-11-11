<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Webmanifest Public Path Configuration
    |--------------------------------------------------------------------------
    |
    | Controls the public path where the generated webmanifest file
    | will be saved. This path should be accessible to the web.
    |
    */

    'path' => public_path('site.webmanifest'),

    /*
    |--------------------------------------------------------------------------
    | Manifest File Configuration
    |--------------------------------------------------------------------------
    |
    | The 'Manifest' option holds key/value pairs that are JSON-serialized for
    | inclusion in generated manifest files. It integrates icons from favicon
    | settings, ensuring they're represented in the resulting manifest file.
    |
    */

    'manifest' => [
        'name' => config('app.name'),
        'short_name' => config('app.name'),
        'start_url' => '/',
        'display' => 'standalone',
        'background_color' => '#ffffff',
        'theme_color' => '#ffffff',
        'description' => '',
        'prefer_related_applications' => false,
        'related_applications' => [

        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Manifest Meta Tag Attributes Configuration
    |--------------------------------------------------------------------------
    |
    | The 'Tag Attributes' setting specifies key/value pairs to be appended as
    | HTML attributes when generating the meta tag for the manifest file.
    |
    */

    'tag_attributes' => [
        'rel' => 'manifest',
        'crossorigin' => 'anonymous',
    ],

];
