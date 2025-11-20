<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Public Route Prefix
    |--------------------------------------------------------------------------
    |
    | The URL prefix for public unauthenticated help article routes.
    | Authenticated users are redirected to the Filament panel help resource.
    |
    | Default: 'help-articles'
    |
    */
    'route_prefix' => env('FILAMENT_HELP_ROUTE_PREFIX', 'help-articles'),
    
    /*
    |--------------------------------------------------------------------------
    | CSS Files
    |--------------------------------------------------------------------------
    |
    | CSS files to include in the help layout. This should include your
    | Tailwind CSS file (required for styling to work).
    |
    | Default: ['resources/css/app.css']
    |
    */
    'css' => ['resources/css/app.css'],
    
    /*
    |--------------------------------------------------------------------------
    | Theme CSS
    |--------------------------------------------------------------------------
    |
    | Optional Filament panel theme CSS to match your app's styling.
    | Set to your panel's theme CSS path to ensure consistent branding.
    |
    | Example: 'resources/css/filament/app/theme.css'
    | Default: null
    |
    */
    'theme' => null,
];
