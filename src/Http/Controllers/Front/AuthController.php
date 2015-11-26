<?php namespace Arcanesoft\Auth\Http\Controllers\Front;

use Arcanesoft\Auth\Bases\Controller;
use Arcanesoft\Auth\Http\Requests\Front\RegisterUserRequest;
use Arcanesoft\Auth\Models\User;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Illuminate\Foundation\Auth\ThrottlesLogins;

/**
 * Class     AuthController
 *
 * @package  Arcanesoft\Auth\Http\Controllers\Front
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class AuthController extends Controller
{
    /* ------------------------------------------------------------------------------------------------
     |  Registration & Login Controller Trait
     | ------------------------------------------------------------------------------------------------
     */
    use AuthenticatesAndRegistersUsers, ThrottlesLogins;

    /* ------------------------------------------------------------------------------------------------
     |  Properties
     | ------------------------------------------------------------------------------------------------
     */
    protected $redirectPath        = '/';
    protected $redirectTo          = '/';
    protected $redirectAfterLogout = '/';

    /* ------------------------------------------------------------------------------------------------
     |  Constructor
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Create a new authentication controller instance.
     */
    public function __construct()
    {
        parent::__construct();

        $this->middleware('guest', [
            'except' => ['getLogout', 'getConfirm']
        ]);
    }

    /* ------------------------------------------------------------------------------------------------
     |  Main Functions
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Show the application login form.
     *
     * @return \Illuminate\Http\Response
     */
    public function getLogin()
    {
        return view('auth::public.login');
    }

    /**
     * Show the application registration form.
     *
     * @return \Illuminate\Http\Response
     */
    public function getRegister()
    {
        return view('auth::public.register');
    }

    /**
     * Handle a registration request for the application.
     *
     * @param  RegisterUserRequest  $request
     *
     * @return \Illuminate\Http\Response
     */
    public function postRegister(RegisterUserRequest $request)
    {
        User::createMember($request->all());

        return redirect($this->redirectPath());
    }

    /**
     * Confirm the member account.
     *
     * @param  string  $code
     *
     * @return \Illuminate\Http\Response
     */
    public function getConfirm($code)
    {
        $member = (new User)->confirm($code);

        if ( ! $member->isConfirmed()) {
            return '404';
        }

        return redirect()
            ->route('auth::profile.index')
            ->with('success', 'You\'re account is confirmed !');
    }
}
