<?php

declare(strict_types=1);

namespace Arcanesoft\Auth\Listeners\Roles;

use Arcanesoft\Auth\Events\Roles\DeletingRole;
use Arcanesoft\Auth\Repositories\RolesRepository;

/**
 * Class     DetachUsers
 *
 * @package  Arcanesoft\Auth\Listeners\Roles
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class DetachUsers
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
     * DetachUsers constructor.
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
        $this->repo->detachAllUsers($event->role);
    }
}
