<?php namespace Arcanesoft\Auth\Http\Controllers\Admin;

use Arcanedev\LaravelApiHelper\Traits\JsonResponses;
use Arcanesoft\Auth\Policies\PermissionsPolicy;
use Arcanesoft\Contracts\Auth\Models\Permission;
use Arcanesoft\Contracts\Auth\Models\PermissionsGroup;
use Arcanesoft\Contracts\Auth\Models\Role;
use Log;

/**
 * Class     PermissionsController
 *
 * @package  Arcanesoft\Auth\Http\Controllers\Admin
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class PermissionsController extends Controller
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

    /** @var  \Arcanesoft\Contracts\Auth\Models\Permission  */
    protected $permission;

    /** @var int */
    protected $perPage = 30;

    /* -----------------------------------------------------------------
     |  Constructor
     | -----------------------------------------------------------------
     */

    /**
     * Instantiate the controller.
     *
     * @param  \Arcanesoft\Contracts\Auth\Models\Permission  $permission
     */
    public function __construct(Permission $permission)
    {
        parent::__construct();

        $this->permission = $permission;

        $this->setCurrentPage('auth-permissions');
        $this->addBreadcrumbRoute(trans('auth::permissions.titles.permissions'), 'admin::auth.permissions.index');
    }

    /* -----------------------------------------------------------------
     |  Main Methods
     | -----------------------------------------------------------------
     */

    public function index()
    {
        $this->authorize(PermissionsPolicy::PERMISSION_LIST);

        $permissions = $this->permission->with('group', 'roles')
            ->orderBy('group_id')
            ->paginate($this->perPage);

        $this->setTitle($title = trans('auth::permissions.titles.permissions-list'));
        $this->addBreadcrumb($title);

        return $this->view('admin.permissions.index', compact('permissions'));
    }

    public function group(PermissionsGroup $group)
    {
        $this->authorize(PermissionsPolicy::PERMISSION_LIST);

        $groupId = $group->id ? $group->id : 0;

        $permissions = $this->permission->where('group_id', $groupId)
            ->with('group', 'roles')
            ->paginate($this->perPage);

        $this->addBreadcrumbRoute(trans('auth::permissions.titles.permissions-list'), 'admin::auth.permissions.index');

        $groupName = $groupId == 0 ? trans('auth::permission-groups.custom') : $group->name;
        $this->setTitle($title = trans('auth::permissions.titles.permissions-list')." - $groupName");
        $this->addBreadcrumb($groupName);

        return $this->view('admin.permissions.index', compact('permissions'));
    }

    public function show(Permission $permission)
    {
        $this->authorize(PermissionsPolicy::PERMISSION_SHOW);

        $permission->load(['roles', 'roles.users']);

        $this->setTitle($title = 'Permission details');
        $this->addBreadcrumb($title);

        return $this->view('admin.permissions.show', compact('permission'));
    }

    public function detachRole(Permission $permission, Role $role)
    {
        $this->authorize(PermissionsPolicy::PERMISSION_UPDATE);

        try {
            $permission->detachRole($role, false);

            $message = $this->transNotification(
                'detached',
                ['role' => $role->name,      'permission' => $permission->name],
                ['role' => $role->toArray(), 'permissions' => $permission->toArray()]
            );

            return $this->jsonResponseSuccess(compact('message'));
        }
        catch(\Exception $e) {
            return $this->jsonResponseError(['message' => $e->getMessage()], 500);
        }
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
        $title   = trans("auth::permissions.messages.{$action}.title");
        $message = trans("auth::permissions.messages.{$action}.message", $replace);

        Log::info($message, $context);
        $this->notifySuccess($message, $title);

        return $message;
    }
}
