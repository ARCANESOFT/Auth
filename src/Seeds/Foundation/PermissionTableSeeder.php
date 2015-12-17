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
        $this->seed(array_merge(
            $this->getUsersSeeds(),
            $this->getRolesSeeds(),
            $this->getPermissionsSeeds()
        ));
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
                'name'        => 'Auth - List all users',
                'description' => 'Allow to list all users.',
                'slug'        => 'auth.users.list',
            ],[
                'name'        => 'Auth - View a user',
                'description' => "Allow to view a user's details.",
                'slug'        => 'auth.users.show',
            ],[
                'name'        => 'Auth - Add/Create a user',
                'description' => 'Allow to create a new user.',
                'slug'        => 'auth.users.create',
            ],[
                'name'        => 'Auth - Edit/Update a user',
                'description' => 'Allow to update a user.',
                'slug'        => 'auth.users.update',
            ],[
                'name'        => 'Auth - Delete a user',
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
                'name'        => 'Auth - List all roles',
                'description' => 'Allow to list all roles.',
                'slug'        => 'auth.roles.list',
            ],[
                'name'        => 'Auth - View a role',
                'description' => "Allow to view the role's details.",
                'slug'        => 'auth.roles.show',
            ],[
                'name'        => 'Auth - Add/Create a role',
                'description' => 'Allow to create a new role.',
                'slug'        => 'auth.roles.create',
            ],[
                'name'        => 'Auth - Edit/Update a role',
                'description' => 'Allow to update a role.',
                'slug'        => 'auth.roles.update',
            ],[
                'name'        => 'Auth - Delete a role',
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
                'name'        => 'Auth - List all permissions',
                'description' => 'Allow to list all permissions.',
                'slug'        => 'auth.permissions.list',
            ],
        ];
    }
}
