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
        // Set the slug on the resource - use provided slug or default to 'help'
        $defaultSlug = 'help';
        $slug = $this->slug ?? $defaultSlug;

        // Allow empty slug only if explicitly passed (to use panel path directly)
        // But default must always be non-empty
        if ($slug === $defaultSlug && empty($slug)) {
            throw new \InvalidArgumentException('Default slug cannot be empty. Please provide a non-empty slug when registering the plugin.');
        }

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
