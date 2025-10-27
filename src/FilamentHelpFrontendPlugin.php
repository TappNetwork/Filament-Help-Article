<?php

namespace Tapp\FilamentHelp;

use Filament\Contracts\Plugin;
use Filament\Panel;

class FilamentHelpFrontendPlugin implements Plugin
{
    public static function make(): static
    {
        return app(static::class);
    }

    public function getId(): string
    {
        return 'filament-help-frontend';
    }

    public function register(Panel $panel): void
    {
        $panel
            ->resources([
                \Tapp\FilamentHelp\Resources\Frontend\HelpArticleResource::class,
            ]);
    }

    public function boot(Panel $panel): void
    {
        //
    }
}
