<?php namespace Arcanesoft\Auth\Http\Controllers\Admin;

use Arcanedev\LaravelApiHelper\Traits\JsonResponses;
use Arcanesoft\Auth\Http\Requests\Admin\Roles\CreateRoleRequest;
use Arcanesoft\Auth\Http\Requests\Admin\Roles\UpdateRoleRequest;
use Arcanesoft\Auth\Policies\RolesPolicy;
use Arcanesoft\Contracts\Auth\Models\Role;
use Log;

/**
 * Class     RolesController
 *
 * @package  Arcanesoft\Auth\Http\Controllers\Admin
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class RolesController extends Controller
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

    /**
     * The Role model.
     *
     * @var \Arcanesoft\Contracts\Auth\Models\Role
     */
    protected $role;

    /* -----------------------------------------------------------------
     |  Constructor
     | -----------------------------------------------------------------
     */

    /**
     * Instantiate the controller.
     *
     * @param  \Arcanesoft\Contracts\Auth\Models\Role  $role
     */
    public function __construct(Role $role)
    {
        parent::__construct();

        $this->role = $role;

        $this->setCurrentPage('auth-roles');
        $this->addBreadcrumbRoute(trans('auth::roles.titles.roles'), 'admin::auth.roles.index');
    }

    /* -----------------------------------------------------------------
     |  Main Methods
     | -----------------------------------------------------------------
     */

    public function index()
    {
        $this->authorize(RolesPolicy::PERMISSION_LIST);

        $roles = $this->role->with('users', 'permissions')->paginate(30);

        $this->setTitle($title = trans('auth::roles.titles.roles-list'));
        $this->addBreadcrumb($title);

        return $this->view('admin.roles.index', compact('roles'));
    }

    public function create()
    {
        $this->authorize(RolesPolicy::PERMISSION_CREATE);

        $this->setTitle($title = trans('auth::roles.titles.create-role'));
        $this->addBreadcrumb($title);

        return $this->view('admin.roles.create');
    }

    public function store(CreateRoleRequest $request)
    {
        $this->authorize(RolesPolicy::PERMISSION_CREATE);

        $this->role->fill($request->getValidatedData());
        $this->role->save();
        $this->role->permissions()->attach($request->get('permissions'));

        $this->transNotification('created', ['name' => $this->role->name], $this->role->toArray());

        return redirect()->route('admin::auth.roles.index');
    }

    public function show(Role $role)
    {
        $this->authorize(RolesPolicy::PERMISSION_SHOW);

        /** @var  \Arcanesoft\Auth\Models\Role  $role */
        $role->load(['users', 'permissions', 'permissions.group']);

        $this->setTitle($title = trans('auth::roles.titles.role-details'));
        $this->addBreadcrumb($title);

        return $this->view('admin.roles.show', compact('role'));
    }

    public function edit(Role $role)
    {
        $this->authorize(RolesPolicy::PERMISSION_UPDATE);

        /** @var  \Arcanesoft\Auth\Models\Role  $role */
        $role->load(['users', 'permissions']);

        $this->setTitle($title = trans('auth::roles.titles.edit-role'));
        $this->addBreadcrumb($title);

        return $this->view('admin.roles.edit', compact('role'));
    }

    public function update(UpdateRoleRequest $request, Role $role)
    {
        $this->authorize(RolesPolicy::PERMISSION_UPDATE);

        /** @var  \Arcanesoft\Auth\Models\Role  $role */
        $role->fill($request->getValidatedData());
        $role->save();
        $role->permissions()->sync($request->get('permissions'));

        $this->transNotification('updated', ['name' => $role->name], $role->toArray());

        return redirect()
            ->route('admin::auth.roles.show', [$role->hashed_id]);
    }

    public function activate(Role $role)
    {
        $this->authorize(RolesPolicy::PERMISSION_UPDATE);

        try {
            /** @var  \Arcanesoft\Auth\Models\Role  $role */
            ($active = $role->isActive()) ? $role->deactivate() : $role->activate();

            $message = $this->transNotification(
                $active ? 'disabled' : 'enabled',
                ['name' => $role->name],
                $role->toArray()
            );

            return $this->jsonResponseSuccess(compact('message'));
        }
        catch(\Exception $e) {
            return $this->jsonResponseError(['message' => $e->getMessage()], 500);
        }
    }

    public function delete(Role $role)
    {
        /** @var  \Arcanesoft\Auth\Models\Role  $role */
        $this->authorize(RolesPolicy::PERMISSION_DELETE);

        try {
            $role->delete();

            $message = $this->transNotification('deleted', ['name' => $role->name], $role->toArray());

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
        $title   = trans("auth::roles.messages.{$action}.title");
        $message = trans("auth::roles.messages.{$action}.message", $replace);

        Log::info($message, $context);
        $this->notifySuccess($message, $title);

        return $message;
    }
}
