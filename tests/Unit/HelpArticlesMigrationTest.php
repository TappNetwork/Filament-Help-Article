<?php

declare(strict_types=1);

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

final class HelpArticlesMigrationOrganization extends Model
{
    protected $table = 'organizations';

    protected $guarded = [];
}

beforeEach(function (): void {
    Schema::dropIfExists('help_articles');
    Schema::dropIfExists('organizations');

    Schema::create('organizations', function (Blueprint $table): void {
        $table->id();
        $table->string('name');
        $table->timestamps();
    });

    config([
        'filament-help.tenancy.enabled' => true,
        'filament-help.tenancy.model' => HelpArticlesMigrationOrganization::class,
        'filament-help.tenancy.column' => 'organization_id',
    ]);

    $migration = require __DIR__.'/../../database/migrations/create_help_articles_table.php.stub';
    $migration->up();
});

it('creates the tenant foreign key from filament-help.tenancy.model instead of a hard-coded teams table', function (): void {
    expect(Schema::hasColumn('help_articles', 'organization_id'))->toBeTrue()
        ->and(Schema::hasColumn('help_articles', 'team_id'))->toBeFalse()
        ->and(Schema::hasTable('teams'))->toBeFalse();

    $organization = HelpArticlesMigrationOrganization::query()->create(['name' => 'Acme']);

    $articleId = DB::table('help_articles')->insertGetId([
        'organization_id' => $organization->id,
        'name' => 'Tenant Scoped Article',
        'slug' => 'tenant-scoped-article',
        'is_public' => false,
        'created_at' => now(),
        'updated_at' => now(),
    ]);

    expect(DB::table('help_articles')->where('id', $articleId)->value('organization_id'))
        ->toBe($organization->id);
});

it('requires a tenant model when tenancy is enabled', function (): void {
    Schema::dropIfExists('help_articles');

    config([
        'filament-help.tenancy.enabled' => true,
        'filament-help.tenancy.model' => null,
        'filament-help.tenancy.column' => 'organization_id',
    ]);

    $migration = require __DIR__.'/../../database/migrations/create_help_articles_table.php.stub';

    expect(fn () => $migration->up())
        ->toThrow(InvalidArgumentException::class, 'Tenant model not configured in filament-help.tenancy.model');
});
