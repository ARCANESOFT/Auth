<?php namespace Arcanesoft\Auth\Http\Controllers\Front;

use Arcanesoft\Auth\Bases\Controller;
use Illuminate\Contracts\Auth\Guard;

/**
 * Class     ApiController
 *
 * @package  Arcanesoft\Auth\Http\Controllers\Front
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class ApiController extends Controller
{
    /* ------------------------------------------------------------------------------------------------
     |  Properties
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * @var \Illuminate\Contracts\Auth\Guard
     */
    private $auth;

    /* ------------------------------------------------------------------------------------------------
     |  Constructor
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * ApiController constructor.
     *
     * @param  \Illuminate\Contracts\Auth\Guard  $auth
     */
    public function __construct(Guard $auth)
    {
        parent::__construct();

        $this->auth = $auth;
    }

    /* ------------------------------------------------------------------------------------------------
     |  Main Functions
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Check if the user is authenticated.
     *
     * @return array
     */
    public function check()
    {
        self::onlyAjax();

        if ( ! $this->auth->check()) {
            abort(404, 'Page not found');
        }

        return [
            'success' => true,
            'message' => 'User authenticated.',
        ];
    }
}
