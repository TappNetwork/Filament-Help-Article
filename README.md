# Filament plugin for managing help articles

[![Latest Version on Packagist](https://img.shields.io/packagist/v/tapp/filament-help.svg?style=flat-square)](https://packagist.org/packages/tapp/filament-help)
![GitHub Tests Action Status](https://github.com/TappNetwork/filament-help/actions/workflows/run-tests.yml/badge.svg)
![GitHub Code Style Action Status](https://github.com/TappNetwork/filament-help/actions/workflows/fix-php-code-style-issues.yml/badge.svg)
[![Total Downloads](https://img.shields.io/packagist/dt/tapp/filament-help.svg?style=flat-square)](https://packagist.org/packages/tapp/filament-help)

This plugin adds help article management to Filament with admin, frontend, and guest panel capabilities.

## Version Compatibility

 Filament | Filament Help
:---------|:---------------------------
 4.x      | 1.x

## Installation

You can install the package via composer:

```bash
composer require tapp/filament-help
```

You can publish and run the migrations with:

```bash
php artisan vendor:publish --tag="filament-help-migrations"
php artisan migrate
```

You can publish the config file with:

```bash
php artisan vendor:publish --tag="filament-help-config"
```

This is the contents of the published config file:

```php
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
```

## Using the Plugins

### Admin Plugin (for editing help articles)

Add this plugin to your admin panel for full CRUD operations. 
E.g. in `app/Providers/Filament/AdminPanelProvider.php`:

```php
use Tapp\FilamentHelp\FilamentHelpPlugin;
 
public function panel(Panel $panel): Panel
{
    return $panel
        // ...
        ->plugins([
            FilamentHelpPlugin::make(),
            //...
        ]);
}
```

**Location**: Admin panel (typically `/admin/help-articles`)  
**Access**: Authenticated admin users only  
**Features**: Create, edit, delete, and manage all help articles

### Frontend Plugin (for authenticated users)

Add this plugin to your authenticated user panel for read-only access:

```php
use Tapp\FilamentHelp\FilamentHelpFrontendPlugin;
 
public function panel(Panel $panel): Panel
{
    return $panel
        // ...
        ->plugins([
            FilamentHelpFrontendPlugin::make()
                ->slug('app/help'), // Optional: customize the URL slug
            //...
        ]);
}
```

**Configuration Options:**
- **Plugin method**: `->slug('custom-slug')` - Set the URL slug when registering the plugin
- **Config file**: `filament-help.frontend_slug` - Default slug (defaults to `'help'`)
- **Environment variable**: `FILAMENT_HELP_FRONTEND_SLUG` - Override via `.env`

**Location**: App panel (defaults to `/help`, configurable)  
**Access**: Authenticated users only  
**Features**: Read-only access to public help articles

### Guest Plugin (for public access)

Add this plugin to a guest panel (without authentication) for public access:

```php
use Tapp\FilamentHelp\FilamentHelpGuestPlugin;
 
public function panel(Panel $panel): Panel
{
    return $panel
        ->id('guest')
        ->path('help') // Panel path
        // ... other panel configuration
        // Note: Do NOT add authMiddleware() for guest access
        ->plugins([
            FilamentHelpGuestPlugin::make()
                ->slug(''), // Optional: customize the URL slug (empty = use panel path)
            //...
        ]);
}
```

**Configuration Options:**
- **Plugin method**: `->slug('custom-slug')` - Set the URL slug when registering the plugin
- **Config file**: `filament-help.guest_slug` - Default slug (defaults to `''` - empty string)
- **Environment variable**: `FILAMENT_HELP_GUEST_SLUG` - Override via `.env`

**Location**: Guest panel (defaults to panel path, configurable)  
**Access**: Public (no authentication required)  
**Features**: Read-only access to public help articles for guests

**Note**: If you set the guest slug to an empty string (default), the help articles will be available directly at the panel path. For example, if your panel path is `help`, articles will be at `/help` and `/help/{slug}`.

## Help Article Locations

Help articles are available in three different locations depending on your setup:

1. **Admin Panel** (`/admin/help-articles`): For editing and managing help articles
2. **App Panel** (configurable, default `/help`): For authenticated users to view public help articles
3. **Guest Panel** (configurable, default uses panel path): For public/guest users to view public help articles

The frontend and guest panel URLs can be customized using the plugin's `->slug()` method or via configuration (see plugin documentation above).

## Features

- **Admin Panel**: Full CRUD operations for help articles
- **Frontend/Guest**: Read-only access to public help articles
- **Rich Content**: HTML content support with iframe embedding
- **Public/Private**: Control article visibility with `is_public` flag
- **Hidden/Draft**: Hide articles from public view with `is_hidden` flag (useful for drafts or archived articles)
- **Search & Filter**: Find articles by name and filter by public/hidden status

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

-   [Tapp Network](https://github.com/tapp)
-   [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
