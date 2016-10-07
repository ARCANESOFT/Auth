<?php namespace Arcanesoft\Auth\ViewComposers;

use Arcanesoft\Auth\Bases\ViewComposer;
use Arcanesoft\Contracts\Auth\Models\Role;
use Illuminate\Contracts\View\View;

/**
 * Class     RolesComposer
 *
 * @package  Arcanesoft\Auth\ViewComposers
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class RolesComposer extends ViewComposer
{
    /* ------------------------------------------------------------------------------------------------
     |  Properties
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * The role model.
     *
     * @var \Arcanesoft\Contracts\Auth\Models\Role
     */
    private $role;

    /* ------------------------------------------------------------------------------------------------
     |  Constructor
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * RolesComposer constructor.
     *
     * @param Role $role
     */
    public function __construct(Role $role)
    {
        $this->role = $role;
    }

    /* ------------------------------------------------------------------------------------------------
     |  Main Functions
     | ------------------------------------------------------------------------------------------------
     */
    public function composeFilters(View $view)
    {
        $filters = [];
        $roles   = $this->cacheResults('auth::roles.filters', function () {
            return $this->role->has('users')->get();
        });

        foreach ($roles as $role) {
            /** @var  Role  $role */
            $filters[$role->slug] = link_to_route('auth::foundation.users.roles-filter.index', $role->name, [
                $role->hashed_id
            ]);
        }

        $view->with('rolesFilters', $filters);
    }
}
