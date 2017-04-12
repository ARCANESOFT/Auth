<?php namespace Arcanesoft\Auth\Http\Controllers\Admin;

use Arcanedev\LaravelApiHelper\Traits\JsonResponses;
use Arcanesoft\Auth\Models\PasswordReset;
use Arcanesoft\Auth\Policies\PasswordResetsPolicy;
use Illuminate\Support\Facades\Log;

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

        PasswordReset::deleteAll();

        return $this->jsonResponseSuccess(
            $this->transNotification('deleted')
        );
    }

    public function clear()
    {
        $this->authorize(PasswordResetsPolicy::PERMISSION_DELETE);

        PasswordReset::deleteExpired();

        return $this->jsonResponseSuccess(
            $this->transNotification('cleared')
        );
    }

    /* -----------------------------------------------------------------
     |  Other Methods
     | -----------------------------------------------------------------
     */
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
        $title   = trans("auth::password-resets.messages.{$action}.title");
        $message = trans("auth::password-resets.messages.{$action}.message", $replace);

        Log::info($message, $context);
        $this->notifySuccess($message, $title);

        return $message;
    }
}
