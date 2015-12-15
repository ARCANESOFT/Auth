<?php namespace Arcanesoft\Auth\Seeds\Foundation;

use Arcanedev\LaravelAuth\Models\Permission;
use Arcanesoft\Auth\Bases\Seeder;
use Arcanesoft\Auth\Models\Role;

/**
 * Class     RoleTableSeeder
 *
 * @package  Arcanesoft\Auth\Seeds\Foundation
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class RoleTableSeeder extends Seeder
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
        $roles = $this->prepareRoles($this->getRoles());

        Role::insert($roles);

        /** @var Role $admin */
        $admin = Role::where('slug', 'administrator')->first();
        $ids   = Permission::all()->lists('id')->toArray();

        $admin->permissions()->sync($ids);
    }

    /* ------------------------------------------------------------------------------------------------
     |  Other Functions
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Get default roles.
     *
     * @return array
     */
    private function getRoles()
    {
        return [
            [
                'name'        => 'Administrator',
                'description' => 'The system administrator role.',
            ],[
                'name'        => 'Member',
                'description' => 'The member role.',
            ]
        ];
    }

    /**
     * Prepare roles to seed.
     *
     * @param  array  $roles
     *
     * @return array
     */
    private function prepareRoles(array $roles)
    {
        foreach ($roles as $key => $role) {
            $roles[$key]['slug']       = str_slug($role['name']);
            $roles[$key]['is_active']  = true;
            $roles[$key]['is_locked']  = true;
            $roles[$key]['created_at'] = \Carbon\Carbon::now();
            $roles[$key]['updated_at'] = \Carbon\Carbon::now();
        }

        return $roles;
    }
}
