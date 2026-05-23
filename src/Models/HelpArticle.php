<?php

namespace Tapp\FilamentHelp\Models;

use Filament\Facades\Filament;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Tapp\FilamentHelp\Support\Tenancy;

class HelpArticle extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'is_public',
        'is_hidden',
        'content',
        'embed',
    ];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        // Dynamically add tenant column to fillable if tenancy is enabled
        if (Tenancy::isEnabled()) {
            $this->fillable[] = Tenancy::column();
        }
    }

    protected $casts = [
        'is_public' => 'boolean',
        'is_hidden' => 'boolean',
    ];

    public function scopePublic($query)
    {
        return $query->where('is_public', true);
    }

    public function scopeVisible($query)
    {
        return $query->where('is_hidden', false);
    }

    /**
     * Scope query to only include articles for a specific tenant/team.
     */
    public function scopeForTenant($query, $tenant)
    {
        if (! Tenancy::hasTenantColumn(static::class)) {
            return $query;
        }

        return $query->where(Tenancy::column(), $tenant->id);
    }

    /**
     * Define your tenant relationship here.
     *
     * Example for Team:
     *
     * public function team(): BelongsTo
     * {
     *     return $this->belongsTo(\App\Models\Team::class);
     * }
     *
     * Or for Organization:
     *
     * public function organization(): BelongsTo
     * {
     *     return $this->belongsTo(\App\Models\Organization::class);
     * }
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($article) {
            if (empty($article->slug)) {
                $article->slug = \Str::slug($article->name);
            }

            // Auto-assign team_id from current Filament tenant if available and enabled
            if (Tenancy::hasTenantColumn(static::class) && config('filament-help.tenancy.auto_assign', true)) {
                $tenantColumn = Tenancy::column();

                if (empty($article->{$tenantColumn}) && class_exists(Filament::class)) {
                    $tenant = Filament::getTenant();
                    if ($tenant) {
                        $article->{$tenantColumn} = $tenant->id;
                    }
                }
            }
        });

        static::updating(function ($article) {
            if ($article->isDirty('name')) {
                $article->slug = \Str::slug($article->name);
            }
        });
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }
}
