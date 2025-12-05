<?php

namespace Tapp\FilamentHelp\Resources\HelpArticleResource\Pages;

use Filament\Actions;
use Filament\Actions\Action;
use Filament\Facades\Filament;
use Filament\Resources\Pages\ViewRecord;
use Tapp\FilamentHelp\Resources\Frontend\HelpArticleResource as FrontendHelpArticleResource;
use Tapp\FilamentHelp\Resources\Guest\HelpArticleResource as GuestHelpArticleResource;
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

                    $this->js('
                        navigator.clipboard.writeText('.json_encode($url).").then(() => {
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
            // Public link for unauthenticated users (guest panel)
            $guestPanel = Filament::getPanel('guest');
            if ($guestPanel) {
                // Temporarily set the current panel to generate the correct URL
                $originalPanel = Filament::getCurrentPanel();
                Filament::setCurrentPanel($guestPanel);
                $url = GuestHelpArticleResource::getUrl('view', ['record' => $record->slug]);
                Filament::setCurrentPanel($originalPanel);

                return $url;
            }
        }

        // Authenticated frontend link (not admin)
        return FrontendHelpArticleResource::getUrl('view', ['record' => $record->slug]);
    }
}
