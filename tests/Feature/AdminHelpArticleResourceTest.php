<?php

use Tapp\FilamentHelp\Models\HelpArticle;

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