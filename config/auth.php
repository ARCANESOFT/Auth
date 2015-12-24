<?php

return [
    /* ------------------------------------------------------------------------------------------------
     |  Route
     | ------------------------------------------------------------------------------------------------
     */
    'route'              => [
        'prefix' => 'authorization',
    ],

    /* ------------------------------------------------------------------------------------------------
     |  Database
     | ------------------------------------------------------------------------------------------------
     */
    'database'           => [
        'connection' => config('database.default'),
    ],

    /* ------------------------------------------------------------------------------------------------
     |  Models
     | ------------------------------------------------------------------------------------------------
     */
    'users'              => [
        'table'    => 'users',
        'model'    => Arcanesoft\Auth\Models\User::class,
        'observer' => Arcanesoft\Auth\Observers\UserObserver::class,
    ],

    'roles'              => [
        'table'    => 'roles',
        'model'    => Arcanesoft\Auth\Models\Role::class,
        'observer' => Arcanesoft\Auth\Observers\RoleObserver::class,
    ],

    'permissions-groups' => [
        'table'    => 'permissions_groups',
        'model'    => Arcanesoft\Auth\Models\PermissionsGroup::class,
        'observer' => Arcanesoft\Auth\Observers\PermissionsGroupObserver::class,
    ],

    'permissions'        => [
        'table'    => 'permissions',
        'model'    => Arcanesoft\Auth\Models\Permission::class,
        'observer' => Arcanesoft\Auth\Observers\PermissionObserver::class,
    ],

    /* ------------------------------------------------------------------------------------------------
     |  User confirmation
     | ------------------------------------------------------------------------------------------------
     */
    'user-confirmation'  => [
        'enabled'   => true,
        'length'    => 30,
    ],

    /* ------------------------------------------------------------------------------------------------
     |  Throttles
     | ------------------------------------------------------------------------------------------------
     */
    'throttles'          => [
        'enabled' => true,
        'table'   => 'throttles',
    ],

    /* ------------------------------------------------------------------------------------------------
     |  Seeds
     | ------------------------------------------------------------------------------------------------
     */
    'seeds'              => [
        'users' => [
            [
                'username'   => 'admin',
                'email'      => env('ADMIN_USER_EMAIL', 'admin@email.com'),
                'password'   => env('ADMIN_USER_PASSWORD', 'password'),
            ],
        ],
    ],

    /* ------------------------------------------------------------------------------------------------
     |  Other stuff
     | ------------------------------------------------------------------------------------------------
     */
    'use-observers'      => true,

    'slug-separator'     => '.',
];
