<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Agency / Company Configuration
    | Change these values for each new client deployment
    |--------------------------------------------------------------------------
    */

    'name'          => env('AGENCY_NAME', 'Archvadze'),
    'full_name'     => env('AGENCY_FULL_NAME', 'Archvadze Web Agency'),
    'tagline'       => env('AGENCY_TAGLINE', 'Build Your Digital Presence'),
    'email'         => env('AGENCY_EMAIL', 'info@archvadze.com'),
    'admin_email'   => env('ADMIN_EMAIL', 'admin@archvadze.com'),
    'admin_path'    => env('ADMIN_PATH', 'manage'),
    'phone'         => env('AGENCY_PHONE', '+995 555 123 456'),
    'address'       => env('AGENCY_ADDRESS', 'Tbilisi, Georgia'),
    'url'           => env('APP_URL', 'https://archvadze.com'),

    // Email signatures
    'team_signature'   => env('AGENCY_TEAM_SIGNATURE', 'Archvadze Web Agency Team'),
    'system_signature' => env('AGENCY_SYSTEM_SIGNATURE', 'Archvadze Web Agency System'),

    // SEO defaults
    'seo' => [
        'title_suffix'  => env('AGENCY_SEO_SUFFIX', 'Archvadze'),
        'description'   => env('AGENCY_SEO_DESCRIPTION', 'Professional web development agency'),
        'author'        => env('AGENCY_SEO_AUTHOR', 'Archvadze'),
    ],

    // Social
    'social' => [
        'facebook'  => env('AGENCY_FACEBOOK', ''),
        'twitter'   => env('AGENCY_TWITTER', ''),
        'instagram' => env('AGENCY_INSTAGRAM', ''),
        'linkedin'  => env('AGENCY_LINKEDIN', ''),
    ],
];
