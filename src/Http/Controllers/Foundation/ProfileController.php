<?php namespace Arcanesoft\Auth\Http\Controllers\Foundation;

use Arcanesoft\Auth\Http\Requests\Backend\Profile\UpdatePasswordRequest;
use Arcanesoft\Contracts\Auth\Models\User;
use Log;

/**
 * Class     ProfileController
 *
 * @package  Arcanesoft\Auth\Http\Controllers\Foundation
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 *
 * @todo: Adding the authorization checks
 */
class ProfileController extends Controller
{
    /* ------------------------------------------------------------------------------------------------
     |  Properties
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * The authenticated user.
     *
     * @var \Arcanesoft\Contracts\Auth\Models\User
     */
    protected $user;

    /* ------------------------------------------------------------------------------------------------
     |  Constructor
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * ProfileController constructor.
     */
    public function __construct()
    {
        parent::__construct();

        $this->setCurrentPage('auth-profile');
    }

    /* ------------------------------------------------------------------------------------------------
     |  Main Functions
     | ------------------------------------------------------------------------------------------------
     */
    public function index()
    {
        $user = $this->getAuthenticatedUser();

        $this->setTitle($title = 'Profile - ' . $user->full_name);
        $this->addBreadcrumbRoute($title, 'auth::foundation.profile.index');

        return $this->view('foundation.profile.index', compact('user'));
    }

    public function updatePassword(UpdatePasswordRequest $request, User $user)
    {
        $user->password = $request->get('password');
        $user->save();

        $message = 'The password was updated successfully !';
        Log::info($message, $user->toArray());
        $this->notifySuccess($message, 'Password Updated !');

        return redirect()->route('auth::foundation.profile.index');
    }

    /* ------------------------------------------------------------------------------------------------
     |  Other Functions
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Get the authenticated user.
     *
     * @return \Arcanesoft\Contracts\Auth\Models\User
     */
    private function getAuthenticatedUser()
    {
        return auth()->user();
    }
}
