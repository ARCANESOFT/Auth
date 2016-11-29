<?php namespace Arcanesoft\Auth\Seeds\Foundation;

use Arcanesoft\Auth\Policies\DashboardPolicy;
use Arcanesoft\Auth\Policies\PasswordResetsPolicy;
use Arcanesoft\Auth\Policies\PermissionsPolicy;
use Arcanesoft\Auth\Policies\RolesPolicy;
use Arcanesoft\Auth\Policies\UsersPolicy;
use Arcanesoft\Auth\Seeds\PermissionsSeeder;

/**
 * Class     PermissionTableSeeder
 *
 * @package  Arcanesoft\Auth\Seeds\Foundation
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class PermissionTableSeeder extends PermissionsSeeder
{
    /* ------------------------------------------------------------------------------------------------
     |  Main Functions
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $this->seed([
            [
                'group'       => [
                    'name'        => 'Auth',
                    'slug'        => 'auth',
                    'description' => 'Auth permissions group',
                ],
                'permissions' => array_merge(
                    $this->getDashboardSeeds(),
                    $this->getUsersSeeds(),
                    $this->getRolesSeeds(),
                    $this->getPermissionsSeeds(),
                    $this->getPasswordResetsSeeds()
                ),
            ],
        ]);
    }

    /* ------------------------------------------------------------------------------------------------
     |  Other Functions
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Get the other permissions seeds for auth module.
     *
     * @return array
     */
    private function getDashboardSeeds()
    {
        return [
            [
                'name'        => 'Dashboard - View the dashboard stats',
                'description' => 'Allow to view a auth stats.',
                'slug'        => DashboardPolicy::PERMISSION_STATS,
            ],
        ];
    }

    /**
     * Get user's permissions seeds.
     *
     * @return array
     */
    private function getUsersSeeds()
    {
        return [
            [
                'name'        => 'Users - List all users',
                'description' => 'Allow to list all users.',
                'slug'        => UsersPolicy::PERMISSION_LIST,
            ],
            [
                'name'        => 'Users - View a user',
                'description' => 'Allow to view a user\'s details.',
                'slug'        => UsersPolicy::PERMISSION_SHOW,
            ],
            [
                'name'        => 'Users - Add/Create a user',
                'description' => 'Allow to create a new user.',
                'slug'        => UsersPolicy::PERMISSION_CREATE,
            ],
            [
                'name'        => 'Users - Edit/Update a user',
                'description' => 'Allow to update a user.',
                'slug'        => UsersPolicy::PERMISSION_UPDATE,
            ],
            [
                'name'        => 'Users - Delete a user',
                'description' => 'Allow to delete a user.',
                'slug'        => UsersPolicy::PERMISSION_DELETE,
            ],
        ];
    }

    /**
     * Get role's permissions seeds.
     *
     * @return array
     */
    private function getRolesSeeds()
    {
        return [
            [
                'name'        => 'Roles - List all roles',
                'description' => 'Allow to list all roles.',
                'slug'        => RolesPolicy::PERMISSION_LIST,
            ],
            [
                'name'        => 'Roles - View a role',
                'description' => 'Allow to view the role\'s details.',
                'slug'        => RolesPolicy::PERMISSION_SHOW,
            ],
            [
                'name'        => 'Roles - Add/Create a role',
                'description' => 'Allow to create a new role.',
                'slug'        => RolesPolicy::PERMISSION_CREATE,
            ],
            [
                'name'        => 'Roles - Edit/Update a role',
                'description' => 'Allow to update a role.',
                'slug'        => RolesPolicy::PERMISSION_UPDATE,
            ],
            [
                'name'        => 'Roles - Delete a role',
                'description' => 'Allow to delete a role.',
                'slug'        => RolesPolicy::PERMISSION_DELETE,
            ],
        ];
    }

    /**
     * Get permissions's permissions seeds. (** Inception **)
     *
     * @return array
     */
    private function getPermissionsSeeds()
    {
        return [
            [
                'name'        => 'Permissions - List all permissions',
                'description' => 'Allow to list all permissions.',
                'slug'        => PermissionsPolicy::PERMISSION_LIST,
            ],
            [
                'name'        => 'Permissions - View a permission',
                'description' => 'Allow to view the permission\'s details.',
                'slug'        => PermissionsPolicy::PERMISSION_SHOW,
            ],
            [
                'name'        => 'Permissions - Update a permission',
                'description' => 'Allow to update a permission.',
                'slug'        => PermissionsPolicy::PERMISSION_UPDATE,
            ],
        ];
    }

    /**
     * Get password resets' permissions seeds.
     *
     * @return array
     */
    private function getPasswordResetsSeeds()
    {
        return [
            [
                'name'        => 'Password Resets - List all permissions',
                'description' => 'Allow to list all password resets.',
                'slug'        => PasswordResetsPolicy::PERMISSION_LIST,
            ],
            [
                'name'        => 'Password Resets - Delete password resets',
                'description' => 'Allow to delete password resets.',
                'slug'        => PasswordResetsPolicy::PERMISSION_DELETE,
            ],
        ];
    }
}
