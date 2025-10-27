<?php

namespace Tapp\FilamentHelp\Resources\HelpArticleResource\Pages;

use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Tapp\FilamentHelp\Resources\HelpArticleResource;

class EditHelpArticle extends EditRecord
{
    protected static string $resource = HelpArticleResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
