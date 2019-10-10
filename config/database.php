<?php

return [

    /* -----------------------------------------------------------------
     |  Connections
     | -----------------------------------------------------------------
     */

    'connection' => env('DB_CONNECTION', 'mysql'),

    /* -----------------------------------------------------------------
     |  Tables
     | -----------------------------------------------------------------
     */

    'prefix'     => 'auth_',

    'tables'     => [
        'users'              => 'users',
        'roles'              => 'roles',
        'permissions'        => 'permissions',
        'permissions-groups' => 'permissions_groups',
        'password-resets'    => 'password_resets',
        'throttles'          => 'throttles',
        'role-user'          => 'role_user',
        'permission-role'    => 'permission_role',
    ],

    /* -----------------------------------------------------------------
     |  Models
     | -----------------------------------------------------------------
     */

    'models' => [
        'user'              => App\Models\User::class,
        'role'              => Arcanesoft\Auth\Models\Role::class,
        'permission'        => Arcanesoft\Auth\Models\Permission::class,
        'permissions-group' => Arcanesoft\Auth\Models\PermissionsGroup::class,
        'password-resets'   => Arcanesoft\Auth\Models\PasswordReset::class,
    ],

];
