<?php namespace Arcanesoft\Auth\Seeds\Foundation;

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
        $this->seed([
            [
                'name'        => 'Administrator',
                'description' => 'The system administrator role.',
                'is_active'   => true,
                'is_locked'   => true,
            ],[
                'name'        => 'Member',
                'description' => 'The member role.',
                'is_active'   => true,
                'is_locked'   => true,
            ]
        ]);
    }

    /* ------------------------------------------------------------------------------------------------
     |  Other Functions
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Seed roles.
     *
     * @param  array  $roles
     */
    protected function seed(array $roles)
    {
        foreach ($roles as $data) {
            $this->createRole($data);
        }
    }

    /**
     * Create a role.
     *
     * @param  array  $data
     *
     * @return bool
     */
    protected function createRole(array $data)
    {
        $role = new Role($data);

        $role->is_active = $data['is_active'];
        $role->is_locked = $data['is_locked'];

        return $role->save();
    }
}
