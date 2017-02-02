<?php namespace Arcanesoft\Auth\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Guard;

/**
 * Class     VerifyAdministrator
 *
 * @package  Arcanesoft\Auth\Http\Middleware
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 *
 * @todo: Replace this middleware by core admin middleware ?
 */
class VerifyAdministrator
{
    /* ------------------------------------------------------------------------------------------------
     |  Properties
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * The Guard implementation.
     *
     * @var Guard
     */
    protected $auth;

    /* ------------------------------------------------------------------------------------------------
     |  Constructor
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Create a new filter instance.
     *
     * @param  Guard  $auth
     */
    public function __construct(Guard $auth)
    {
        $this->auth = $auth;
    }

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
        if ($this->auth->check()) {
            /** @var \Arcanedev\LaravelAuth\Models\User $user */
            $user = $this->auth->user();

            if ($user->isAdmin()) return $next($request);
        }

        return response('Unauthorized.', 401);
    }
}
