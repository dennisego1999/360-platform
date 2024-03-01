<?php

return [
    'toasts' => [
        'description' => [
            'import_completed' => 'The import was successful',
            'scan_completed' => 'The scan was successful',
            'translation_updated' => 'The translation is updated',
            'translation_deleted' => 'The translation is deleted',
            'user_deleted' => 'The user is deleted',
            'user_updated' => 'The user is updated',
            'user_created' => 'The user is created',
            'three_sixty_area_deleted' => 'The 360 area is deleted',
            'three_sixty_area_updated' => 'The 360 area is updated',
            'three_sixty_area_created' => 'The 360 area is created',
            'three_sixty_viewpoint_deleted' => 'The viewpoint is deleted',
            'three_sixty_viewpoint_updated' => 'The viewpoint is updated',
            'three_sixty_viewpoint_created' => 'The viewpoint is created',
            'three_sixty_clickpoint_deleted' => 'The clickpoint is deleted',
            'three_sixty_clickpoint_updated' => 'The clickpoint is updated',
            'three_sixty_clickpoint_created' => 'The clickpoint is created',
            'error' => 'Something went wrong',
        ],
    ],
    'buttons' => [
        'go_back' => 'Back',
        'edit' => 'Edit',
        'cancel' => 'Cancel',
        'save' => 'Save',
        'remove' => 'Remove',
        'add' => 'Add',
        'yes' => 'Yes',
        'no' => 'No',
        'close' => 'Close',
        'scan' => 'Scan',
        'import' => 'Import',
        'export' => 'Export',
        'create_user' => 'Make new user',
        'create_360_area' => 'Make new 360 area',
        'create_viewpoint' => 'Make new viewpoint',
        'create_clickpoint' => 'Make new clickpoint',
        'viewpoints' => 'Viewpoints',
        'clickpoints' => 'Clickpoints',
    ],
    'labels' => [
        'name' => 'Name',
        'description' => 'Description',
        'photo' => 'Photo',
        'select' => 'Select',
        'first_name' => 'First name',
        'last_name' => 'Last name',
        'email' => 'Email',
        'password' => 'Password',
        'password_confirmation' => 'Confirm password',
        'roles' => 'Roles',
        'image' => 'Image',
        'is_default' => 'Is default',
        'choose_language' => 'Choose a language to edit',
        'coordinates' => 'Place a clickpoint on specific coordinates by clicking on the container',
        'content_type' => 'Choose a content type',
        'content' => 'Content',
        'make_selection' => 'Make a selection',
        'delete_selection' => 'Delete selection',
        'no_items_found' => 'No items found...',
        'instructions' => [
            'viewpoints' => 'Select a viewpoint here',
            'inertia_route' => 'Add a inertia route here',
            'external_url' => 'Add an extern url here',
            'video' => 'Add an embedded share link here',
            'info' => 'Add your html content here'
        ],
    ],
    'pages' => [
        'dashboard' => [
            'label' => 'Dashboard',
            'name' => 'Name',
            'status' => 'Status',
            'roles' => 'Roles',
            'actions' => 'Actions',
            'search' => 'Search',
        ],
        'users' => [
            'label' => 'Users',
            'description' => 'A list of all users with all necessary information.',
            'login' => 'Login',
            'logout' => 'Logout',
            'register' => 'Register',
            'no_users' => 'No users found ...',
        ],
        'translations' => [
            'label' => 'Translations',
            'description' => 'A list of all translations.',
            'table' => [
                'group' => 'Group',
                'key' => 'Key',
                'original_translation' => 'Original translation',
                'new_translation' => 'New translation',
                'locale' => 'Locale',
                'updated_at' => 'Updated at',
                'actions' => 'Actions',
            ],
            'no_translations' => 'No translations found...',
        ],
        'profile' => [
            'label' => 'Profile',
        ],
        'three_sixty_generator' => [
            'areas' => [
                'index' => [
                    'label' => '360 generator',
                    'description' => 'A list of all 360 areas',
                    'no_areas' => 'No 360 areas found...',
                ],
                'create' => [
                    'label' => '360 generator',
                    'description' => 'Create new 360 area',
                ],
                'show' => [
                    'label' => '360 generator',
                    'description' => 'Look at the info of this 360 area',
                ],
                'edit' => [
                    'label' => '360 generator',
                    'description' => 'Edit this 360 area',
                ],
            ],
            'viewpoints' => [
                'index' => [
                    'label' => 'Viewpoints in area: {name}',
                    'description' => 'A list of all viewpoints',
                    'no_viewpoints' => 'No viewpoints found...',
                ],
                'create' => [
                    'label' => 'Viewpoints in area: {name}',
                    'description' => 'Create new viewpoint',
                ],
                'show' => [
                    'label' => 'Viewpoints in area: {name}',
                    'description' => 'Look at the info of this viewpoint',
                ],
                'edit' => [
                    'label' => 'Viewpoints in area: {name}',
                    'description' => 'Edit this viewpoint',
                ],
            ],
            'clickpoints' => [
                'index' => [
                    'label' => 'Clickpoints of viewpoint: {name}',
                    'description' => 'A list of all clickpoints',
                    'no_viewpoints' => 'No clickpoints found...',
                ],
                'create' => [
                    'label' => 'Clickpoints of viewpoint: {name}',
                    'description' => 'Create new clickpoint',
                ],
                'show' => [
                    'label' => 'Clickpoints of viewpoint: {name}',
                    'description' => 'Look at the info of this clickpoint',
                ],
                'edit' => [
                    'label' => 'Clickpoints of viewpoint: {name}',
                    'description' => 'Edit this clickpoint',
                ],
            ]
        ],
    ],
    'modals' => [
        'change_language' => 'Do you want to switch to {locale}?'
    ],
];
