<?php

use Arcanesoft\Auth\Models\Role;

return [
    'title'       => 'Authorization',
    'name'        => 'auth',
    'icon'        => 'fa fa-fw fa-key',
    'roles'       => [Role::ADMINISTRATOR],
    'permissions' => [],
    'children'    => [
        [
            'title'       => 'Statistics',
            'name'        => 'auth-dashboard',
            'route'       => 'auth::foundation.dashboard',
            'icon'        => 'fa fa-fw fa-bar-chart',
            'roles'       => [Role::ADMINISTRATOR],
            'permissions' => ['auth.dashboard.stats'],
        ],
        [
            'title'       => 'Users',
            'name'        => 'auth-users',
            'route'       => 'auth::foundation.users.index',
            'icon'        => 'fa fa-fw fa-users',
            'roles'       => [Role::ADMINISTRATOR],
            'permissions' => ['auth.users.list'],
        ],
        [
            'title'       => 'Roles',
            'name'        => 'auth-roles',
            'route'       => 'auth::foundation.roles.index',
            'icon'        => 'fa fa-fw fa-lock',
            'roles'       => [Role::ADMINISTRATOR],
            'permissions' => ['auth.roles.list'],
        ],
        [
            'title'       => 'Permissions',
            'name'        => 'auth-permissions',
            'route'       => 'auth::foundation.permissions.index',
            'icon'        => 'fa fa-fw fa-check-circle',
            'roles'       => [Role::ADMINISTRATOR],
            'permissions' => ['auth.permissions.list'],
        ],
    ],
];
