<?php

namespace Tapp\FilamentHelp\Tests;

use Illuminate\Database\Eloquent\Factories\Factory;
use Orchestra\Testbench\TestCase as Orchestra;
use Tapp\FilamentHelp\FilamentHelpServiceProvider;

class PublicTestCase extends Orchestra
{
    protected function setUp(): void
    {
        parent::setUp();

        Factory::guessFactoryNamesUsing(
            fn (string $modelName) => 'Tapp\\FilamentHelp\\Database\\Factories\\'.class_basename($modelName).'Factory'
        );

        // Register test views for components
        $this->app['view']->addLocation(__DIR__.'/views');
        
        // Mock Vite to return empty strings for CSS/JS in tests
        $this->app->bind('Illuminate\Foundation\Vite', function () {
            return new class {
                public function __invoke($paths, $buildDirectory = null) {
                    return ''; // Return empty string for all Vite assets
                }
                
                public function __call($method, $parameters) {
                    return '';
                }
            };
        });
    }

    protected function getPackageProviders($app)
    {
        return [
            FilamentHelpServiceProvider::class,
        ];
    }

    public function getEnvironmentSetUp($app)
    {
        config()->set('database.default', 'testing');
        config()->set('app.key', 'base64:'.base64_encode(random_bytes(32)));
        
        // Configure Vite for testing - create stub manifest
        config()->set('app.asset_url', '');
        config()->set('filament-help.css', ['']);  // Empty CSS for tests
        
        // Create stub build directory and manifest for testing
        $buildPath = base_path('public/build');
        if (!file_exists($buildPath)) {
            mkdir($buildPath, 0755, true);
        }
        
        // Create stub CSS file
        file_put_contents($buildPath.'/app.css', '/* Test CSS */');
        
        // Create manifest with stub CSS entry
        file_put_contents($buildPath.'/manifest.json', json_encode([
            'resources/css/app.css' => [
                'file' => 'app.css',
                'src' => 'resources/css/app.css',
            ],
        ]));

        $migration = include __DIR__.'/../database/migrations/create_help_articles_table.php.stub';
        $migration->up();
        
        $addIsHiddenMigration = include __DIR__.'/../database/migrations/add_is_hidden_to_help_articles_table.php.stub';
        $addIsHiddenMigration->up();

        // Do NOT register Filament panels for public route tests
        // This ensures public routes are not overridden by panel routes
    }
}

