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
            ],
            [
                'name'        => 'Moderator',
                'description' => 'The system moderator role.',
            ],
            [
                'name'        => 'Member',
                'description' => 'The member role.',
            ],
            [
                'name'        => 'Auth Moderator',
                'description' => 'The auth moderator role.',
            ],
        ]);

        $this->syncRoles([
            'auth-moderator' => 'auth.',
        ]);
    }
}
