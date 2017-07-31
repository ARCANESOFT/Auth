<?php namespace Arcanesoft\Auth\Seeds;

use Arcanedev\Support\Bases\Seeder;
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
    /* -----------------------------------------------------------------
     |  Main Methods
     | -----------------------------------------------------------------
     */

    /**
     * Seed roles.
     *
     * @param  array  $roles
     */
    public function seed(array $roles)
    {
        $roles = $this->prepareRoles($roles);

        Role::query()->insert($roles);

        $this->syncAdminRole();
    }

    /* -----------------------------------------------------------------
     |  Other Methods
     | -----------------------------------------------------------------
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
            $roles[$key]['slug']       = $this->slugify($role['name']);
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

    /**
     * Slugify the value.
     *
     * @param  string  $value
     *
     * @return string
     */
    protected function slugify($value)
    {
        return Str::slug($value, config('arcanesoft.auth.roles.slug-separator', '-'));
    }

    /**
     * Sync the roles.
     *
     * @param  array  $roles
     */
    protected function syncRoles(array $roles)
    {
        /** @var \Illuminate\Database\Eloquent\Collection $permissions */
        $permissions = Permission::all();

        foreach ($roles as $roleSlug => $permissionSlug) {
            /** @var  \Arcanesoft\Auth\Models\Role  $role */
            if ($role = Role::query()->where('slug', $roleSlug)->first()) {
                $filtered = $permissions->filter(function (Permission $permission) use ($permissionSlug) {
                    return Str::startsWith($permission->slug, $permissionSlug);
                });

                $role->permissions()->sync(
                    $filtered->pluck('id')->toArray()
                );
            }
        }
    }
}
