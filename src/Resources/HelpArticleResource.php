<?php

namespace Tapp\FilamentHelp\Resources;

use Filament\Actions\ActionGroup;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Facades\Filament;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Enums\RecordActionsPosition;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;
use Tapp\FilamentHelp\Models\HelpArticle;
use Tapp\FilamentHelp\Resources\HelpArticleResource\Pages;
use Tapp\FilamentHelp\Support\Tenancy;

class HelpArticleResource extends Resource
{
    protected static ?string $model = null;

    public static function getModel(): string
    {
        return static::$model ?? config('filament-help.model', HelpArticle::class);
    }

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-question-mark-circle';

    public static function getTenantOwnershipRelationshipName(): string
    {
        if (Tenancy::isEnabled()) {
            return config('filament-help.tenancy.relationship') ?? 'team';
        }

        return parent::getTenantOwnershipRelationshipName();
    }

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
                    ->maxLength(255)
                    ->live(onBlur: true)
                    ->afterStateUpdated(function (Set $set, ?string $state, Get $get) {
                        // Only auto-generate slug if it's empty (user hasn't manually set it)
                        if (empty($get('slug'))) {
                            $set('slug', Str::slug($state ?? ''));
                        }
                    }),
                Forms\Components\TextInput::make('slug')
                    ->label('URL Slug')
                    ->helperText('Leave empty to auto-generate from name')
                    ->maxLength(255),
                Forms\Components\Checkbox::make('is_public')
                    ->label('Allow public access (unauthenticated users can view)')
                    ->helperText('When enabled, this article can be accessed via a public URL by anyone, including users who are not logged in.')
                    ->default(false),
                Forms\Components\Checkbox::make('is_hidden')
                    ->label('Hidden (Draft/Archived)')
                    ->helperText('When enabled, this article will be hidden from everyone except admins. Hidden articles are not accessible via public URL, even if public access is enabled. Use this for draft or archived articles.')
                    ->default(false),
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
                        'attachFiles',
                    ])
                    ->fileAttachmentsDisk(config('filament-help.editor.file_attachments.disk'))
                    ->fileAttachmentsDirectory(config('filament-help.editor.file_attachments.directory', 'help-articles'))
                    ->fileAttachmentsVisibility(config('filament-help.editor.file_attachments.visibility', 'public'))
                    ->resizableImages()
                    ->preventFileAttachmentPathTampering()
                    ->columnSpanFull()
                    ->extraInputAttributes([
                        'style' => 'min-height: 200px;',
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
                Tables\Columns\IconColumn::make('is_hidden')
                    ->label('Hidden')
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
                Tables\Filters\TernaryFilter::make('is_hidden')
                    ->label('Hidden')
                    ->boolean()
                    ->trueLabel('Hidden only')
                    ->falseLabel('Visible only')
                    ->native(false),
            ])
            ->recordActions([
                ActionGroup::make([
                    ViewAction::make(),
                    EditAction::make(),
                ]),
            ], position: RecordActionsPosition::BeforeColumns)
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

    public static function getEloquentQuery(): Builder
    {
        $query = parent::getEloquentQuery();

        // Apply tenant scoping if tenancy is enabled
        if (Tenancy::hasTenantColumn(static::getModel()) && config('filament-help.tenancy.scoping.admin', true)) {
            $tenant = Filament::getTenant();
            if ($tenant) {
                $query->where(Tenancy::column(), $tenant->id);
            }
        }

        return $query;
    }
}
