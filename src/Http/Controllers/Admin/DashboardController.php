<?php namespace Arcanesoft\Auth\Http\Controllers\Admin;

use Arcanesoft\Auth\Http\Controllers\Admin\Controller;
use Arcanesoft\Auth\Policies\DashboardPolicy;

/**
 * Class     DashboardController
 *
 * @package  Arcanesoft\Auth\Http\Controllers\Foundation
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 *
 * @todo: Adding the authorization checks
 */
class DashboardController extends Controller
{
    /* ------------------------------------------------------------------------------------------------
     |  Constructor
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Instantiate the controller.
     */
    public function __construct()
    {
        parent::__construct();

        $this->setCurrentPage('auth-dashboard');
    }

    /* ------------------------------------------------------------------------------------------------
     |  Main Functions
     | ------------------------------------------------------------------------------------------------
     */
    public function index()
    {
        $this->authorize(DashboardPolicy::PERMISSION_STATS);

        $title = 'Authorization - Dashboard';
        $this->setTitle($title);
        $this->addBreadcrumb('Statistics');

        return $this->view('admin.dashboard');
    }
}
