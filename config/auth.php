<?php

return [

    /* -----------------------------------------------------------------
     |  Route
     | -----------------------------------------------------------------
     */

    'route'              => [
        'prefix' => 'authorization',
    ],

    /* -----------------------------------------------------------------
     |  Authentication
     | -----------------------------------------------------------------
     */

    'authentication'     => [
        'login-logout'  => [
            'enabled' => true,
        ],

        'register'      => [
            'enabled' => true,
        ],

        'password-reset' => [
            'enabled' => true,
        ],
    ],

    /* -----------------------------------------------------------------
     |  Database
     | -----------------------------------------------------------------
     */

    'database'           => [
        'connection' => config('database.default'),

        'prefix'     => 'auth_'
    ],

    /* -----------------------------------------------------------------
     |  Models
     | -----------------------------------------------------------------
     */

    'users'              => [
        'table'          => 'users',
        'model'          => \Arcanesoft\Auth\Models\User::class,
        'observer'       => \Arcanesoft\Auth\Models\Observers\UserObserver::class,
        'slug-separator' => '.',
    ],

    'roles'              => [
        'table'          => 'roles',
        'model'          => \Arcanesoft\Auth\Models\Role::class,
        'observer'       => \Arcanesoft\Auth\Models\Observers\RoleObserver::class,
        'slug-separator' => '-',
    ],

    'role-user'          => [
        'table'          => 'role_user',
        'model'          => \Arcanedev\LaravelAuth\Models\Pivots\RoleUser::class,
    ],

    'permissions-groups' => [
        'table'          => 'permissions_groups',
        'model'          => \Arcanesoft\Auth\Models\PermissionsGroup::class,
        'observer'       => \Arcanesoft\Auth\Models\Observers\PermissionsGroupObserver::class,
        'slug-separator' => '-',
    ],

    'permissions'        => [
        'table'          => 'permissions',
        'model'          => \Arcanesoft\Auth\Models\Permission::class,
        'observer'       => \Arcanesoft\Auth\Models\Observers\PermissionObserver::class,
        'slug-separator' => '.',
    ],

    'permission-role'    => [
        'table'          => 'permission_role',
        'model'          => \Arcanedev\LaravelAuth\Models\Pivots\PermissionRole::class,
    ],

    'password-resets'    => [
        'model'          => \Arcanedev\LaravelAuth\Models\PasswordReset::class,
    ],

    /* -----------------------------------------------------------------
     |  Observers
     | -----------------------------------------------------------------
     */

    'observers' => [
        'enabled'  => true,

        'bindings' => [
            'users'              => \Arcanesoft\Contracts\Auth\Models\User::class,
            'roles'              => \Arcanesoft\Contracts\Auth\Models\Role::class,
            'permissions-groups' => \Arcanesoft\Contracts\Auth\Models\PermissionsGroup::class,
            'permissions'        => \Arcanesoft\Contracts\Auth\Models\Permission::class,
        ],
    ],

    /* -----------------------------------------------------------------
     |  User confirmation
     | -----------------------------------------------------------------
     */

    'user-confirmation'  => [
        'enabled'   => true,

        'length'    => 30,
    ],

    /* -----------------------------------------------------------------
     |  Impersonation
     | -----------------------------------------------------------------
     */

    'impersonation'      => [
        'enabled' => false,

        'session' => [
            'key' => 'impersonator_id',
        ],
    ],

    /* -----------------------------------------------------------------
     |  User Last Activity
     | -----------------------------------------------------------------
     */

    'track-activity' => [
        'enabled' => true,

        'minutes' => 5,
    ],

    /* -----------------------------------------------------------------
     |  Socialite
     | -----------------------------------------------------------------
     */

    'socialite'          => [
        'enabled' => false,

        'drivers' => [
            'bitbucket' => [
                'enabled' => false,
            ],

            'facebook'  => [
                'enabled' => true,
            ],

            'github'    => [
                'enabled' => false,
            ],

            'google'    => [
                'enabled' => true,
            ],

            'linkedin'  => [
                'enabled' => false,
            ],

            'twitter'   => [
                'enabled' => true,
            ],
        ],
    ],

    /* -----------------------------------------------------------------
     |  Throttles
     | -----------------------------------------------------------------
     */

    'throttles'          => [
        'enabled' => true,

        'table'   => 'throttles',
    ],

    /* -----------------------------------------------------------------
     |  Seeds
     | -----------------------------------------------------------------
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

];
