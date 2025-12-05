<?php

namespace Tapp\FilamentHelp;

use Filament\Contracts\Plugin;
use Filament\Panel;

class FilamentHelpFrontendPlugin implements Plugin
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
        return 'filament-help-frontend';
    }

    public function register(Panel $panel): void
    {
        // Set the slug on the resource - use provided slug or default to 'help-articles'
        $defaultSlug = 'help-articles';
        $slug = $this->slug ?? $defaultSlug;

        if (empty($slug)) {
            throw new \InvalidArgumentException('Slug cannot be empty. Please provide a non-empty slug when registering the plugin.');
        }

        \Tapp\FilamentHelp\Resources\Frontend\HelpArticleResource::setSlug($slug);

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
