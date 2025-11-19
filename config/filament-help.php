<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Public Route Prefix
    |--------------------------------------------------------------------------
    |
    | The URL prefix for public help article routes.
    |
    | Default: 'help-articles'
    |
    */
    'route_prefix' => env('FILAMENT_HELP_ROUTE_PREFIX', 'help-articles'),
    
    /*
    |--------------------------------------------------------------------------
    | Public Route Middleware
    |--------------------------------------------------------------------------
    |
    | Middleware to apply to public help article routes. The package provides
    | AllowPublicHelpAccess middleware by default which allows all users
    | (authenticated and unauthenticated) to access the routes.
    |
    | Default: [\Tapp\FilamentHelp\Http\Middleware\AllowPublicHelpAccess::class]
    |
    */
    /** @phpstan-ignore-next-line */
    'route_middleware' => [\Tapp\FilamentHelp\Http\Middleware\AllowPublicHelpAccess::class],
    
    /*
    |--------------------------------------------------------------------------
    | Layout Component
    |--------------------------------------------------------------------------
    |
    | The layout component to use for public help articles. This should point
    | to a Blade component that uses $slot for content. The package provides
    | a default 'help-layout' component.
    |
    | To use your own custom layout, create a component and set this to its
    | kebab-case name (e.g., 'custom-help-layout' for CustomHelpLayout).
    | 
    | Default: 'help-layout'
    |
    */
    'layout' => env('FILAMENT_HELP_LAYOUT', 'help-layout'),
    
    /*
    |--------------------------------------------------------------------------
    | Layout Logo URL
    |--------------------------------------------------------------------------
    |
    | The URL to link to when clicking the logo in the help layout.
    |
    | Default: '/' (home page)
    |
    */
    'logo_url' => env('FILAMENT_HELP_LOGO_URL', '/'),
    
    /*
    |--------------------------------------------------------------------------
    | Layout CSS Files
    |--------------------------------------------------------------------------
    |
    | CSS files to include in the help layout. This accepts an array of CSS
    | file paths that will be passed to @vite().
    |
    | Default: ['resources/css/app.css']
    |
    */
    'css' => [
        'resources/css/app.css',
    ],
    
    /*
    |--------------------------------------------------------------------------
    | Layout Theme CSS
    |--------------------------------------------------------------------------
    |
    | Additional theme CSS file to include. This is useful for adding Filament
    | panel theme CSS to match your app's styling.
    |
    | Example: 'resources/css/filament/app/theme.css'
    |
    | Default: null
    |
    */
    'theme' => null,
];
