<?php

namespace Tapp\FilamentHelp;

use Filament\Contracts\Plugin;
use Filament\Panel;

class FilamentHelpGuestPlugin implements Plugin
{
    protected ?string $slug = null;

    public static function make(): static
    {
        return app(static::class);
    }

    public function slug(string $slug): static
    {
        $this->slug = $slug;

        return $this;
    }

    public function getId(): string
    {
        return 'filament-help-guest';
    }

    public function register(Panel $panel): void
    {
        // Set the slug on the resource - use provided slug or default to empty string (uses panel path)
        $defaultSlug = ''; // Empty string means use panel path directly
        $slug = $this->slug ?? $defaultSlug;

        \Tapp\FilamentHelp\Resources\Guest\HelpArticleResource::setSlug($slug);

        $panel
            ->resources([
                \Tapp\FilamentHelp\Resources\Guest\HelpArticleResource::class,
            ]);
    }

    public function boot(Panel $panel): void
    {
        //
    }
}
