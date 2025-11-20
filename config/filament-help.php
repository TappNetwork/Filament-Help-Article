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
    | main app CSS file (Tailwind CSS required for styling).
    |
    | You can add multiple CSS files if needed, e.g.:
    | 'css' => ['resources/css/app.css', 'resources/css/custom.css']
    |
    | Default: ['resources/css/app.css']
    |
    */
    'css' => ['resources/css/app.css'],
];
