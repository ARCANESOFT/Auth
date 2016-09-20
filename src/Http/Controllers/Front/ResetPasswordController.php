<?php namespace Arcanesoft\Auth\Http\Controllers\Front;

use Arcanesoft\Auth\Bases\Controller;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\Request;

/**
 * Class     ResetPasswordController
 *
 * @package  Arcanesoft\Auth\Http\Controllers\Front
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class ResetPasswordController extends Controller
{
    /* ------------------------------------------------------------------------------------------------
     |  Traits
     | ------------------------------------------------------------------------------------------------
     */
    use ResetsPasswords;

    /* ------------------------------------------------------------------------------------------------
     |  Constructor
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /* ------------------------------------------------------------------------------------------------
     |  Main Functions
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Display the password reset view for the given token.
     *
     * If no token is present, display the link request form.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string|null               $token
     *
     * @return \Illuminate\Contracts\View\Factory
     */
    public function showResetForm(Request $request, $token = null)
    {
        return view('auth::public.passwords.reset')->with(
            ['token' => $token, 'email' => $request->get('email')]
        );
    }
}
