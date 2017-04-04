<?php

use Arcanesoft\Auth\Models\Role;
use Arcanesoft\Auth\Policies;

return [
    'title'       => 'auth::sidebar.authorization',
    'name'        => 'auth',
    'icon'        => 'fa fa-fw fa-key',
    'roles'       => [Role::ADMINISTRATOR],
    'permissions' => [],
    'children'    => [
        [
            'title'       => 'auth::sidebar.statistics',
            'name'        => 'auth-dashboard',
            'route'       => 'admin::auth.dashboard',
            'icon'        => 'fa fa-fw fa-bar-chart',
            'roles'       => [Role::ADMINISTRATOR],
            'permissions' => [
                Policies\DashboardPolicy::PERMISSION_STATS
            ],
        ],
        [
            'title'       => 'auth::sidebar.users',
            'name'        => 'auth-users',
            'route'       => 'admin::auth.users.index',
            'icon'        => 'fa fa-fw fa-users',
            'roles'       => [Role::ADMINISTRATOR],
            'permissions' => [
                Policies\UsersPolicy::PERMISSION_LIST,
            ],
        ],
        [
            'title'       => 'auth::sidebar.roles',
            'name'        => 'auth-roles',
            'route'       => 'admin::auth.roles.index',
            'icon'        => 'fa fa-fw fa-lock',
            'roles'       => [Role::ADMINISTRATOR],
            'permissions' => [
                Policies\RolesPolicy::PERMISSION_LIST,
            ],
        ],
        [
            'title'       => 'auth::sidebar.permissions',
            'name'        => 'auth-permissions',
            'route'       => 'admin::auth.permissions.index',
            'icon'        => 'fa fa-fw fa-check-circle',
            'roles'       => [Role::ADMINISTRATOR],
            'permissions' => [
                Policies\PermissionsPolicy::PERMISSION_LIST,
            ],
        ],
        [
            'title'       => 'auth::sidebar.password-resets',
            'name'        => 'auth-password-resets',
            'route'       => 'admin::auth.password-resets.index',
            'icon'        => 'fa fa-fw fa-refresh',
            'roles'       => [Role::ADMINISTRATOR],
            'permissions' => [
                Policies\PasswordResetsPolicy::PERMISSION_LIST,
            ],
        ],
    ],
];
