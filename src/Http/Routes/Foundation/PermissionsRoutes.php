<?php namespace Arcanesoft\Auth\Http\Routes\Foundation;

use Arcanedev\Support\Bases\RouteRegister;
use Arcanesoft\Auth\Models\Permission;
use Illuminate\Contracts\Routing\Registrar;

/**
 * Class     PermissionsRoutes
 *
 * @package  Arcanesoft\Auth\Http\Routes\Foundation
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class PermissionsRoutes extends RouteRegister
{
    /* ------------------------------------------------------------------------------------------------
     |  Main Functions
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Map routes.
     *
     * @param  Registrar  $router
     */
    public function map(Registrar $router)
    {
        parent::map($router);

        $this->group([
            'prefix'    => 'permissions',
            'as'        => 'permissions.',
        ], function () {
            $this->get('/', [
                'as'   => 'index', // auth::foundation.permissions.index
                'uses' => 'PermissionsController@index',
            ]);

            $this->get('{permission_id}/show', [
                'as'   => 'show',  // auth::foundation.permissions.show
                'uses' => 'PermissionsController@show',
            ]);
        });

        $router->bind('permission_id', function($hashedId) {
            return Permission::firstHashedOrFail($hashedId);
        });
    }
}
