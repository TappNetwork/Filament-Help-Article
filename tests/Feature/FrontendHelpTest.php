<?php

use Tapp\FilamentHelp\Models\HelpArticle;

it('can create and filter public help articles', function () {
    $publicArticle = HelpArticle::factory()->public()->create(['name' => 'Public Article']);
    $privateArticle = HelpArticle::factory()->private()->create(['name' => 'Private Article']);

    expect(HelpArticle::public()->count())->toBe(1);
    expect(HelpArticle::public()->first()->name)->toBe('Public Article');
    expect(HelpArticle::count())->toBe(2);
});

it('can create help article with slug', function () {
    $helpArticle = HelpArticle::factory()->create([
        'name' => 'Test Article',
        'content' => 'This is test content',
    ]);

    expect($helpArticle->slug)->not->toBeNull();
    expect($helpArticle->slug)->toBe('test-article');
});

it('can update help article slug when name changes', function () {
    $helpArticle = HelpArticle::factory()->create(['name' => 'Original Name']);
    $originalSlug = $helpArticle->slug;

    $helpArticle->update(['name' => 'Updated Name']);
    
    expect($helpArticle->slug)->not->toBe($originalSlug);
    expect($helpArticle->slug)->toBe('updated-name');
});

it('can view help article by slug', function () {
    $helpArticle = HelpArticle::factory()->public()->create([
        'name' => 'Test Article',
        'slug' => 'test-article',
    ]);

    $foundArticle = HelpArticle::where('slug', 'test-article')->first();
    
    expect($foundArticle)->not->toBeNull();
    expect($foundArticle->name)->toBe('Test Article');
});

it('can check if help article is public', function () {
    $publicArticle = HelpArticle::factory()->public()->create();
    $privateArticle = HelpArticle::factory()->private()->create();

    expect($publicArticle->is_public)->toBeTrue();
    expect($privateArticle->is_public)->toBeFalse();
});
