<?php

use Filament\Facades\Filament;
use Illuminate\Support\Facades\Route;
use Tapp\FilamentHelp\Models\HelpArticle;
use Tapp\FilamentHelp\Resources\Frontend\HelpArticleResource as FrontendHelpArticleResource;
use Tapp\FilamentHelp\Resources\Frontend\Pages\ViewHelpArticle as FrontendViewHelpArticle;
use Tapp\FilamentHelp\Resources\Guest\HelpArticleResource as GuestHelpArticleResource;
use Tapp\FilamentHelp\Resources\HelpArticleResource\Pages\ViewHelpArticle;

beforeEach(function () {
    Filament::setCurrentPanel(Filament::getPanel('admin'));
});

it('shares a private article on the signed-in panel while admin is current', function () {
    $article = HelpArticle::factory()->private()->create([
        'name' => 'Private policies',
        'slug' => 'private-policies',
    ]);

    expect(Route::has('filament.admin.resources.help.view'))->toBeFalse();
    expect(shareUrl($article))->toBe(route('filament.app.resources.help.view', ['record' => 'private-policies']));
});

it('shares a public article on the guest panel while admin is current', function () {
    $article = HelpArticle::factory()->public()->create([
        'name' => 'Public guide',
        'slug' => 'public-guide',
    ]);

    expect(shareUrl($article))->toBe(route('filament.guest.resources.help-articles.view', ['record' => 'public-guide']));
});

it('lists private articles for the signed-in help page and hides drafts', function () {
    HelpArticle::factory()->private()->create(['slug' => 'private-policies']);
    HelpArticle::factory()->public()->create(['slug' => 'public-guide']);
    HelpArticle::factory()->private()->hidden()->create(['slug' => 'draft-article']);

    Filament::setCurrentPanel(Filament::getPanel('app'));

    $slugs = FrontendHelpArticleResource::getEloquentQuery()->pluck('slug');

    expect($slugs->all())->toContain('private-policies', 'public-guide')
        ->not->toContain('draft-article');
});

it('opens a private article on the signed-in help page', function () {
    $article = HelpArticle::factory()->private()->create([
        'name' => 'Private policies',
        'slug' => 'private-policies',
    ]);

    Filament::setCurrentPanel(Filament::getPanel('app'));

    $page = new FrontendViewHelpArticle;
    $page->mount($article->slug);

    expect($page->getRecord()->is($article))->toBeTrue()
        ->and($page->getTitle())->toBe('Private policies');
});

it('does not open a hidden article on the signed-in help page', function () {
    $article = HelpArticle::factory()->hidden()->create([
        'slug' => 'draft-article',
    ]);

    $this->get(route('filament.app.resources.help.view', ['record' => $article->slug]))
        ->assertNotFound();
});

it('does not open a private article on the guest help page', function () {
    $article = HelpArticle::factory()->private()->create([
        'slug' => 'private-policies',
    ]);

    expect(GuestHelpArticleResource::getEloquentQuery()->pluck('slug')->all())->not->toContain('private-policies');

    $this->get(route('filament.guest.resources.help-articles.view', ['record' => $article->slug]))
        ->assertNotFound();
});

function shareUrl(HelpArticle $article): string
{
    $page = new ViewHelpArticle;
    $page->record = $article;

    $method = new ReflectionMethod(ViewHelpArticle::class, 'getShareUrl');

    return $method->invoke($page);
}
