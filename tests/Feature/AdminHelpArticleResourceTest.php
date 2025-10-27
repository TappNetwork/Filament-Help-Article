<?php

use Livewire\Livewire;
use Tapp\FilamentHelp\Models\HelpArticle;
use Tapp\FilamentHelp\Resources\HelpArticleResource\Pages\ListHelpArticles;
use Tapp\FilamentHelp\Resources\HelpArticleResource\Pages\CreateHelpArticle;
use Tapp\FilamentHelp\Resources\HelpArticleResource\Pages\ViewHelpArticle;
use Tapp\FilamentHelp\Resources\HelpArticleResource\Pages\EditHelpArticle;

it('can render the list help articles page without errors', function () {
    Livewire::test(ListHelpArticles::class)
        ->assertSuccessful();
});

it('can render the create help article page without errors', function () {
    Livewire::test(CreateHelpArticle::class)
        ->assertSuccessful();
});

it('can render the view help article page without errors', function () {
    $helpArticle = HelpArticle::factory()->create();
    Livewire::test(ViewHelpArticle::class, ['record' => $helpArticle->getKey()])
        ->assertSuccessful();
});

it('can render the edit help article page without errors', function () {
    $helpArticle = HelpArticle::factory()->create();
    Livewire::test(EditHelpArticle::class, ['record' => $helpArticle->getKey()])
        ->assertSuccessful();
});