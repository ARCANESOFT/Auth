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
        ]);
    }
}
