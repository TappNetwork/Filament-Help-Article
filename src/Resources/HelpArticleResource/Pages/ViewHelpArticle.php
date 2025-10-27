<?php

namespace Tapp\FilamentHelp\Resources\HelpArticleResource\Pages;

use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;
use Tapp\FilamentHelp\Resources\HelpArticleResource;

class ViewHelpArticle extends ViewRecord
{
    protected static string $resource = HelpArticleResource::class;

    protected string $view = 'filament-help::filament.resources.help-article-resource.pages.view-help-article';

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
