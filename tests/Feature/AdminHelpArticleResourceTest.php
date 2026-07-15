<?php

use Filament\Forms\Components\RichEditor;
use Filament\Schemas\Schema;
use Tapp\FilamentHelp\Models\HelpArticle;
use Tapp\FilamentHelp\Resources\HelpArticleResource;

it('can create help article through factory', function () {
    $helpArticle = HelpArticle::factory()->create([
        'name' => 'Test Article',
        'is_public' => true,
        'content' => 'Test content',
    ]);

    expect($helpArticle->name)->toBe('Test Article');
    expect($helpArticle->is_public)->toBeTrue();
    expect($helpArticle->content)->toBe('Test content');
    expect($helpArticle->slug)->not->toBeNull();
});

it('can update help article', function () {
    $helpArticle = HelpArticle::factory()->create(['name' => 'Original Name']);

    $helpArticle->update(['name' => 'Updated Name', 'is_public' => true]);

    expect($helpArticle->fresh()->name)->toBe('Updated Name');
    expect($helpArticle->fresh()->is_public)->toBeTrue();
});

it('can delete help article', function () {
    $helpArticle = HelpArticle::factory()->create();
    $id = $helpArticle->id;

    $helpArticle->delete();

    expect(HelpArticle::find($id))->toBeNull();
});

it('can filter help articles by public status', function () {
    HelpArticle::factory()->public()->count(2)->create();
    HelpArticle::factory()->private()->count(3)->create();

    expect(HelpArticle::public()->count())->toBe(2);
    expect(HelpArticle::where('is_public', false)->count())->toBe(3);
});

it('shows the article name as the view page title', function () {
    $helpArticle = HelpArticle::factory()->create([
        'name' => 'Adding an Evaluation Course',
    ]);

    $page = new \Tapp\FilamentHelp\Resources\HelpArticleResource\Pages\ViewHelpArticle;
    $page->record = $helpArticle;

    expect($page->getTitle())->toBe('Adding an Evaluation Course');
    expect($page->getHeading())->toBe('Adding an Evaluation Course');
});

it('enables image uploads on the content rich editor', function () {
    expect(config('filament-help.editor.file_attachments.directory'))->toBe('help-articles');
    expect(config('filament-help.editor.file_attachments.visibility'))->toBe('public');

    $schema = HelpArticleResource::form(Schema::make());

    $components = (new ReflectionProperty($schema, 'components'))->getValue($schema);

    $contentField = collect($components)
        ->first(fn ($component) => $component instanceof RichEditor && $component->getName() === 'content');

    expect($contentField)->not->toBeNull();

    $toolbarButtons = (new ReflectionProperty($contentField, 'toolbarButtons'))->getValue($contentField);
    $fileAttachmentsDirectory = (new ReflectionProperty($contentField, 'fileAttachmentsDirectory'))->getValue($contentField);
    $fileAttachmentsVisibility = (new ReflectionProperty($contentField, 'fileAttachmentsVisibility'))->getValue($contentField);
    $hasResizableImages = (new ReflectionProperty($contentField, 'hasResizableImages'))->getValue($contentField);
    $toolbarModifications = (new ReflectionProperty($contentField, 'toolbarButtonsModifications'))->getValue($contentField);
    $shouldPreventTampering = (new ReflectionProperty($contentField, 'shouldPreventFileAttachmentPathTampering'))->getValue($contentField);

    expect($toolbarButtons)->toContain('attachFiles');
    expect($fileAttachmentsDirectory)->toBe('help-articles');
    expect($fileAttachmentsVisibility)->toBe('public');
    expect($hasResizableImages)->toBeTrue();
    expect($shouldPreventTampering)->toBeTrue();
    expect($toolbarModifications)->not->toContain(['type' => 'disable', 'buttons' => ['attachFiles']]);
});
