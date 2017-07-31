<?php namespace Arcanesoft\Auth\Seeds;

use Arcanedev\Support\Bases\Seeder;
use Arcanesoft\Auth\Models\Permission;
use Arcanesoft\Auth\Models\PermissionsGroup;

/**
 * Class     PermissionsSeeder
 *
 * @package  Arcanesoft\Auth\Seeds
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
abstract class PermissionsSeeder extends Seeder
{
    /* -----------------------------------------------------------------
     |  Main Methods
     | -----------------------------------------------------------------
     */

    /**
     * Seed permissions.
     *
     * @param  array  $seeds
     */
    public function seed(array $seeds)
    {
        foreach ($seeds as $seed) {
            /** @var  \Arcanesoft\Auth\Models\PermissionsGroup  $group */
            $group       = PermissionsGroup::create($seed['group']);
            $permissions = array_map(function ($permission) {
                return new Permission($permission);
            }, $seed['permissions']);

            $group->permissions()->saveMany($permissions);
        }
    }
}
