<?php namespace Arcanesoft\Auth\Seeds;

use Arcanedev\Support\Database\Seeder;
use Arcanesoft\Auth\Models\Permission;
use Arcanesoft\Auth\Models\Role;
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
        Role::query()->insert(
            $this->prepareRoles($roles)
        );

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
        $now = now();

        return array_map(function ($role) use ($now) {
            return array_merge($role, [
                'slug'         => $role['slug'] ?? $this->slugify($role['name']),
                'is_locked'    => $role['is_locked'] ?? true,
                'created_at'   => $now,
                'updated_at'   => $now,
                'activated_at' => array_get($role, 'activated_at', $now),
            ]);
        }, $roles);
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
