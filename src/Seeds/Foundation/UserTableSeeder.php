<?php namespace Arcanesoft\Auth\Seeds\Foundation;

use Arcanesoft\Auth\Bases\Seeder;
use Arcanesoft\Auth\Models\Role;
use Arcanesoft\Auth\Models\User;

/**
 * Class     UserTableSeeder
 *
 * @package  Arcanesoft\Auth\Seeds\Foundation
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class UserTableSeeder extends Seeder
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
        $this->seedAdminUser();
    }

    /* ------------------------------------------------------------------------------------------------
     |  Other Functions
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Seed the admin account.
     */
    private function seedAdminUser()
    {
        $adminRole = Role::where('slug', 'administrator')->first();
        $adminUser = new User([
            'username'   => 'admin',
            'first_name' => 'Super',
            'last_name'  => 'ADMIN',
            'email'      => env('ADMIN_EMAIL',    'admin@example.com'),
            'password'   => env('ADMIN_PASSWORD', 'password'),
        ]);

        $adminUser->is_admin  = true;
        $adminUser->is_active = true;

        $adminUser->save();
        $adminUser->attachRole($adminRole);
    }
}
