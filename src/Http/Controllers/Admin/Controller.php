<?php namespace Arcanesoft\Auth\Http\Controllers\Admin;

use Arcanesoft\Core\Bases\FoundationController as BaseController;
use Arcanesoft\Core\Traits\Notifyable;

/**
 * Class     Controller
 *
 * @package  Arcanesoft\Auth\Http\Controllers\Admin
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
abstract class Controller extends BaseController
{
    /* ------------------------------------------------------------------------------------------------
     |  Traits
     | ------------------------------------------------------------------------------------------------
     */
    use Notifyable;

    /* ------------------------------------------------------------------------------------------------
     |  Properties
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * The view namespace.
     *
     * @var string
     */
    protected $viewNamespace = 'auth';

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

        $this->addBreadcrumbRoute('Authorization', 'admin::auth.dashboard');
    }
}
