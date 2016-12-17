<?php namespace Arcanesoft\Auth\Http\Controllers\Admin;

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
    /* ------------------------------------------------------------------------------------------------
     |  Properties
     | ------------------------------------------------------------------------------------------------
     */
    /** @var int */
    protected $perPage = 30;

    /* ------------------------------------------------------------------------------------------------
     |  Constructor
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * PasswordResetsController constructor.
     */
    public function __construct()
    {
        parent::__construct();

        $this->setCurrentPage('auth-password-resets');
        $this->addBreadcrumbRoute('Password Resets', 'admin::auth.password-resets.index');
    }

    /* ------------------------------------------------------------------------------------------------
     |  Main Functions
     | ------------------------------------------------------------------------------------------------
     */
    public function index()
    {
        $this->authorize(PasswordResetsPolicy::PERMISSION_LIST);

        $resets = PasswordReset::with(['user'])
            ->orderBy('created_at', 'desc')
            ->paginate($this->perPage);

        $this->setTitle($title = 'List of password resets');
        $this->addBreadcrumb($title);

        return $this->view('admin.password-resets.list', compact('resets'));
    }

    public function delete()
    {
        parent::onlyAjax();

        $this->authorize(PasswordResetsPolicy::PERMISSION_DELETE);

        return response()->json([]);
    }

    public function clear()
    {
        parent::onlyAjax();

        $this->authorize(PasswordResetsPolicy::PERMISSION_DELETE);

        PasswordReset::getTokenRepository()->deleteExpired();

        return response()->json(['status' => 'success']);
    }
}
