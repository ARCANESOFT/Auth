<?php

use Arcanesoft\Auth\Models\Role;

return [
    'items' => [
        // Authorization
        [
            'name'        => 'auth::authorization',
            'title'       => 'Authorization',
            'icon'        => 'fas fa-fw fa-key',
            'roles'       => [],
            'permissions' => [],
            'children'    => [
                [
                    'name'        => 'auth::authorization.dashboard',
                    'title'       => 'Statistics',
                    'icon'        => 'fas fa-fw fa-tachometer-alt',
                    'route'       => 'admin::auth.index',
                    'roles'       => [
                        Role::ADMINISTRATOR,
                        'auth-moderator',
                    ],
                    'permissions' => [],
                ],
                [
                    'name'        => 'auth::authorization.users',
                    'title'       => 'Users',
                    'icon'        => 'fas fa-fw fa-users',
                    'route'       => 'admin::auth.users.index',
                    'roles'       => [
                        Role::ADMINISTRATOR,
                        'auth-moderator',
                    ],
                    'permissions' => [],
                ],
                [
                    'name'        => 'auth::authorization.roles',
                    'title'       => 'Roles',
                    'icon'        => 'fas fa-fw fa-user-tag',
                    'route'       => 'admin::auth.roles.index',
                    'roles'       => [
                        Role::ADMINISTRATOR,
                        'auth-moderator',
                    ],
                    'permissions' => [],
                ],
                [
                    'name'        => 'auth::authorization.permissions',
                    'title'       => 'Permissions',
                    'icon'        => 'fas fa-fw fa-shield-alt',
                    'route'       => 'admin::auth.permissions.index',
                    'roles'       => [
                        Role::ADMINISTRATOR,
                        'auth-moderator',
                    ],
                    'permissions' => [],
                ],
                [
                    'name'        => 'auth::authorization.password-resets',
                    'title'       => 'Password Resets',
                    'icon'        => 'fas fa-fw fa-sync',
                    'route'       => 'admin::auth.password-resets.index',
                    'roles'       => [
                        Role::ADMINISTRATOR,
                        'auth-moderator',
                    ],
                    'permissions' => [],
                ],
            ],
        ]
    ],
];
