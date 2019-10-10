<?php

declare(strict_types=1);

namespace Arcanesoft\Auth\Listeners\Roles;

use Arcanesoft\Auth\Events\Roles\DeletingRole;
use Arcanesoft\Auth\Repositories\RolesRepository;

/**
 * Class     DetachingPermissions
 *
 * @package  Arcanesoft\Auth\Listeners\Roles
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class DetachPermissions
{
    /* -----------------------------------------------------------------
     |  Properties
     | -----------------------------------------------------------------
     */

    /** @var  \Arcanesoft\Auth\Repositories\RolesRepository */
    protected $repo;

    /* -----------------------------------------------------------------
     |  Constructor
     | -----------------------------------------------------------------
     */

    /**
     * DetachPermissions constructor.
     *
     * @param  \Arcanesoft\Auth\Repositories\RolesRepository  $repo
     */
    public function __construct(RolesRepository $repo)
    {
        $this->repo = $repo;
    }

    /* -----------------------------------------------------------------
     |  Main Methods
     | -----------------------------------------------------------------
     */

    /**
     * Handle the event.
     *
     * @param  \Arcanesoft\Auth\Events\Roles\DeletingRole  $event
     */
    public function handle(DeletingRole $event)
    {
        $this->repo->detachAllPermissions($event->role);
    }
}
