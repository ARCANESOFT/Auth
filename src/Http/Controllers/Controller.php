<?php

declare(strict_types=1);

namespace Arcanesoft\Auth\Http\Controllers;

use Arcanesoft\Foundation\Core\Http\Controller as BaseController;

/**
 * Class     Controller
 *
 * @package  Arcanesoft\Auth\Http\Controllers
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
abstract class Controller extends BaseController
{
    /* -----------------------------------------------------------------
     |  Properties
     | -----------------------------------------------------------------
     */

    /**
     * The view namespace.
     *
     * @var string|null
     */
    protected $viewNamespace = 'auth';

    /* -----------------------------------------------------------------
     |  Constructor
     | -----------------------------------------------------------------
     */

    /**
     * Controller constructor.
     */
    public function __construct()
    {
        parent::__construct();

        $this->addBreadcrumbRoute(__('Authorization'), 'admin::auth.index');
    }
}
