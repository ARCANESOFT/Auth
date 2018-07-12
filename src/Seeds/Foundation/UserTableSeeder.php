<?php namespace Arcanesoft\Auth\Seeds\Foundation;

use Arcanedev\LaravelAuth\Services\UserConfirmator;
use Arcanedev\Support\Database\Seeder;
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
    /* -----------------------------------------------------------------
     |  Main Methods
     | -----------------------------------------------------------------
     */

    /**
     * Run the database seeds.
     */
    public function run()
    {
        $this->seedAdminUser();
    }

    /* -----------------------------------------------------------------
     |  Other Methods
     | -----------------------------------------------------------------
     */

    /**
     * Seed the admin account.
     */
    private function seedAdminUser()
    {
        tap(new User($this->getAdminUserAttributes()), function (User $admin) {
            $admin->save();

            /** @var  \Arcanesoft\Auth\Models\Role  $adminRole */
            $adminRole = Role::admin()->first();
            $adminRole->attachUser($admin);
        });
    }

    /**
     * Get the admin user's attributes.
     *
     * @return array
     */
    private function getAdminUserAttributes()
    {
        $now        = Carbon::now();
        $attributes = [
            'username'     => 'admin',
            'first_name'   => 'Super',
            'last_name'    => 'ADMIN',
            'email'        => env('ADMIN_EMAIL',    'admin@example.com'),
            'password'     => env('ADMIN_PASSWORD', 'password'),
            'is_admin'     => true,
            'activated_at' => $now,
        ];

        if (UserConfirmator::isEnabled())
            $attributes['confirmed_at'] = $now;

        return $attributes;
    }
}
