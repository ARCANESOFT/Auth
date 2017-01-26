<?php namespace Arcanesoft\Auth\Http\Controllers\Front;

use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Validator;

/**
 * Class     RegisterController
 *
 * @package  Arcanesoft\Auth\Http\Controllers\Front
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class RegisterController extends Controller
{
    /* ------------------------------------------------------------------------------------------------
     |  Traits
     | ------------------------------------------------------------------------------------------------
     */
    use RegistersUsers;

    /* ------------------------------------------------------------------------------------------------
     |  Properties
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

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
     * Show the application registration form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showRegistrationForm()
    {
        return view('auth::public.register');
    }

    /**
     * Confirm the member account.
     *
     * @param  string  $code
     *
     * @return \Illuminate\Http\Response
     */
    public function confirm($code)
    {
        $member = (new User)->confirm($code);

        if ( ! $member->isConfirmed()) {
            return '404';
        }

        return redirect()
            ->route('auth::profile.index')
            ->with('success', 'You\'re account is confirmed !');
    }

    /* ------------------------------------------------------------------------------------------------
     |  Other Functions
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Get the post register redirect path.
     *
     * @return string
     */
    public function redirectTo()
    {
        return '/home';
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     *
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'username'   => 'required|max:60',
            'first_name' => 'required|max:30',
            'last_name'  => 'required|max:30',
            'email'      => 'required|email|max:255|unique:users',
            'password'   => 'required|min:6|confirmed',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     *
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        return User::create($data);
    }
}
