<?php namespace Arcanesoft\Auth\Http\Controllers\Admin;

use Arcanesoft\Auth\Policies\DashboardPolicy;

/**
 * Class     DashboardController
 *
 * @package  Arcanesoft\Auth\Http\Controllers\Foundation
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class DashboardController extends Controller
{
    /* -----------------------------------------------------------------
     |  Constructor
     | -----------------------------------------------------------------
     */
    /**
     * Instantiate the controller.
     */
    public function __construct()
    {
        parent::__construct();

        $this->setCurrentPage('auth-dashboard');
    }

    /* -----------------------------------------------------------------
     |  Main Methods
     | -----------------------------------------------------------------
     */
    public function index()
    {
        $this->authorize(DashboardPolicy::PERMISSION_STATS);

        $this->setTitle($title = trans('auth::dashboard.titles.statistics'));
        $this->addBreadcrumb($title);

        return $this->view('admin.dashboard');
    }
}
