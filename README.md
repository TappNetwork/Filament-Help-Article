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
            FilamentHelpFrontendPlugin::make(),
            // Default slug is 'help-articles', so articles will be at {panel-path}/help-articles
            // Customize with ->slug('custom-slug') if needed
        ]);
}
```

**Configuration Options:**
- **Plugin method**: `->slug('custom-slug')` - Set the URL slug when registering the plugin (defaults to `'help-articles'` if not specified)

**Location**: App panel (defaults to `{panel-path}/help-articles`, configurable via `->slug()`)  
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
        ->path('') // Panel path (empty = root, or set to your desired base path)
        // ... other panel configuration
        // Note: Do NOT add authMiddleware() for guest access
        ->plugins([
            FilamentHelpGuestPlugin::make(),
            // Default slug is 'help', so articles will be at /help (or {panel-path}/help)
            // Customize with ->slug('custom-slug') if needed
        ]);
}
```

**Configuration Options:**
- **Plugin method**: `->slug('custom-slug')` - Set the URL slug when registering the plugin (defaults to `'help'` if not specified)
- **Slug requirement**: Slug must be a non-empty string

**Location**: Guest panel (defaults to `{panel-path}/help`, configurable via `->slug()`)  
**Access**: Public (no authentication required)  
**Features**: Read-only access to public help articles for guests

## Help Article Locations

Help articles are available in three different locations depending on your setup:

1. **Admin Panel** (`/admin/help-articles`): For editing and managing help articles
2. **App Panel** (configurable, default `{panel-path}/help-articles`): For authenticated users to view public help articles
3. **Guest Panel** (configurable, default `{panel-path}/help`): For public/guest users to view public help articles

The frontend and guest panel URLs can be customized using the plugin's `->slug()` method when registering the plugin (see plugin documentation above).

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
