<?php

use Tapp\FilamentHelp\Models\HelpArticle;

it('can create a help article', function () {
    $helpArticle = HelpArticle::factory()->create([
        'name' => 'Test Article',
        'is_public' => true,
        'content' => 'This is test content',
    ]);

    expect($helpArticle->name)->toBe('Test Article');
    expect($helpArticle->is_public)->toBeTrue();
    expect($helpArticle->content)->toBe('This is test content');
});

it('can filter public articles', function () {
    HelpArticle::factory()->create(['is_public' => true]);
    HelpArticle::factory()->create(['is_public' => false]);

    $publicArticles = HelpArticle::public()->get();

    expect($publicArticles)->toHaveCount(1);
    expect($publicArticles->first()->is_public)->toBeTrue();
});

it('casts is_public as boolean', function () {
    $helpArticle = HelpArticle::factory()->create(['is_public' => 1]);

    expect($helpArticle->is_public)->toBeTrue();
    expect($helpArticle->is_public)->toBeBool();
});

it('renders rich editor content as html', function () {
    $helpArticle = HelpArticle::factory()->create([
        'content' => '<p>First paragraph</p><p><img src="https://example.com/image.png" alt="Demo"></p>',
    ]);

    $html = $helpArticle->renderContent()->toHtml();

    expect($html)->toContain('<p>First paragraph</p>');
    expect($html)->toContain('src="https://example.com/image.png"');
    expect($html)->toContain('alt="Demo"');
});
