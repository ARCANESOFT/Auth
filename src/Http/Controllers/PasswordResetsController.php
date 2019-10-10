<?php

declare(strict_types=1);

namespace Arcanesoft\Auth\Http\Controllers;

use Arcanesoft\Auth\Models\PasswordReset;
use Arcanesoft\Auth\Policies\PasswordResetsPolicy;
use Arcanesoft\Foundation\Concerns\HasNotifications;

/**
 * Class     PasswordResetsController
 *
 * @package  Arcanesoft\Auth\Http\Controllers
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class PasswordResetsController extends Controller
{
    /* -----------------------------------------------------------------
     |  Traits
     | -----------------------------------------------------------------
     */

    use HasNotifications;

    /* -----------------------------------------------------------------
     |  Constructor
     | -----------------------------------------------------------------
     */

    public function __construct()
    {
        parent::__construct();

        $this->setCurrentSidebarItem('auth::authorization.password-resets');
        $this->addBreadcrumbRoute(__('Password Resets'), 'admin::auth.password-resets.index');
    }

    /* -----------------------------------------------------------------
     |  Main Methods
     | -----------------------------------------------------------------
     */

    public function index()
    {
        $this->authorize(PasswordResetsPolicy::ability('index'));

        return $this->view('password-resets.index');
    }

    public function metrics()
    {
        $this->authorize(PasswordResetsPolicy::ability('metrics'));

        $this->addBreadcrumbRoute(__('Metrics'), 'admin::auth.password-resets.metrics');

        $this->selectMetrics('arcanesoft.auth.metrics.password-resets');

        return $this->view('password-resets.metrics');
    }
}
