<?php

namespace Tapp\FilamentHelp\Resources\HelpArticleResource\Pages;

use Filament\Actions;
use Filament\Actions\Action;
use Filament\Resources\Pages\ViewRecord;
use Tapp\FilamentHelp\Resources\Frontend\HelpArticleResource as FrontendHelpArticleResource;
use Tapp\FilamentHelp\Resources\HelpArticleResource;

class ViewHelpArticle extends ViewRecord
{
    protected static string $resource = HelpArticleResource::class;

    protected string $view = 'filament-help::filament.resources.help-article-resource.pages.view-help-article';

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
            Action::make('share')
                ->label('Share')
                ->icon('heroicon-o-share')
                ->visible(fn () => ! $this->record->is_hidden)
                ->action(function () {
                    $url = $this->getShareUrl();
                    
                    $this->js("
                        navigator.clipboard.writeText(".json_encode($url).").then(() => {
                            \$tooltip('Copied to clipboard', { timeout: 2000 });
                        });
                    ");
                })
                ->tooltip('Copy link to clipboard'),
        ];
    }

    protected function getShareUrl(): string
    {
        /** @var \Tapp\FilamentHelp\Models\HelpArticle $record */
        $record = $this->record;

        if ($record->is_public) {
            // Public link for unauthenticated users
            return route('filament-help.public.show', $record->slug);
        }

        // Authenticated frontend link (not admin)
        return FrontendHelpArticleResource::getUrl('view', ['record' => $record->slug]);
    }
}
