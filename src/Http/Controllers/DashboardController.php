<?php

declare(strict_types=1);

namespace Arcanesoft\Auth\Http\Controllers;

/**
 * Class     DashboardController
 *
 * @package  Arcanesoft\Auth\Http\Controllers
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class DashboardController extends Controller
{
    /* -----------------------------------------------------------------
     |  Main Methods
     | -----------------------------------------------------------------
     */

    public function index()
    {
        $this->setCurrentSidebarItem('auth::authorization.dashboard');

        $this->selectMetrics(config('arcanesoft.auth.metrics.dashboard.index', []));

        return $this->view('dashboard');
    }
}
