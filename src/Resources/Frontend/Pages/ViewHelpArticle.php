<?php

namespace Tapp\FilamentHelp\Resources\Frontend\Pages;

use Filament\Resources\Pages\ViewRecord;
use Tapp\FilamentHelp\Resources\Frontend\HelpArticleResource;

class ViewHelpArticle extends ViewRecord
{
    protected static string $resource = HelpArticleResource::class;

    protected static ?string $slug = 'help/{record:slug}';

    protected string $view = 'filament-help::resources.frontend.help-article-resource.pages.view-help-article';

    public function mount(int | string $record): void
    {
        $this->record = $this->resolveRecord($record);
        
        // Ensure the article is public
        if (! $this->record->is_public) {
            abort(404);
        }
    }

    public function getTitle(): string
    {
        return $this->record->name;
    }

    public function getHeading(): string
    {
        return $this->record->name;
    }

    public function getSubheading(): string
    {
        return 'Last updated ' . $this->record->updated_at->format('M j, Y');
    }

    public function getBreadcrumbs(): array
    {
        return [];
    }

    public function getBreadcrumbsTitle(): string
    {
        return '';
    }
}
