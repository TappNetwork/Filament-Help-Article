<?php

use Tapp\FilamentHelp\Models\HelpArticle;

it('can access public help article via public route when unauthenticated', function () {
    $article = HelpArticle::factory()->public()->create([
        'name' => 'Public Article',
        'slug' => 'public-article',
        'content' => 'This is public content',
    ]);

    $response = $this->get(route('filament-help.public.show', $article->slug));

    $response->assertStatus(200);
    $response->assertSee('Public Article');
    $response->assertSee('This is public content');
});

it('returns 404 for non-public article via public route', function () {
    $article = HelpArticle::factory()->private()->create([
        'name' => 'Private Article',
        'slug' => 'private-article',
    ]);

    $response = $this->get(route('filament-help.public.show', $article->slug));

    $response->assertStatus(404);
});

it('returns 404 for non-existent article via public route', function () {
    $response = $this->get(route('filament-help.public.show', 'non-existent-article'));

    $response->assertStatus(404);
});

it('returns 404 for hidden article via public route even if public', function () {
    $article = HelpArticle::factory()->public()->hidden()->create([
        'name' => 'Hidden Public Article',
        'slug' => 'hidden-public-article',
        'content' => 'This is hidden but public content',
    ]);

    $response = $this->get(route('filament-help.public.show', $article->slug));

    // Hidden articles are not accessible via public route, even if is_public is true
    $response->assertStatus(404);
});

it('filters out hidden articles from frontend query', function () {
    $visibleArticle = HelpArticle::factory()->public()->create([
        'name' => 'Visible Article',
        'is_hidden' => false,
    ]);

    $hiddenArticle = HelpArticle::factory()->public()->hidden()->create([
        'name' => 'Hidden Article',
        'is_hidden' => true,
    ]);

    $visibleArticles = HelpArticle::public()->visible()->get();

    expect($visibleArticles->count())->toBe(1);
    expect($visibleArticles->first()->name)->toBe('Visible Article');
    expect($visibleArticles->pluck('name'))->not->toContain('Hidden Article');
});

it('can check if help article is hidden', function () {
    $hiddenArticle = HelpArticle::factory()->hidden()->create();
    $visibleArticle = HelpArticle::factory()->create(['is_hidden' => false]);

    expect($hiddenArticle->is_hidden)->toBeTrue();
    expect($visibleArticle->is_hidden)->toBeFalse();
});

