<?php namespace Arcanesoft\Auth\ViewComposers;

use Arcanesoft\Auth\Models\Permission;
use Arcanesoft\Auth\Models\PermissionsGroup;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;

/**
 * Class     PermissionGroupsFilterComposer
 *
 * @package  Arcanesoft\Auth\ViewComposers
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class PermissionGroupsFilterComposer extends ViewComposer
{
    /* ------------------------------------------------------------------------------------------------
     |  Constant
     | ------------------------------------------------------------------------------------------------
     */
    const VIEW = 'auth::admin._composers.permission-groups-filter';

    /* ------------------------------------------------------------------------------------------------
     |  Main Functions
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Compose the view.
     *
     * @param  \Illuminate\Contracts\View\View  $view
     */
    public function compose(View $view)
    {
        $view->with('permissionGroupsFilters', $this->getFilters());
    }

    /* ------------------------------------------------------------------------------------------------
     |  Other Functions
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Get the groups filters data.
     *
     * @return \Illuminate\Support\Collection
     */
    private function getFilters()
    {
        $filters = new Collection;

        foreach ($this->getCachedPermissionGroups() as $group) {
            /** @var  \Arcanesoft\Auth\Models\PermissionsGroup  $group */
            $filters->push([
                'name'   => $group->name,
                'params' => [$group->hashed_id],
            ]);
        }

        // Custom Permission group
        //----------------------------------
        if (Permission::where('group_id', 0)->count()) {
            $filters->push([
                'name'   => 'Custom',
                'params' => [hasher()->encode(0)],
            ]);
        }

        return $filters;
    }

    /**
     * Get the cached permission groups.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    private function getCachedPermissionGroups()
    {
        return $this->cacheResults('permissions-groups.filters', function () {
            return PermissionsGroup::has('permissions')->get();
        });
    }
}
