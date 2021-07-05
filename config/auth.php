<?php

return [

    // デフォルトの認証をwebからuserに変更
    'defaults' => [
        'guard' => 'user',
        'passwords' => 'users',
    ],

    'guards' => [
        'user' => [
            'driver' => 'session',
            'provider' => 'users',
        ],

        // Admin用の認証を追加
        'admin' => [
            'driver' => 'session',
            'provider' => 'admins',
        ],

        'api' => [
            'driver' => 'token',
            'provider' => 'users',
            'hash' => false,
        ]
    ],

    'providers' => [
        'users' => [
            'driver' => 'eloquent',
            'model' => App\Models\User::class,
        ],

        'admins' => [
            'driver' => 'eloquent',
            'model' => App\Models\Admin::class,
        ]
    ],

    'passwords' => [
        'users' => [
            'provider' => 'users',
            'table' => 'password_resets',
            'expire' => 60,
            'throttle' => 60,
        ],

        'admins' => [
            'provider' => 'admins',
            'table' => 'password_resets',
            'expire' => 60,
            'throttle' => 60,
        ]
    ],

    'password_timeout' => 10800,

];