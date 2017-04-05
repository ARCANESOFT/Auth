<?php namespace Arcanesoft\Auth\Http\Controllers\Admin;

use Arcanedev\LaravelApiHelper\Traits\JsonResponses;
use Arcanesoft\Auth\Models\PasswordReset;
use Arcanesoft\Auth\Policies\PasswordResetsPolicy;

/**
 * Class     PasswordResetsController
 *
 * @package  Arcanesoft\Auth\Http\Controllers\Admin
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class PasswordResetsController extends Controller
{
    /* -----------------------------------------------------------------
     |  Traits
     | -----------------------------------------------------------------
     */
    use JsonResponses;

    /* -----------------------------------------------------------------
     |  Properties
     | -----------------------------------------------------------------
     */
    /** @var int */
    protected $perPage = 30;

    /* -----------------------------------------------------------------
     |  Constructor
     | -----------------------------------------------------------------
     */
    /**
     * PasswordResetsController constructor.
     */
    public function __construct()
    {
        parent::__construct();

        $this->setCurrentPage('auth-password-resets');
        $this->addBreadcrumbRoute(trans('auth::password-resets.titles.password-resets'), 'admin::auth.password-resets.index');
    }

    /* -----------------------------------------------------------------
     |  Main Methods
     | -----------------------------------------------------------------
     */
    public function index()
    {
        $this->authorize(PasswordResetsPolicy::PERMISSION_LIST);

        $resets = PasswordReset::with(['user'])
            ->orderBy('created_at', 'desc')
            ->paginate($this->perPage);

        $this->setTitle($title = trans('auth::password-resets.titles.password-resets-list'));
        $this->addBreadcrumb($title);

        return $this->view('admin.password-resets.list', compact('resets'));
    }

    public function delete()
    {
        $this->authorize(PasswordResetsPolicy::PERMISSION_DELETE);

        // TODO: Complete the implementation

        return $this->jsonResponseSuccess('The password reset was deleted!');
    }

    public function clear()
    {
        $this->authorize(PasswordResetsPolicy::PERMISSION_DELETE);

        PasswordReset::getTokenRepository()->deleteExpired();

        return $this->jsonResponseSuccess('All the expired password resets was cleared!');
    }
}
