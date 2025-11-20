<?php

namespace Tapp\FilamentHelp;

use Illuminate\Support\Facades\Route;
use Spatie\LaravelPackageTools\Commands\InstallCommand;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use Tapp\FilamentHelp\Http\Controllers\PublicHelpArticleController;

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

    public function register(): void
    {
        parent::register();
        
        // Register public routes early to ensure they take priority over Filament panel routes
        $this->booting(function () {
            $this->registerPublicRoutes();
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

        // Register the HelpLayout component so it can be used as <x-help-layout>
        /** @phpstan-ignore-next-line */
        $this->loadViewComponentsAs('', [
            \Tapp\FilamentHelp\View\Components\HelpLayout::class => 'help-layout',
        ]);
    }

    protected function registerPublicRoutes(): void
    {
        Route::middleware(['web'])
            ->prefix(config('filament-help.route_prefix', 'help-articles'))
            ->group(function () {
                /** @phpstan-ignore-next-line */
                Route::get('/', [PublicHelpArticleController::class, 'index'])
                    ->name('filament-help.public.index');
                /** @phpstan-ignore-next-line */
                Route::get('/{slug}', [PublicHelpArticleController::class, 'show'])
                    ->name('filament-help.public.show');
            });
    }
}
