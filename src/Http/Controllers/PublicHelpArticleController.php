<?php

namespace Tapp\FilamentHelp\Http\Controllers;

use Filament\Facades\Filament;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Tapp\FilamentHelp\Models\HelpArticle;
use Tapp\FilamentHelp\Resources\Frontend\HelpArticleResource;

class PublicHelpArticleController
{
    /**
     * Find the panel that has the authenticated help resource registered.
     */
    protected function findAuthenticatedPanel(): ?\Filament\Panel
    {
        foreach (Filament::getPanels() as $panel) {
            $resources = $panel->getResources();
            foreach ($resources as $resource) {
                if ($resource === HelpArticleResource::class) {
                    return $panel;
                }
            }
        }

        return null;
    }

    /**
     * Get the URL for the authenticated help resource in the Filament panel.
     */
    protected function getAuthenticatedHelpUrl(string $name, array $parameters = []): ?string
    {
        $panel = $this->findAuthenticatedPanel();
        if (! $panel) {
            return null;
        }

        // Build the route name manually: filament.{panel}.resources.{resource}.{name}
        $panelId = $panel->getId();
        $resourceSlug = HelpArticleResource::getSlug();
        $routeName = "filament.{$panelId}.resources.{$resourceSlug}.{$name}";

        try {
            return route($routeName, $parameters);
        } catch (\Illuminate\Routing\Exceptions\UrlGenerationException $e) {
            return null;
        }
    }

    public function index()
    {
        // If user is authenticated, redirect to the authenticated help index
        if (Auth::check()) {
            $url = $this->getAuthenticatedHelpUrl('index');
            if ($url) {
                return redirect($url);
            }
        }

        $articles = HelpArticle::query()
            ->where('is_public', true)
            ->where('is_hidden', false)
            ->orderBy('name')
            ->paginate(8);

        // Allow projects to publish and customize the view
        // Check for published view first, then use package default
        return View::first([
            'filament-help.public.index', // Published view
            'filament-help::public.index', // Package view
        ], [
            'articles' => $articles,
        ]);
    }

    public function show(string $slug)
    {
        $article = HelpArticle::where('slug', $slug)
            ->where('is_public', true)
            ->where('is_hidden', false) // Hidden articles are not accessible via public route
            ->firstOrFail();

        // If user is authenticated, redirect to the authenticated help page
        if (Auth::check()) {
            $url = $this->getAuthenticatedHelpUrl('view', ['record' => $article->slug]);
            if ($url) {
                return redirect($url);
            }
        }

        // Allow projects to publish and customize the view
        // Check for published view first, then use package default
        return View::first([
            'filament-help.public.show', // Published view
            'filament-help::public.show', // Package view
        ], [
            'article' => $article,
        ]);
    }
}

