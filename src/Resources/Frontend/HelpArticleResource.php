<?php

namespace Tapp\FilamentHelp\Resources\Frontend;

use Filament\Actions\ViewAction;
use Filament\Facades\Filament;
use Filament\Resources\Resource;
use Filament\Support\Enums\Alignment;
use Filament\Tables\Columns\Layout\Stack;
use Filament\Tables\Table;
use Tapp\FilamentHelp\Resources\Frontend\Pages\ListHelpArticles;
use Tapp\FilamentHelp\Resources\Frontend\Pages\ViewHelpArticle;
use Tapp\FilamentHelp\Tables\Components\HelpArticleCardColumn;

class HelpArticleResource extends Resource
{
    protected static ?string $model = null;

    public static function getModel(): string
    {
        return static::$model ?? config('filament-help.model', \Tapp\FilamentHelp\Models\HelpArticle::class);
    }

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-question-mark-circle';

    protected static ?string $navigationLabel = 'Help';

    public static function shouldRegisterNavigation(): bool
    {
        if (! config('filament-help.frontend.resource.should_register_navigation', true)) {
            return false;
        }

        $panel = Filament::getCurrentPanel();

        return $panel && $panel->getId() === 'app';
    }

    protected static ?string $modelLabel = 'Help Article';

    protected static ?string $slug = 'help-articles';

    public static function setSlug(string $slug): void
    {
        if (empty($slug)) {
            throw new \InvalidArgumentException('Slug cannot be empty.');
        }

        static::$slug = $slug;
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Stack::make([
                    HelpArticleCardColumn::make('name'),
                ])->alignment(Alignment::End)
                    ->space(1),
            ])
            ->filters([
                //
            ])
            ->contentGrid([
                'md' => 2,
                'lg' => 3,
            ])
            ->defaultPaginationPageOption(9)
            ->paginationPageOptions([9])
            ->recordActions([
                ViewAction::make()
                    ->color('primary')
                    ->label('Read Article'),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListHelpArticles::route('/'),
            'view' => ViewHelpArticle::route('/{record:slug}'),
        ];
    }

    public static function canCreate(): bool
    {
        return false;
    }

    public static function canEdit($record): bool
    {
        return false;
    }

    public static function canDelete($record): bool
    {
        return false;
    }

    public static function getEloquentQuery(): \Illuminate\Database\Eloquent\Builder
    {
        $query = parent::getEloquentQuery()
            ->public()
            ->visible();

        // Apply tenant scoping if enabled
        if (config('filament-help.tenancy.enabled', false) && config('filament-help.tenancy.scoping.frontend', true)) {
            $tenant = Filament::getTenant();
            if ($tenant) {
                $tenantColumn = config('filament-help.tenancy.column') ?? 'team_id';
                $query->where($tenantColumn, $tenant->id);
            }
        }

        return $query;
    }
}
