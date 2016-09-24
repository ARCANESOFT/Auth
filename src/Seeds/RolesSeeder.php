<?php namespace Arcanesoft\Auth\Seeds;

use Arcanesoft\Auth\Bases\Seeder;
use Arcanesoft\Auth\Models\Permission;
use Arcanesoft\Auth\Models\Role;
use Carbon\Carbon;
use Illuminate\Support\Str;

/**
 * Class     RolesSeeder
 *
 * @package  Arcanesoft\Auth\Seeds
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
abstract class RolesSeeder extends Seeder
{
    /* ------------------------------------------------------------------------------------------------
     |  Main Functions
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Seed roles.
     *
     * @param  array  $roles
     */
    public function seed(array $roles)
    {
        $roles = $this->prepareRoles($roles);

        Role::insert($roles);

        $this->syncAdminRole();
    }

    /* ------------------------------------------------------------------------------------------------
     |  Other Functions
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Prepare roles to seed.
     *
     * @param  array  $roles
     *
     * @return array
     */
    protected function prepareRoles(array $roles)
    {
        $now = Carbon::now();

        foreach ($roles as $key => $role) {
            $roles[$key]['slug']       = Str::slug($role['name'], config('arcanesoft.auth.slug-separator', '.'));
            $roles[$key]['is_active']  = isset($role['is_active']) ? $role['is_active'] : true;
            $roles[$key]['is_locked']  = isset($role['is_locked']) ? $role['is_locked'] : true;
            $roles[$key]['created_at'] = $now;
            $roles[$key]['updated_at'] = $now;
        }

        return $roles;
    }

    /**
     * Sync the admin role with all permissions.
     */
    protected function syncAdminRole()
    {
        /** @var \Arcanesoft\Auth\Models\Role $admin */
        $admin = Role::admin()->first();
        $admin->permissions()->sync(
            Permission::all()->pluck('id')->toArray()
        );
    }
}
