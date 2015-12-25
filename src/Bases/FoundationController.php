<?php namespace Arcanesoft\Auth\Bases;

use Arcanesoft\Core\Bases\FoundationController as Controller;
use Arcanesoft\Core\Traits\Notifyable;

/**
 * Class     FoundationController
 *
 * @package  Arcanesoft\Auth\Bases
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class FoundationController extends Controller
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
