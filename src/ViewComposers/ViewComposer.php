<?php namespace Arcanesoft\Auth\ViewComposers;

use Arcanesoft\Auth\Models\Permission;
use Arcanesoft\Auth\Models\Role;
use Arcanesoft\Auth\Models\User;
use Closure;
use Illuminate\Support\Facades\Cache;

/**
 * Class     ViewComposer
 *
 * @package  Arcanesoft\Auth\Bases
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
abstract class ViewComposer
{
    /* -----------------------------------------------------------------
     |  Properties
     | -----------------------------------------------------------------
     */
    /**
     * The View instance.
     *
     * @var \Illuminate\Contracts\View\View
     */
    protected $view;

    /**
     * Caching time.
     *
     * @var int
     */
    protected $minutes = 5;

    /* -----------------------------------------------------------------
     |  Main Methods
     | -----------------------------------------------------------------
     */
    /**
     * Get all cached users.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getCachedUsers()
    {
        return $this->cacheResults('users.all', function() {
            return User::all();
        });
    }

    /**
     * Get all cached roles.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getCachedRoles()
    {
        return $this->cacheResults('roles.all', function() {
            return Role::all();
        });
    }

    /**
     * Get all cached permissions.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    protected function getCachedPermissions()
    {
        return $this->cacheResults('permissions.all', function() {
            return Permission::all();
        });
    }

    /* -----------------------------------------------------------------
     |  Other Methods
     | -----------------------------------------------------------------
     */
    /**
     * Cache the results.
     *
     * @param  string    $name
     * @param  \Closure  $callback
     *
     * @return mixed
     */
    protected function cacheResults($name, Closure $callback)
    {
        return Cache::remember("auth::{$name}", $this->minutes, $callback);
    }
}
