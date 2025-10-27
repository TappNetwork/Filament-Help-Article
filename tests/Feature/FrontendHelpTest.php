<?php

use Livewire\Livewire;
use Tapp\FilamentHelp\Models\HelpArticle;
use Tapp\FilamentHelp\Pages\ListHelp;
use Tapp\FilamentHelp\Pages\ViewHelp;

it('can list public help articles', function () {
    $publicArticle = HelpArticle::factory()->public()->create(['name' => 'Public Article']);
    $privateArticle = HelpArticle::factory()->private()->create(['name' => 'Private Article']);

    Livewire::test(ListHelp::class)
        ->assertSee('Public Article')
        ->assertDontSee('Private Article');
});

it('can view a public help article', function () {
    $helpArticle = HelpArticle::factory()->public()->create([
        'name' => 'Test Article',
        'content' => 'This is test content',
    ]);

    Livewire::test(ViewHelp::class, ['record' => $helpArticle->id])
        ->assertSee('Test Article')
        ->assertSee('This is test content');
});

it('cannot view a private help article', function () {
    $helpArticle = HelpArticle::factory()->private()->create();

    expect(fn () => Livewire::test(ViewHelp::class, ['record' => $helpArticle->id]))
        ->toThrow(Illuminate\Http\Exceptions\HttpResponseException::class);
});

it('renders list help page without errors', function () {
    HelpArticle::factory()->public()->count(3)->create();

    $response = Livewire::test(ListHelp::class);
    expect($response)->not->toBeNull();
    $response->assertSee('Help Articles');
});

it('renders view help page without errors', function () {
    $helpArticle = HelpArticle::factory()->public()->create([
        'name' => 'Test Article',
        'content' => '<p>This is <strong>HTML</strong> content</p>',
    ]);

    $response = Livewire::test(ViewHelp::class, ['record' => $helpArticle->id]);
    
    expect($response)->not->toThrow();
    $response->assertSee('Test Article');
    $response->assertSee('This is HTML content');
});

it('handles empty help articles list', function () {
    $response = Livewire::test(ListHelp::class);
    
    expect($response)->not->toThrow();
    $response->assertSee('No help articles available');
});

it('handles help article with no content', function () {
    $helpArticle = HelpArticle::factory()->public()->create([
        'name' => 'Empty Article',
        'content' => null,
    ]);

    $response = Livewire::test(ViewHelp::class, ['record' => $helpArticle->id]);
    
    expect($response)->not->toThrow();
    $response->assertSee('Empty Article');
    $response->assertSee('No content available');
});
