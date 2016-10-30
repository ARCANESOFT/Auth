<?php namespace Arcanesoft\Auth\ViewComposers;

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
    /* ------------------------------------------------------------------------------------------------
     |  Properties
     | ------------------------------------------------------------------------------------------------
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

    /* ------------------------------------------------------------------------------------------------
     |  Other Functions
     | ------------------------------------------------------------------------------------------------
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
        return Cache::remember('cache::' . $name, $this->minutes, $callback);
    }
}
