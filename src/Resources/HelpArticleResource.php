<?php

namespace Tapp\FilamentHelp\Resources;

use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteBulkAction;
use Tapp\FilamentHelp\Models\HelpArticle;
use Tapp\FilamentHelp\Resources\HelpArticleResource\Pages;

class HelpArticleResource extends Resource
{
    protected static ?string $model = HelpArticle::class;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-question-mark-circle';

    public static string|\UnitEnum|null $navigationGroup = 'System';

    public static function shouldRegisterNavigation(): bool
    {
        return true;
    }

    public static function getNavigationLabel(): string
    {
        return 'Help Articles';
    }

    public static function getPluralLabel(): string
    {
        return 'Help Articles';
    }

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('slug')
                    ->label('URL Slug')
                    ->helperText('Leave empty to auto-generate from name')
                    ->maxLength(255),
                Forms\Components\Toggle::make('is_public')
                    ->label('Public')
                    ->default(false)
                    ->helperText('Public articles will be displayed on the frontend.'),
                    Forms\Components\Textarea::make('embed')
                        ->label('Embed (HTML)')
                        ->rows(4)
                        ->helperText('Some embed tags contain style rules that may need to be removed or edited to render properly.')
                        ->columnSpanFull(),
                Forms\Components\RichEditor::make('content')
                    ->label('Content')
                    ->toolbarButtons([
                        'bold',
                        'italic',
                        'underline',
                        'strike',
                        'link',
                        'bulletList',
                        'orderedList',
                        'h2',
                        'h3',
                        'blockquote',
                        'codeBlock',
                    ])
                    ->columnSpanFull()
                    ->disableToolbarButtons([
                        'attachFiles',
                    ])
                    ->extraInputAttributes([
                        'style' => 'min-height: 200px;'
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\IconColumn::make('is_public')
                    ->label('Public')
                    ->boolean(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\TernaryFilter::make('is_public')
                    ->label('Public')
                    ->boolean()
                    ->trueLabel('Public only')
                    ->falseLabel('Private only')
                    ->native(false),
            ])
            ->actions([])
            ->bulkActions([]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListHelpArticles::route('/'),
            'create' => Pages\CreateHelpArticle::route('/create'),
            'view' => Pages\ViewHelpArticle::route('/{record}'),
            'edit' => Pages\EditHelpArticle::route('/{record}/edit'),
        ];
    }
}
