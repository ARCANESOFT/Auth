<?php namespace Arcanesoft\Auth\Http\Controllers\Admin;

use Arcanesoft\Auth\Http\Requests\Admin\Profile\UpdatePasswordRequest;
use Arcanesoft\Contracts\Auth\Models\User;
use Log;

/**
 * Class     ProfileController
 *
 * @package  Arcanesoft\Auth\Http\Controllers\Admin
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

        $this->addBreadcrumbRoute('Profile', 'admin::auth.profile.index');
        $this->setCurrentPage('auth-profile');
    }

    /* ------------------------------------------------------------------------------------------------
     |  Main Functions
     | ------------------------------------------------------------------------------------------------
     */
    public function index()
    {
        $user = $this->getAuthenticatedUser();

        $this->setTitle("Profile - {$user->full_name}");
        $this->addBreadcrumbRoute($user->full_name, 'admin::auth.profile.index');

        return $this->view('admin.profile.index', compact('user'));
    }

    public function edit()
    {
        // TODO: complete the implementation
    }

    public function update()
    {
        // TODO: complete the implementation
    }

    public function updatePassword(UpdatePasswordRequest $request, User $user)
    {
        $user->update([
            'password' => $request->get('password'),
        ]);

        Log::info($message = 'The password was updated successfully !', $user->toArray());
        $this->notifySuccess($message, 'Password Updated !');

        return redirect()->route('admin::auth.profile.index');
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
