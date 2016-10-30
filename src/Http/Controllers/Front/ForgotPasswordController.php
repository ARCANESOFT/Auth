<?php namespace Arcanesoft\Auth\Http\Controllers\Front;

use Illuminate\Foundation\Auth\SendsPasswordResetEmails;

/**
 * Class     ForgotPasswordController
 *
 * @package  Arcanesoft\Auth\Http\Controllers\Front
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class ForgotPasswordController extends Controller
{
    /* ------------------------------------------------------------------------------------------------
     |  Traits
     | ------------------------------------------------------------------------------------------------
     */
    use SendsPasswordResetEmails;

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

        parent::__construct();
    }

    /* ------------------------------------------------------------------------------------------------
     |  Main Functions
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Display the form to request a password reset link.
     *
     * @return \Illuminate\Http\Response
     */
    public function showLinkRequestForm()
    {
        return view('auth::public.passwords.email');
    }
}
