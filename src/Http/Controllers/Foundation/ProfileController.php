<?php namespace Arcanesoft\Auth\Http\Controllers\Foundation;

use Arcanesoft\Auth\Bases\FoundationController;

/**
 * Class     ProfileController
 *
 * @package  Arcanesoft\Auth\Http\Controllers\Foundation
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 *
 * @todo: Adding the authorization checks
 */
class ProfileController extends FoundationController
{
    /* ------------------------------------------------------------------------------------------------
     |  Main Functions
     | ------------------------------------------------------------------------------------------------
     */
    public function index()
    {
        $this->setCurrentPage('auth-profile');
        $this->addBreadcrumbRoute('Profile', 'auth::foundation.profile.index');

        return $this->view('foundation.profile.index');
    }
}
