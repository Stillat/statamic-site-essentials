<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Guard Index Follow
    |--------------------------------------------------------------------------
    |
    | When set to true <meta name="robots" content="noindex, nofollow">
    | will be added to the <head> of the page when the current user
    | for environments that are not the production environment.
    |
    */

    'guard_index_follow' => true,

    /*
    |--------------------------------------------------------------------------
    | X/Twitter Card Information
    |--------------------------------------------------------------------------
    |
    | Information that will be used to generate the <meta> tags for
    | Twitter cards. If a value is null, the tag will not be used.
    |
    */

    'twitter' => [
        'site' => null,
        'site_id' => null,
        'creator' => null,
        'creator_id' => null,

        'card' => null,

        'app_name_iphone' => null,
        'app_id_iphone' => null,
        'app_url_iphone' => null,

        'app_name_ipad' => null,
        'app_id_ipad' => null,
        'app_url_ipad' => null,

        'app_name_googleplay' => null,
        'app_id_googleplay' => null,
        'app_url_googleplay' => null,
    ],
];
