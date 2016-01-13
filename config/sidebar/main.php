<?php

return [
    'title'       => 'Authorization',
    'name'        => 'auth',
    'icon'        => 'fa fa-fw fa-key',
    'roles'       => [],
    'permissions' => [],
    'children'    => [
        [
            'title'       => 'Statistics',
            'name'        => 'auth-dashboard',
            'route'       => 'auth::foundation.dashboard',
            'icon'        => 'fa fa-fw fa-bar-chart',
            'roles'       => [],
            'permissions' => ['auth.dashboard.stats'],
        ],[
            'title'       => 'Users',
            'name'        => 'auth-users',
            'route'       => 'auth::foundation.users.index',
            'icon'        => 'fa fa-fw fa-users',
            'roles'       => [],
            'permissions' => ['auth.users.list'],
        ],[
            'title'       => 'Roles',
            'name'        => 'auth-roles',
            'route'       => 'auth::foundation.roles.index',
            'icon'        => 'fa fa-fw fa-lock',
            'roles'       => [],
            'permissions' => ['auth.roles.list'],
        ],[
            'title'       => 'Permissions',
            'name'        => 'auth-permissions',
            'route'       => 'auth::foundation.permissions.index',
            'icon'        => 'fa fa-fw fa-check-circle',
            'roles'       => [],
            'permissions' => ['auth.permissions.list'],
        ]
    ],
];
