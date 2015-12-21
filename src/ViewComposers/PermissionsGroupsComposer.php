<?php namespace Arcanesoft\Auth\ViewComposers;

use Arcanesoft\Auth\Bases\ViewComposer;
use Arcanesoft\Auth\Models\PermissionsGroup;
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
     * @var  \Arcanesoft\Auth\Models\PermissionsGroup
     */
    protected $permissionsGroup;

    /* ------------------------------------------------------------------------------------------------
     |  Constructor
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * PermissionsGroupsComposer constructor.
     *
     * @param  \Arcanesoft\Auth\Models\PermissionsGroup  $permissionsGroup
     */
    public function __construct(PermissionsGroup $permissionsGroup)
    {
        $this->permissionsGroup = $permissionsGroup;
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
        $filters   = [];
        $groups    = $this->cacheResults('auth-permissions-groups', function () {
            return $this->permissionsGroup->all();
        });

        $filters[] = link_to_route('auth::foundation.permissions.index', 'All');
        foreach ($groups as $group) {
            /** @var  PermissionsGroup  $group */
            $filters[] = link_to_route('auth::foundation.permissions.group', $group->name, [
                $group->hashed_id
            ]);
        }
        $filters[] = link_to_route('auth::foundation.permissions.group', 'Custom', [
            hasher()->encode(0)
        ]);

        $view->with('groupFilters', $filters);
    }
}
