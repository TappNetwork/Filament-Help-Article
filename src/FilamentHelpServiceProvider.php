<?php

namespace Tapp\FilamentHelp;

use Spatie\LaravelPackageTools\Commands\InstallCommand;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class FilamentHelpServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package
            ->name('filament-help')
            ->hasViews()
            ->hasConfigFile('filament-help')
            ->hasMigrations([
                'create_help_articles_table',
                'add_is_hidden_to_help_articles_table',
            ])
            ->hasInstallCommand(function (InstallCommand $command) {
                $command
                    ->publishMigrations()
                    ->askToRunMigrations();
            });
    }

    public function boot(): void
    {
        parent::boot();

        $this->publishes([
            __DIR__.'/../../resources/views' => resource_path('views/vendor/filament-help'),
        ], 'filament-help-views');

        $this->publishes([
            __DIR__.'/../resources/css/help.css' => public_path('vendor/filament-help/help.css'),
        ], 'filament-help-assets');
    }
}
