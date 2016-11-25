<?php namespace Arcanesoft\Auth\Http\Middleware;

use Arcanesoft\Auth\Helpers\UserImpersonator;
use Auth;
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
        $key     = config('arcanesoft.auth.impersonation.key', 'impersonate');

        if (UserImpersonator::isEnabled() && $session->has($key))
            Auth::onceUsingId($session->get($key));

        return $next($request);
    }
}
