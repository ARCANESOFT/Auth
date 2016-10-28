<?php namespace Arcanesoft\Auth\ViewComposers;

use Arcanesoft\Auth\Bases\ViewComposer;
use Arcanesoft\Contracts\Auth\Models\Permission;
use Arcanesoft\Contracts\Auth\Models\PermissionsGroup;
use Illuminate\Contracts\View\View;

/**
 * Class     PermissionsGroupsComposer
 *
 * @package  Arcanesoft\Auth\ViewComposers
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class PermissionsGroupsComposer extends ViewComposer
{
    /* ------------------------------------------------------------------------------------------------
     |  Properties
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * The permissions group model.
     *
     * @var  \Arcanesoft\Contracts\Auth\Models\PermissionsGroup
     */
    protected $permissionsGroup;

    /**
     * The permission model.
     *
     * @var  \Arcanesoft\Contracts\Auth\Models\Permission
     */
    protected $permission;

    /* ------------------------------------------------------------------------------------------------
     |  Constructor
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * PermissionsGroupsComposer constructor.
     *
     * @param  \Arcanesoft\Contracts\Auth\Models\PermissionsGroup  $permissionsGroup
     * @param  \Arcanesoft\Contracts\Auth\Models\Permission        $permission
     */
    public function __construct(PermissionsGroup $permissionsGroup, Permission $permission)
    {
        $this->permissionsGroup = $permissionsGroup;
        $this->permission       = $permission;
    }

    /* ------------------------------------------------------------------------------------------------
     |  Main Functions
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Compose the view.
     *
     * @param  \Illuminate\Contracts\View\View  $view
     */
    public function composeFilters(View $view)
    {
        $filters = collect();

        // All Permission group
        //----------------------------------
        $filters->put('all', link_to_route('auth::foundation.permissions.index', 'All'));

        // Permission groups
        //----------------------------------
        $groups = $this->cacheResults('permissions-groups.filters', function () {
            return $this->permissionsGroup->has('permissions')->get();
        });
        foreach ($groups as $group) {
            /** @var  PermissionsGroup  $group */
            $filters->put($group->slug, link_to_route('auth::foundation.permissions.group', $group->name, [
                $group->hashed_id
            ]));
        }

        // Custom Permission group
        //----------------------------------
        if ($this->permission->where('group_id', 0)->count()) {
            $filters->put('custom', link_to_route('auth::foundation.permissions.group', 'Custom', [
                hasher()->encode(0)
            ]));
        }

        $view->with('groupFilters', $filters->toArray());
    }
}
