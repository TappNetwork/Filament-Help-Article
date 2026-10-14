<?php

namespace Tapp\FilamentHelp\Resources\HelpArticleResource\Pages;

use Filament\Actions;
use Filament\Actions\Action;
use Filament\Facades\Filament;
use Filament\Resources\Pages\ViewRecord;
use Tapp\FilamentHelp\Models\HelpArticle;
use Tapp\FilamentHelp\Resources\Frontend\HelpArticleResource as FrontendHelpArticleResource;
use Tapp\FilamentHelp\Resources\Guest\HelpArticleResource as GuestHelpArticleResource;
use Tapp\FilamentHelp\Resources\HelpArticleResource;

class ViewHelpArticle extends ViewRecord
{
    protected static string $resource = HelpArticleResource::class;

    protected string $view = 'filament-help::filament.resources.help-article-resource.pages.view-help-article';

    public function getTitle(): string
    {
        return $this->record->name;
    }

    public function getHeading(): string
    {
        return $this->record->name;
    }

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
        /** @var HelpArticle $record */
        $record = $this->record;

        if ($record->is_public) {
            $guestPanelId = $this->panelIdForResource(GuestHelpArticleResource::class);

            if (filled($guestPanelId)) {
                return GuestHelpArticleResource::getUrl('view', ['record' => $record->slug], panel: $guestPanelId);
            }
        }

        return FrontendHelpArticleResource::getUrl(
            'view',
            ['record' => $record->slug],
            panel: $this->panelIdForResource(FrontendHelpArticleResource::class),
        );
    }

    /**
     * @param  class-string  $resource
     */
    protected function panelIdForResource(string $resource): ?string
    {
        foreach (Filament::getPanels() as $panel) {
            if (in_array($resource, $panel->getResources(), true)) {
                return $panel->getId();
            }
        }

        return null;
    }
}
