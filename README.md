# Filament plugin for managing help articles

[![Latest Version on Packagist](https://img.shields.io/packagist/v/tapp/filament-help.svg?style=flat-square)](https://packagist.org/packages/tapp/filament-help)
![GitHub Tests Action Status](https://github.com/TappNetwork/filament-help/actions/workflows/run-tests.yml/badge.svg)
![GitHub Code Style Action Status](https://github.com/TappNetwork/filament-help/actions/workflows/fix-php-code-style-issues.yml/badge.svg)
[![Total Downloads](https://img.shields.io/packagist/dt/tapp/filament-help.svg?style=flat-square)](https://packagist.org/packages/tapp/filament-help)

This plugin adds help article management to Filament with both admin and frontend capabilities.

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
];
```

## Using the Plugins

### Admin Plugin

Add this plugin to a panel on `plugins()` method. 
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

### Frontend Plugin

Add this plugin to a panel for frontend access:

```php
use Tapp\FilamentHelp\FilamentHelpFrontendPlugin;
 
public function panel(Panel $panel): Panel
{
    return $panel
        // ...
        ->plugins([
            FilamentHelpFrontendPlugin::make(),
            //...
        ]);
}
```

## Features

- **Admin Panel**: Full CRUD operations for help articles
- **Frontend**: Read-only access to public help articles
- **Rich Content**: HTML content support with iframe embedding
- **Public/Private**: Control article visibility
- **Search & Filter**: Find articles by name and filter by public status

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
