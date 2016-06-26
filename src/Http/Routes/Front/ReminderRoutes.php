<?php namespace Arcanesoft\Auth\Http\Routes\Front;

use Arcanedev\Support\Bases\RouteRegister;
use Illuminate\Contracts\Routing\Registrar;
use Illuminate\Support\Arr;

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
     * @param  \Illuminate\Contracts\Routing\Registrar  $router
     */
    public function map(Registrar $router)
    {
        $configs = config('arcanesoft.auth.authentication.reminder');

        if ( ! Arr::get($configs, 'enabled', false)) return;

        $this->group(Arr::get($configs, 'route.attributes', [
            'prefix'    => 'password',
            'as'        => 'password.',
        ]), function () {
            $this->group([
                'prefix' => 'email',
                'as'     => 'email.',
            ], function () {
                $this->get('/', [
                    'as'    => 'get',  // auth::password.email.get
                    'uses'  => 'PasswordController@getEmail',
                ]);

                $this->post('/', [
                    'as'    => 'post', // auth::password.email.post
                    'uses'  => 'PasswordController@postEmail',
                ]);
            });

            $this->group([
                'prefix' => 'reset',
                'as'     => 'reset.',
            ], function () {
                $this->get('{token}', [
                    'as'    => 'get',  // auth::password.reset.get
                    'uses'  => 'PasswordController@getReset',
                ]);

                $this->get('/', [
                    'as'    => 'post', // auth::password.reset.post
                    'uses'  => 'PasswordController@postReset',
                ]);
            });
        });
    }
}
