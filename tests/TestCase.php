<?php

namespace Tapp\FilamentHelp\Tests;

use Filament\Actions\ActionsServiceProvider;
use Filament\Facades\Filament;
use Filament\FilamentServiceProvider;
use Filament\Panel;
use Filament\Support\SupportServiceProvider;
use Illuminate\Database\Eloquent\Factories\Factory;
use Livewire\LivewireServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;
use Tapp\FilamentHelp\FilamentHelpServiceProvider;
use Tapp\FilamentHelp\Resources\HelpArticleResource;

class TestCase extends Orchestra
{
    protected function setUp(): void
    {
        parent::setUp();

        Factory::guessFactoryNamesUsing(
            fn (string $modelName) => 'Tapp\\FilamentHelp\\Database\\Factories\\'.class_basename($modelName).'Factory'
        );
    }

    protected function getPackageProviders($app)
    {
        return [
            LivewireServiceProvider::class,
            FilamentServiceProvider::class,
            ActionsServiceProvider::class,
            SupportServiceProvider::class,
            FilamentHelpServiceProvider::class,
        ];
    }

    public function getEnvironmentSetUp($app)
    {
        config()->set('database.default', 'testing');
        config()->set('app.key', 'base64:'.base64_encode(random_bytes(32)));

        $migration = include __DIR__.'/../database/migrations/create_help_articles_table.php.stub';
        $migration->up();

        $addIsHiddenMigration = include __DIR__.'/../database/migrations/add_is_hidden_to_help_articles_table.php.stub';
        $addIsHiddenMigration->up();

        // Match an app that puts the signed-in help page on `help` and the guest page on `help-articles`.
        \Tapp\FilamentHelp\Resources\Frontend\HelpArticleResource::setSlug('help');
        \Tapp\FilamentHelp\Resources\Guest\HelpArticleResource::setSlug('help-articles');

        // Set up a basic Filament panel for testing (admin)
        Filament::registerPanel(
            Panel::make()
                ->id('admin')
                ->resources([
                    HelpArticleResource::class,
                ])
        );

        // Register the frontend panel for testing (app)
        Filament::registerPanel(
            Panel::make()
                ->id('app')
                ->default() // Make 'app' the default panel for frontend tests
                ->resources([
                    \Tapp\FilamentHelp\Resources\Frontend\HelpArticleResource::class,
                ])
        );

        Filament::registerPanel(
            Panel::make()
                ->id('guest')
                ->resources([
                    \Tapp\FilamentHelp\Resources\Guest\HelpArticleResource::class,
                ])
        );
    }
}
