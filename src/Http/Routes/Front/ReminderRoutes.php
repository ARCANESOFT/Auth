<?php namespace Arcanesoft\Auth\Http\Routes\Front;

use Arcanedev\Support\Bases\RouteRegister;
use Illuminate\Contracts\Routing\Registrar;

/**
 * Class     ReminderRoutes
 *
 * @package  Arcanesoft\Auth\Http\Routes\Front
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class ReminderRoutes extends RouteRegister
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
            'prefix'    => 'password',
            'as'        => 'password.'
        ], function () {
            $this->get('email', [
                'as'    => 'email.get',
                'uses'  => 'PasswordController@getEmail',
            ]);

            $this->post('email', [
                'as'    => 'email.post',
                'uses'  => 'PasswordController@postEmail',
            ]);

            $this->get('reset/{token}', [
                'as'    => 'reset.get',
                'uses'  => 'PasswordController@getReset',
            ]);

            $this->get('reset', [
                'as'    => 'reset.post',
                'uses'  => 'PasswordController@postReset',
            ]);
        });
    }
}
