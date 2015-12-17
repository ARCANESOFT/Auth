<?php namespace Arcanesoft\Auth\Seeds;

use Arcanesoft\Auth\Bases\Seeder;
use Arcanesoft\Auth\Models\Permission;
use Carbon\Carbon;

/**
 * Class     PermissionsSeeder
 *
 * @package  Arcanesoft\Auth\Seeds
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
abstract class PermissionsSeeder extends Seeder
{
    /* ------------------------------------------------------------------------------------------------
     |  Main Functions
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Seed permissions.
     *
     * @param  array  $permissions
     */
    public function seed(array $permissions)
    {
        $seeds = $this->prepareSeeds($permissions);

        Permission::insert($seeds);
    }

    /* ------------------------------------------------------------------------------------------------
     |  Other Functions
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * @param array $seeds
     *
     * @return array
     */
    protected function prepareSeeds(array $seeds)
    {
        $now   = Carbon::now();

        foreach ($seeds as $key => $permission) {
            $seeds[$key]['created_at'] = $now;
            $seeds[$key]['updated_at'] = $now;
        }

        return $seeds;
    }
}
