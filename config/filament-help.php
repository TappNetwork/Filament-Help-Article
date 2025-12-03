<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Frontend Help Slug
    |--------------------------------------------------------------------------
    |
    | The URL slug for authenticated user help articles in the frontend panel.
    | This can be overridden when registering the plugin using ->slug('custom-slug').
    |
    | Default: 'help'
    |
    */
    'frontend_slug' => env('FILAMENT_HELP_FRONTEND_SLUG', 'help'),

    /*
    |--------------------------------------------------------------------------
    | Guest Help Slug
    |--------------------------------------------------------------------------
    |
    | The URL slug for guest/public help articles in the guest panel.
    | Set to empty string ('') to use the panel path directly.
    | This can be overridden when registering the plugin using ->slug('custom-slug').
    |
    | Default: '' (empty - uses panel path)
    |
    */
    'guest_slug' => env('FILAMENT_HELP_GUEST_SLUG', ''),
];
