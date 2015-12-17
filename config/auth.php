<?php

return [
    'route'             => [
        'prefix' => 'authorization',
    ],

    'database'          => [
        'connection' => config('database.default'),
    ],

    'users'             => [
        'table' => 'users',
        'model' => Arcanesoft\Auth\Models\User::class,
    ],

    'roles'             => [
        'table' => 'roles',
        'model' => Arcanesoft\Auth\Models\Role::class,
    ],

    'permissions'       => [
        'table' => 'permissions',
        'model' => Arcanesoft\Auth\Models\Permission::class,
    ],

    'user-confirmation' => [
        'enabled'   => true,
        'length'    => 30,
    ],

    'throttles'         => [
        'enabled' => true,
        'table'   => 'throttles',
    ],

    'slug-separator'    => '.',

    'seeds'             => [
        'users' => [
            [
                'username'   => 'admin',
                'email'      => env('ADMIN_USER_EMAIL', 'admin@email.com'),
                'password'   => env('ADMIN_USER_PASSWORD', 'password'),
            ],
        ],
    ],
];
