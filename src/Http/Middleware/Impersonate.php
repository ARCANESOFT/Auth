<?php namespace Arcanesoft\Auth\Http\Middleware;

use Closure;

/**
 * Class     Impersonate
 *
 * @package  Arcanesoft\Auth\Http\Middleware
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class Impersonate
{
    /* ------------------------------------------------------------------------------------------------
     |  Main Functions
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure                  $next
     *
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $session = $request->session();

        if ($session->has('impersonate')) {
            \Auth::onceUsingId($session->get('impersonate'));
        }

        return $next($request);
    }
}
