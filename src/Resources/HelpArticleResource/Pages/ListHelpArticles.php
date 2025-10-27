<?php

namespace Tapp\FilamentHelp\Resources\HelpArticleResource\Pages;

use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Tapp\FilamentHelp\Resources\HelpArticleResource;

class ListHelpArticles extends ListRecords
{
    protected static string $resource = HelpArticleResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
