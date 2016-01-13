<?php namespace Arcanesoft\Auth\Seeds\Foundation;

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
                    $this->getUsersSeeds(),
                    $this->getRolesSeeds(),
                    $this->getPermissionsSeeds(),
                    $this->getOtherSeeds()
                ),
            ],
        ]);
    }

    /* ------------------------------------------------------------------------------------------------
     |  Other Functions
     | ------------------------------------------------------------------------------------------------
     */
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
                'slug'        => 'auth.users.list',
            ],[
                'name'        => 'Users - View a user',
                'description' => 'Allow to view a user\'s details.',
                'slug'        => 'auth.users.show',
            ],[
                'name'        => 'Users - Add/Create a user',
                'description' => 'Allow to create a new user.',
                'slug'        => 'auth.users.create',
            ],[
                'name'        => 'Users - Edit/Update a user',
                'description' => 'Allow to update a user.',
                'slug'        => 'auth.users.update',
            ],[
                'name'        => 'Users - Delete a user',
                'description' => 'Allow to delete a user.',
                'slug'        => 'auth.users.delete',
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
                'slug'        => 'auth.roles.list',
            ],[
                'name'        => 'Roles - View a role',
                'description' => 'Allow to view the role\'s details.',
                'slug'        => 'auth.roles.show',
            ],[
                'name'        => 'Roles - Add/Create a role',
                'description' => 'Allow to create a new role.',
                'slug'        => 'auth.roles.create',
            ],[
                'name'        => 'Roles - Edit/Update a role',
                'description' => 'Allow to update a role.',
                'slug'        => 'auth.roles.update',
            ],[
                'name'        => 'Roles - Delete a role',
                'description' => 'Allow to delete a role.',
                'slug'        => 'auth.roles.delete',
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
                'slug'        => 'auth.permissions.list',
            ],[
                'name'        => 'Permissions - View a permission',
                'description' => 'Allow to view the permission\'s details.',
                'slug'        => 'auth.permissions.show',
            ],[
                'name'        => 'Permissions - Update a permission',
                'description' => 'Allow to update a permission.',
                'slug'        => 'auth.permissions.update',
            ],
        ];
    }

    /**
     * Get the other permissions seeds for auth module.
     *
     * @return array
     */
    private function getOtherSeeds()
    {
        return [
            [
                'name'        => 'Dashboard - View the dashboard stats',
                'description' => 'Allow to view a auth stats.',
                'slug'        => 'auth.dashboard.stats',
            ]
        ];
    }
}
