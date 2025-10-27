<?php

return [
    'navigation' => [
        'group' => 'Help',
        'label' => 'Help Articles',
    ],
    'pages' => [
        'list-help' => [
            'title' => 'Help Articles',
            'description' => 'Find answers to common questions and learn how to use our platform.',
        ],
        'view-help' => [
            'back_to_help' => 'Back to Help',
            'last_updated' => 'Last updated :date',
        ],
    ],
    'resources' => [
        'help-article' => [
            'label' => 'Help Article',
            'plural_label' => 'Help Articles',
            'navigation' => [
                'label' => 'Help Articles',
                'group' => 'Help',
            ],
            'form' => [
                'name' => 'Name',
                'is_public' => 'Public',
                'content' => 'Content',
            ],
            'table' => [
                'name' => 'Name',
                'is_public' => 'Public',
                'created_at' => 'Created At',
                'updated_at' => 'Updated At',
            ],
            'filters' => [
                'is_public' => [
                    'label' => 'Public',
                    'true_label' => 'Public only',
                    'false_label' => 'Private only',
                ],
            ],
        ],
    ],
];
