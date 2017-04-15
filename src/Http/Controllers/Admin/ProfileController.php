<?php namespace Arcanesoft\Auth\Http\Controllers\Admin;

use Arcanesoft\Auth\Http\Requests\Admin\Profile\UpdatePasswordRequest;
use Arcanesoft\Contracts\Auth\Models\User;
use Arcanesoft\Core\Http\Controllers\AdminController;
use Arcanesoft\Core\Traits\Notifyable;
use Log;

/**
 * Class     ProfileController
 *
 * @package  Arcanesoft\Auth\Http\Controllers\Admin
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 *
 * @todo: Adding the authorization checks
 */
class ProfileController extends AdminController
{
    /* -----------------------------------------------------------------
     |  Traits
     | -----------------------------------------------------------------
     */

    use Notifyable;

    /* -----------------------------------------------------------------
     |  Properties
     | -----------------------------------------------------------------
     */

    /**
     * The authenticated user.
     *
     * @var \Arcanesoft\Contracts\Auth\Models\User
     */
    protected $user;

    /**
     * The view namespace.
     *
     * @var string
     */
    protected $viewNamespace = 'auth';

    /* -----------------------------------------------------------------
     |  Constructor
     | -----------------------------------------------------------------
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

    /* -----------------------------------------------------------------
     |  Main Methods
     | -----------------------------------------------------------------
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
        $user->update($request->only(['password']));

        $this->transNotification('password-updated', [], $user->toArray());

        return redirect()->route('admin::auth.profile.index');
    }

    /* -----------------------------------------------------------------
     |  Other methods
     | -----------------------------------------------------------------
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

    /**
     * Notify with translation.
     *
     * @param  string  $action
     * @param  array   $replace
     * @param  array   $context
     *
     * @return string
     */
    protected function transNotification($action, array $replace = [], array $context = [])
    {
        $title   = trans("auth::profile.messages.{$action}.title");
        $message = trans("auth::profile.messages.{$action}.message", $replace);

        Log::info($message, $context);
        $this->notifySuccess($message, $title);

        return $message;
    }
}
