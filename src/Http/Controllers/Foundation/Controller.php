<?php namespace Arcanesoft\Auth\Http\Controllers\Foundation;

use Arcanesoft\Core\Bases\FoundationController as BaseController;
use Arcanesoft\Core\Traits\Notifyable;

/**
 * Class     Controller
 *
 * @package  Arcanesoft\Auth\Http\Controllers\Foundation
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

        $this->addBreadcrumbRoute('Authorization', 'auth::foundation.dashboard');
    }
}
