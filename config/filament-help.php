<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Tenancy Configuration
    |--------------------------------------------------------------------------
    |
    | Configure multi-tenancy settings for help articles.
    |
    */

    'tenancy' => [
        /*
         * Enable or disable tenancy features globally.
         * When enabled, a team_id column will be added to the help_articles table
         * and articles will be scoped to the current tenant.
         */
        'enabled' => env('FILAMENT_HELP_TENANCY_ENABLED', false),

        /*
         * The column name for the tenant relationship.
         * This column will be added to the help_articles table if tenancy is enabled.
         * E.g. 'team_id'
         */
        'column' => env('FILAMENT_HELP_TENANCY_COLUMN', null),

        /*
         * The tenant model class.
         * This should be the same model you use for Filament's tenant feature.
         * E.g. \App\Models\Team::class
         */
        'model' => null,

        /*
         * The relationship name on the HelpArticle model.
         * This is used for Filament's tenant ownership relationship.
         * E.g. 'team'
         *
         */
        'relationship' => env('FILAMENT_HELP_TENANCY_RELATIONSHIP', null),

        /*
         * The foreign key constraint configuration.
         */
        'foreign_key' => [
            'on_delete' => env('FILAMENT_HELP_TENANCY_ON_DELETE', 'cascade'), // cascade, set null, restrict
            'on_update' => env('FILAMENT_HELP_TENANCY_ON_UPDATE', 'cascade'), // cascade, set null, restrict
        ],

        /*
         * Enable tenancy scoping per panel type.
         * When false, articles will not be scoped by tenant even if global tenancy is enabled.
         */
        'scoping' => [
            'admin' => env('FILAMENT_HELP_TENANCY_SCOPE_ADMIN', true),
            'frontend' => env('FILAMENT_HELP_TENANCY_SCOPE_FRONTEND', true),
            'guest' => env('FILAMENT_HELP_TENANCY_SCOPE_GUEST', false),
        ],

        /*
         * Automatically assign tenant on creation.
         * When enabled, new articles will automatically get the current tenant ID assigned.
         */
        'auto_assign' => env('FILAMENT_HELP_TENANCY_AUTO_ASSIGN', true),
    ],

];

