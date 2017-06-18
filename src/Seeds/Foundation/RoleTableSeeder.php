<?php namespace Arcanesoft\Auth\Seeds\Foundation;

use Arcanesoft\Auth\Seeds\RolesSeeder;

/**
 * Class     RoleTableSeeder
 *
 * @package  Arcanesoft\Auth\Seeds\Foundation
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class RoleTableSeeder extends RolesSeeder
{
    /* -----------------------------------------------------------------
     |  Main Methods
     | -----------------------------------------------------------------
     */

    /**
     * Run the database seeds.
     */
    public function run()
    {
        $this->seed([
            [
                'name'        => 'Administrator',
                'description' => 'The system administrator role.',
                'is_locked'   => true,
            ],
            [
                'name'        => 'Moderator',
                'description' => 'The system moderator role.',
                'is_locked'   => true,
            ],
            [
                'name'        => 'Member',
                'description' => 'The member role.',
                'is_locked'   => true,
            ],
            [
                'name'        => 'Auth Moderator',
                'description' => 'The auth moderator role.',
                'is_locked'   => true,
            ],
        ]);

        $this->syncRoles([
            'auth-moderator' => 'auth.',
        ]);
    }
}
