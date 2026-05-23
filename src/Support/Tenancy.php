<?php

namespace Tapp\FilamentHelp\Support;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Schema;
use Tapp\FilamentHelp\Models\HelpArticle;

class Tenancy
{
    public static function isEnabled(): bool
    {
        return (bool) config('filament-help.tenancy.enabled', false);
    }

    public static function column(): string
    {
        $column = config('filament-help.tenancy.column', 'team_id');

        return is_string($column) && $column !== '' ? $column : 'team_id';
    }

    public static function hasTenantColumn(?string $modelClass = null): bool
    {
        if (! static::isEnabled()) {
            return false;
        }

        $modelClass ??= config('filament-help.model', HelpArticle::class);

        if (! is_string($modelClass) || ! is_subclass_of($modelClass, Model::class)) {
            $modelClass = HelpArticle::class;
        }

        /** @var Model $model */
        $model = new $modelClass;

        return Schema::hasTable($model->getTable())
            && Schema::hasColumn($model->getTable(), static::column());
    }
}
