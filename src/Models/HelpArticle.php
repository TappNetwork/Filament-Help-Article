<?php

namespace Tapp\FilamentHelp\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($article) {
            if (empty($article->slug)) {
                $article->slug = \Str::slug($article->name);
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
