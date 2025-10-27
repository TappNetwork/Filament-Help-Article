<?php

namespace Tapp\FilamentHelp\Tests;

use Filament\FilamentServiceProvider;
use Illuminate\Database\Eloquent\Factories\Factory;
use Livewire\LivewireServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;
use Tapp\FilamentHelp\FilamentHelpServiceProvider;

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
            \Filament\Actions\ActionsServiceProvider::class,
            \Filament\Support\SupportServiceProvider::class,
            \Filament\Forms\FormsServiceProvider::class,
            \Filament\Tables\TablesServiceProvider::class,
            \Filament\Notifications\NotificationsServiceProvider::class,
            \Filament\Infolists\InfolistsServiceProvider::class,
            \Filament\Widgets\WidgetsServiceProvider::class,
            FilamentHelpServiceProvider::class,
        ];
    }

    public function getEnvironmentSetUp($app)
    {
        config()->set('database.default', 'testing');
        config()->set('app.key', 'base64:'.base64_encode(random_bytes(32)));

        $migration = include __DIR__.'/../database/migrations/create_help_articles_table.php.stub';
        $migration->up();

        // Set up a basic Filament panel for testing (admin)
        \Filament\Facades\Filament::registerPanel(
            \Filament\Panel::make()
                ->id('admin')
                ->resources([
                    \Tapp\FilamentHelp\Resources\HelpArticleResource::class,
                ])
        );

        // Register the frontend panel for testing (app)
        \Filament\Facades\Filament::registerPanel(
            \Filament\Panel::make()
                ->id('app')
                ->default() // Make 'app' the default panel for frontend tests
                ->resources([
                    \Tapp\FilamentHelp\Resources\Frontend\HelpArticleResource::class,
                ])
        );
    }
}
