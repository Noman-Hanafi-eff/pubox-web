<?php

return [
    'name' => 'FleeCart',
    'manifest' => [
        'name' => env('APP_NAME', 'FleetCart'),
        'short_name' => 'FleetCart',
        'start_url' => '/',
        'background_color' => '#ffffff',
        'theme_color' => '#0068e1',
        'display' => 'standalone',
        'orientation' => 'any',
        'status_bar' => '#0068e1',
        'icons' => [
            '48x48' => [
                'path' => '/pwa/icons/icon-48x48.png',
                'purpose' => 'any',
            ],
            '72x72' => [
                'path' => '/pwa/icons/icon-72x72.png',
                'purpose' => 'any',
            ],
            '96x96' => [
                'path' => '/pwa/icons/icon-96x96.png',
                'purpose' => 'any',
            ],
            '128x128' => [
                'path' => '/pwa/icons/icon-128x128.png',
                'purpose' => 'any',
            ],
            '144x144' => [
                'path' => '/pwa/icons/icon-144x144.png',
                'purpose' => 'any',
            ],
            '152x152' => [
                'path' => '/pwa/icons/icon-152x152.png',
                'purpose' => 'any',
            ],
            '192x192' => [
                'path' => '/pwa/icons/icon-192x192.png',
                'purpose' => 'any',
            ],
            '384x384' => [
                'path' => '/pwa/icons/icon-384x384.png',
                'purpose' => 'any',
            ],
            '512x512' => [
                'path' => '/pwa/icons/icon-512x512.png',
                'purpose' => 'any',
            ],
        ],
        'splash' => [
            '640x1136' => '/pwa/splashes/splash-640x1136.png',
            '750x1334' => '/pwa/splashes/splash-750x1334.png',
            '828x1792' => '/pwa/splashes/splash-828x1792.png',
            '1125x2436' => '/pwa/splashes/splash-1125x2436.png',
            '1242x2208' => '/pwa/splashes/splash-1242x2208.png',
            '1242x2688' => '/pwa/splashes/splash-1242x2688.png',
            '1536x2048' => '/pwa/splashes/splash-1536x2048.png',
            '1668x2224' => '/pwa/splashes/splash-1668x2224.png',
            '1668x2388' => '/pwa/splashes/splash-1668x2388.png',
            '2048x2732' => '/pwa/splashes/splash-2048x2732.png',
        ],
        'shortcuts' => [],
        'custom' => [],
    ],
];
