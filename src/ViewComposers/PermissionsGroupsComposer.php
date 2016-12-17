<?php namespace Arcanesoft\Auth\ViewComposers;

use Arcanesoft\Auth\Models\Permission;
use Arcanesoft\Auth\Models\PermissionsGroup;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;

/**
 * Class     PermissionsGroupsComposer
 *
 * @package  Arcanesoft\Auth\ViewComposers
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class PermissionsGroupsComposer extends ViewComposer
{
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
        $filters = new Collection;

        // Permission groups
        //----------------------------------
        $groups = $this->cacheResults('permissions-groups.filters', function () {
            return PermissionsGroup::has('permissions')->get();
        });

        foreach ($groups as $group) {
            /** @var  \Arcanesoft\Auth\Models\PermissionsGroup  $group */
            $filters->put($group->slug, link_to_route('admin::auth.permissions.group', $group->name, [$group->hashed_id]));
        }

        // Custom Permission group
        //----------------------------------
        if (Permission::where('group_id', 0)->count()) {
            $filters->put('custom', link_to_route('admin::auth.permissions.group', 'Custom', [hasher()->encode(0)]));
        }

        $view->with('groupFilters', $filters);
    }
}
