<?php namespace Arcanesoft\Auth\Seeds\Foundation;

use Arcanedev\LaravelAuth\Services\UserConfirmator;
use Arcanesoft\Auth\Bases\Seeder;
use Arcanesoft\Auth\Models\Role;
use Arcanesoft\Auth\Models\User;
use Carbon\Carbon;

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
        /** @var  \Arcanesoft\Auth\Models\Role  $adminRole */
        $adminRole = Role::admins()->first();
        $adminUser = new User([
            'username'   => 'admin',
            'first_name' => 'Super',
            'last_name'  => 'ADMIN',
            'email'      => env('ADMIN_EMAIL',    'admin@example.com'),
            'password'   => env('ADMIN_PASSWORD', 'password'),
        ]);

        $adminUser->is_admin  = true;
        $adminUser->is_active = true;

        if (UserConfirmator::isEnabled()) {
            $adminUser->is_confirmed = true;
            $adminUser->confirmed_at = Carbon::now();
        }

        $adminUser->save();

        $adminRole->attachUser($adminUser);
    }
}
