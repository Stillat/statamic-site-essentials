<?php

return [
    'rules' => [
        'title' => [],
        'meta' => [
            ['charset'],
            ['http-equiv="*"'],
            ['viewport'],
            ['name="robots"'],
            ['name="x-robots-tag"'],
            ['name="description"'],
            ['name="keywords"'],
            ['name="author"'],
            ['name="application-name"'],
            ['name="theme-color"'],
            ['name="color-scheme"'],
            ['name="format-detection"'],
            ['name="referrer"'],
            ['name="copyright"'],
            ['name="rating"'],
            ['name="designer"'],
            ['name="reply-to"'],
            ['name="identifier-URL"'],

            ['name="ICBM"'],
            ['name="geo.position"'],
            ['name="geo.placename"'],
            ['name="geo.region"'],

            ['name="google-site-verification"'],
            ['name="yandex-verification"'],
            ['name="msvalidate.01"'],
            ['name="p:domain_verify"'],
            ['name="csrf-token"'],
            ['name="norton-safeweb-site-verification"'],

            ['property="og:title"'],
            ['property="og:site_name"'],
            ['property="og:url"'],
            ['property="og:type"'],
            ['property="og:description"'],
            ['property="og:locale"'],

            ['property="fb:app_id"'],

            ['property="twitter:card"'],
            ['property="twitter:site"'],
            ['property="twitter:title"'],
            ['property="twitter:description"'],
            ['property="twitter:image"'],

            ['name="msapplication-TileColor"'],
            ['name="msapplication-TileImage"'],
            ['name="msapplication-navbutton-color"'],
            ['name="apple-mobile-web-app-capable"'],
            ['name="apple-mobile-web-app-status-bar-style"'],
        ],
        'link' => [
            [
                'rel="icon"',
                'type="*"',
                'sizes="*"',
            ],
            ['rel="shortcut icon"'],
            ['rel="canonical"'],
            ['rel="author"'],
            ['rel="publisher"'],
            ['rel="prev"'],
            ['rel="next"'],
            ['rel="manifest"'],
            [
                'rel' => 'apple-touch-icon',
                'sizes' => '*',
            ],
            ['rel="mask-icon"'],
        ],
    ],
];
