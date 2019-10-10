<?php

declare(strict_types=1);

namespace Arcanesoft\Auth\Http\Controllers;

use Arcanesoft\Auth\Repositories\UsersRepository;
use Arcanesoft\Foundation\Concerns\HasNotifications;
use Arcanesoft\Foundation\Http\Requests\Profile\{UpdateUserAccountRequest, UpdateUserPasswordRequest};
use Illuminate\Http\Request;
use Arcanesoft\Foundation\Core\Http\Controller;

/**
 * Class     ProfileController
 *
 * @package  Arcanesoft\Auth\Http\Controllers
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class ProfileController extends Controller
{
    /* -----------------------------------------------------------------
     |  Traits
     | -----------------------------------------------------------------
     */

    use HasNotifications;

    /* -----------------------------------------------------------------
     |  Properties
     | -----------------------------------------------------------------
     */

    /**
     * The view namespace.
     *
     * @var string|null
     */
    protected $viewNamespace = 'auth';

    /* -----------------------------------------------------------------
     |  Constructor
     | -----------------------------------------------------------------
     */

    public function __construct()
    {
        parent::__construct();

        $this->addBreadcrumbRoute(__('Profile'), 'admin::auth.profile.index');
    }

    /* -----------------------------------------------------------------
     |  Main Methods
     | -----------------------------------------------------------------
     */

    public function index(Request $request)
    {
        return $this->view('profile.index', [
            'user' => $request->user(),
        ]);
    }

    public function updateAccount(UpdateUserAccountRequest $request, UsersRepository $repo)
    {
        $repo->update(
            $request->user(),
            $request->getValidatedData()
        );

        $this->notifySuccess(
            __('Account Updated'),
            __('Your account has been successfully updated !')
        );

        return redirect()->back();
    }

    public function updatePassword(UpdateUserPasswordRequest $request, UsersRepository $repo)
    {
        $repo->update(
            $request->user(),
            $request->getValidatedData()
        );

        $this->notifySuccess(
            __('Password Updated'),
            __('Your password has been successfully updated !')
        );

        return redirect()->back();
    }
}
