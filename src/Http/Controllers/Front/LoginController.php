<?php namespace Arcanesoft\Auth\Http\Controllers\Front;

use Illuminate\Foundation\Auth\AuthenticatesUsers;

/**
 * Class     LoginController
 *
 * @package  Arcanesoft\Auth\Http\Controllers\Front
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class LoginController extends Controller
{
    /* ------------------------------------------------------------------------------------------------
     |  Traits
     | ------------------------------------------------------------------------------------------------
     */
    use AuthenticatesUsers;

    /* ------------------------------------------------------------------------------------------------
     |  Constructor
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('guest', ['except' => 'logout']);

        parent::__construct();
    }

    /* ------------------------------------------------------------------------------------------------
     |  Main Functions
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Show the application's login form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showLoginForm()
    {
        return view('auth::public.login');
    }

    /* ------------------------------------------------------------------------------------------------
     |  Other Functions
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Get the post login redirect path.
     *
     * @return string
     */
    public function redirectTo()
    {
        return '/home';
    }
}
