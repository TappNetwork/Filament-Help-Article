<?php

use Tapp\FilamentHelp\Models\HelpArticle;

return [

    /*
    |--------------------------------------------------------------------------
    | Help Article Model
    |--------------------------------------------------------------------------
    |
    | If you extend the HelpArticle model in your application to add custom
    | relationships (e.g., tenant relationships), specify your extended model here.
    | This ensures Filament resources use your extended model instead of the base model.
    |
    | Example: \App\Models\HelpArticle::class
    |
    */

    'model' => HelpArticle::class,

    /*
    |--------------------------------------------------------------------------
    | Rich Editor Configuration
    |--------------------------------------------------------------------------
    |
    | Configure how images are stored when uploaded via the Content rich editor.
    | By default, attachments are stored publicly so article HTML can be
    | rendered without temporary URL generation.
    |
    */

    'editor' => [
        'file_attachments' => [
            'disk' => env('FILAMENT_HELP_FILE_ATTACHMENTS_DISK'),
            'directory' => env('FILAMENT_HELP_FILE_ATTACHMENTS_DIRECTORY', 'help-articles'),
            'visibility' => env('FILAMENT_HELP_FILE_ATTACHMENTS_VISIBILITY', 'public'),
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Frontend Configuration
    |--------------------------------------------------------------------------
    |
    | Configure the frontend help article resource behaviour.
    |
    */

    'frontend' => [
        'resource' => [
            /*
             * Whether the frontend Help resource appears in the panel navigation.
             * Set to false to hide from the topbar and use a custom link (e.g. in the user menu) instead.
             */
            'should_register_navigation' => true,
        ],
    ],

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
            'guest' => env('FILAMENT_HELP_TENANCY_SCOPE_GUEST', true),
        ],

        /*
         * Automatically assign tenant on creation.
         * When enabled, new articles will automatically get the current tenant ID assigned.
         */
        'auto_assign' => env('FILAMENT_HELP_TENANCY_AUTO_ASSIGN', true),
    ],

];
