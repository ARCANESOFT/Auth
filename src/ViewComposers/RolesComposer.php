<?php namespace Arcanesoft\Auth\ViewComposers;

use Arcanesoft\Contracts\Auth\Models\Role;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;

/**
 * Class     RolesComposer
 *
 * @package  Arcanesoft\Auth\ViewComposers
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class RolesComposer extends ViewComposer
{
    /* -----------------------------------------------------------------
     |  Properties
     | -----------------------------------------------------------------
     */
    /**
     * The role model.
     *
     * @var \Arcanesoft\Contracts\Auth\Models\Role
     */
    private $role;

    /* -----------------------------------------------------------------
     |  Constructor
     | -----------------------------------------------------------------
     */
    /**
     * RolesComposer constructor.
     *
     * @param  \Arcanesoft\Contracts\Auth\Models\Role  $role
     */
    public function __construct(Role $role)
    {
        $this->role = $role;
    }

    /* -----------------------------------------------------------------
     |  Main Methods
     | -----------------------------------------------------------------
     */
    /**
     * Compose the view.
     *
     * @param  \Illuminate\Contracts\View\View  $view
     */
    public function composeFilters(View $view)
    {
        $filters = new Collection;
        $roles   = $this->cacheResults('roles.filters', function () {
            return $this->role->has('users')->get();
        });

        foreach ($roles as $role) {
            /** @var  \Arcanesoft\Auth\Models\Role  $role */
            $filters->put($role->slug, link_to_route('admin::auth.users.roles-filter.index', $role->name, [
                $role->hashed_id
            ]));
        }

        $view->with('rolesFilters', $filters);
    }
}
