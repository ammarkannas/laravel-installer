<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Minimum PHP Version
    |--------------------------------------------------------------------------
    |
    | The minimum php version to run script.
    |
    */
    'php-version' => '8.0.0',

    /*
    |--------------------------------------------------------------------------
    | Server Requirements
    |--------------------------------------------------------------------------
    |
    | This is the default Laravel server requirements, you can add as many
    | as your application require, we check if the extension is enabled
    | by looping through the array and run "extension_loaded" on it.
    |
    */
    'requirements' => [
        'php-extensions' => [
            'openssl',
            'pdo',
            'mbstring',
            'tokenizer',
            'json',
            'curl',
        ],
        'apache-mods' => [
            'mod_rewrite',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Folders Permissions
    |--------------------------------------------------------------------------
    |
    | This is the default Laravel folders permissions, if your application
    | requires more permissions just add them to the array list bellow.
    |
    */
    'permissions' => [
        'storage/framework/'     => '775',
        'storage/logs/'          => '775',
        'bootstrap/cache/'       => '775',
    ],

    /*
    |--------------------------------------------------------------------------
    | Publish vendor while installing.
    |--------------------------------------------------------------------------
    |
    | Publish all vendors while installing.
    |
    */
    'vendor-publish' => false,

    /*
    |--------------------------------------------------------------------------
    | Installed Middleware Options
    |--------------------------------------------------------------------------
    | Different available status switch configuration for the
    | middleware.
    |
    */
    'routes' => [
        'prefix' => 'install',
        'name-prefix' => 'installer::',
        'install-middleware-group' => ['can-install', 'web'],

        'middleware' => [
            'can-install' => [
                \Rwxrwx\Installer\Http\Middleware\CanInstall::class
            ],
            'can-update' => [
                // \Rwxrwx\Http\Middleware\CanUpdate::class
            ]
        ]
    ],

    /*
    |--------------------------------------------------------------------------
    | Installer progress steps
    |--------------------------------------------------------------------------
    |
    */
    'steps' => [
        'welcome' => 'installer::welcome',
        'server-requirements' => 'installer::server-requirements',
        'permissions' => 'installer::permissions',
        'environment-setup' => 'installer::environment-setup',
        'finish' => 'installer::finish',
    ],
];
