<?php

use Tapp\FilamentHelp\Models\HelpArticle;
use Tapp\FilamentHelp\Support\Tenancy;

it('does not apply tenant scope when tenancy is enabled but the tenant column is missing', function () {
    config()->set('filament-help.tenancy.enabled', true);

    HelpArticle::factory()->public()->create(['name' => 'Shared Article']);

    $articles = HelpArticle::query()
        ->forTenant((object) ['id' => 1])
        ->get();

    expect(Tenancy::hasTenantColumn())->toBeFalse()
        ->and($articles)->toHaveCount(1)
        ->and($articles->first()->name)->toBe('Shared Article');
});
