<?php

namespace Tapp\FilamentHelp\Resources\Frontend;

use Filament\Actions\ViewAction;
use Filament\Resources\Resource;
use Filament\Support\Enums\Alignment;
use Filament\Tables\Columns\Layout\Stack;
use Filament\Tables\Table;
use Tapp\FilamentHelp\Models\HelpArticle;
use Tapp\FilamentHelp\Resources\Frontend\Pages\ListHelpArticles;
use Tapp\FilamentHelp\Resources\Frontend\Pages\ViewHelpArticle;
use Tapp\FilamentHelp\Tables\Components\HelpArticleCardColumn;

class HelpArticleResource extends Resource
{
    protected static ?string $model = HelpArticle::class;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-question-mark-circle';

    protected static ?string $navigationLabel = 'Help';

    public static function shouldRegisterNavigation(): bool
    {
        return true;
    }

    protected static ?string $modelLabel = 'Help Article';

    protected static ?string $slug = 'help';

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
        return parent::getEloquentQuery()->public();
    }
}
