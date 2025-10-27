<?php

namespace Tapp\FilamentHelp;

use Filament\Contracts\Plugin;
use Filament\Panel;

class FilamentHelpPlugin implements Plugin
{
    public static function make(): static
    {
        return app(static::class);
    }

    public function getId(): string
    {
        return 'filament-help';
    }

    public function register(Panel $panel): void
    {
        $panel
            ->resources([
                \Tapp\FilamentHelp\Resources\HelpArticleResource::class,
            ]);
    }

    public function boot(Panel $panel): void
    {
        //
    }
}
