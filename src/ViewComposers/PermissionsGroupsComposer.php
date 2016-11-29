<?php namespace Arcanesoft\Auth\ViewComposers;

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

        // Permission groups
        //----------------------------------
        $groups = $this->cacheResults('permissions-groups.filters', function () {
            return PermissionsGroup::has('permissions')->get();
        });

        foreach ($groups as $group) {
            /** @var  \Arcanesoft\Auth\Models\PermissionsGroup  $group */
            $filters->put($group->slug, link_to_route('auth::foundation.permissions.group', $group->name, [
                $group->hashed_id
            ]));
        }

        // Custom Permission group
        //----------------------------------
        if (Permission::where('group_id', 0)->count()) {
            $filters->put('custom', link_to_route('auth::foundation.permissions.group', 'Custom', [
                hasher()->encode(0)
            ]));
        }

        $view->with('groupFilters', $filters->toArray()); // TODO: return a collection instead of simple array
    }
}
