<?php

return [
    'navigation' => [
        'admin' => [
            'register' => true,
            'sort' => 1,
            'icon' => 'heroicon-o-question-mark-circle',
            'group' => 'Help',
        ],
        'frontend' => [
            'register' => true,
            'sort' => 1,
            'icon' => 'heroicon-o-question-mark-circle',
            'label' => 'Help',
        ],
    ],
    /*
    |--------------------------------------------------------------------------
    | Help Layout
    |--------------------------------------------------------------------------
    |
    | The layout component to use for public help articles. This should point
    | to a Blade component that uses $slot for content. The package provides
    | a default 'help-layout' component that uses more page width than the
    | standard guest layout.
    |
    | To use your own custom layout, create a component and set this to its
    | kebab-case name (e.g., 'custom-help-layout' for CustomHelpLayout).
    | 
    | Default: 'help-layout' (package default, wider layout)
    | Alternative: 'guest-layout' (uses your project's guest layout)
    |
    */
    'help_layout' => env('FILAMENT_HELP_LAYOUT', 'help-layout'),
    
    /*
    |--------------------------------------------------------------------------
    | Help Layout Max Width
    |--------------------------------------------------------------------------
    |
    | The maximum width class for the help layout container. This controls
    | how wide the help articles content area can be.
    |
    | Options: 'sm:max-w-md', 'sm:max-w-lg', 'sm:max-w-xl', 'sm:max-w-2xl',
    |          'sm:max-w-3xl', 'sm:max-w-4xl', 'sm:max-w-5xl', 'sm:max-w-6xl',
    |          'sm:max-w-7xl', or 'max-w-full' for full width
    |
    | Default: 'sm:max-w-4xl' (wider than guest layout)
    |
    */
    'help_layout_max_width' => env('FILAMENT_HELP_LAYOUT_MAX_WIDTH', 'sm:max-w-4xl'),
    
    /*
    |--------------------------------------------------------------------------
    | Help Layout Logo URL
    |--------------------------------------------------------------------------
    |
    | The URL to link to when clicking the logo in the help layout.
    |
    | Default: '/' (home page)
    |
    */
    'help_layout_logo_url' => env('FILAMENT_HELP_LAYOUT_LOGO_URL', '/'),
    
    /*
    |--------------------------------------------------------------------------
    | Help Layout CSS Files
    |--------------------------------------------------------------------------
    |
    | CSS files to include in the help layout. This accepts an array of CSS
    | file paths that will be passed to @vite(). You can include your app's
    | main CSS and any panel theme CSS files.
    |
    | Example:
    | 'help_layout_css' => [
    |     'resources/css/app.css',
    |     'resources/css/filament/app/theme.css',
    | ]
    |
    | Default: ['resources/css/app.css'] (uses your app's main CSS)
    |
    */
    'help_layout_css' => [
        'resources/css/app.css',
    ],
    
    /*
    |--------------------------------------------------------------------------
    | Help Layout Theme CSS (Additional)
    |--------------------------------------------------------------------------
    |
    | Additional theme CSS files to include after the main CSS. This is useful
    | for adding Filament panel theme CSS without removing the default app CSS.
    | Set to null or empty array to skip.
    |
    | Example: 'resources/css/filament/app/theme.css'
    |
    | Default: null
    |
    */
    'help_layout_theme_css' => null,
    
    /*
    |--------------------------------------------------------------------------
    | Guest Layout (Deprecated)
    |--------------------------------------------------------------------------
    |
    | @deprecated Use 'help_layout' instead. This is kept for backwards compatibility.
    | The layout to use for public help articles. This should point to your
    | project's guest layout (e.g., the same layout used for login/register).
    | 
    | Default: 'layouts.guest'
    |
    */
    'guest_layout' => env('FILAMENT_HELP_GUEST_LAYOUT', 'layouts.guest'),
    'public_route_prefix' => env('FILAMENT_HELP_PUBLIC_ROUTE_PREFIX', 'help-articles'),
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
    'public_route_middleware' => [\Tapp\FilamentHelp\Http\Middleware\AllowPublicHelpAccess::class],
    
    /*
    |--------------------------------------------------------------------------
    | Admin Check Callback
    |--------------------------------------------------------------------------
    |
    | Define a callback to determine if a user is an admin. This is used
    | to show/hide the "is_hidden" checkbox in the help article form.
    | 
    | Example:
    | 'admin_check' => fn ($user) => $user->hasRole('Admin'),
    |
    */
    'admin_check' => null,
];
