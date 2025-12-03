<?php

namespace Tapp\FilamentHelp\Resources\Guest\Pages;

use Filament\Resources\Pages\ListRecords;
use Tapp\FilamentHelp\Resources\Guest\HelpArticleResource;

class ListHelpArticles extends ListRecords
{
    protected static string $resource = HelpArticleResource::class;

    protected static ?string $slug = null;

    protected static ?string $title = 'Help';

    public function getHeading(): string
    {
        return 'Help';
    }

    public function getSubheading(): string
    {
        return 'Find answers to common questions and learn how to use our platform.';
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
