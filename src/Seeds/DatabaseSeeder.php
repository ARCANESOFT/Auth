<?php namespace Arcanesoft\Auth\Seeds;

/**
 * Class     DatabaseSeeder
 *
 * @package  Arcanesoft\Auth\Seeds
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class DatabaseSeeder extends Seeder
{
    /* -----------------------------------------------------------------
     |  Properties
     | -----------------------------------------------------------------
     */
    /**
     * Seeder collection.
     *
     * @var array
     */
    protected $seeds = [
        Foundation\PermissionTableSeeder::class,
        Foundation\RoleTableSeeder::class,
        Foundation\UserTableSeeder::class,
    ];
}
