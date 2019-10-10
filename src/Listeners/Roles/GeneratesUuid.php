<?php

declare(strict_types=1);

namespace Arcanesoft\Auth\Listeners\Roles;

use Arcanesoft\Auth\Events\Roles\CreatingRole;
use Illuminate\Support\Str;

/**
 * Class     GeneratesUuid
 *
 * @package  Arcanesoft\Auth\Listeners\Roles
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class GeneratesUuid
{
    /* -----------------------------------------------------------------
     |  Main Methods
     | -----------------------------------------------------------------
     */

    /**
     * Handle the event.
     *
     * @param  \Arcanesoft\Auth\Events\Roles\CreatingRole  $event
     */
    public function handle(CreatingRole $event)
    {
        $event->role->forceFill(['uuid' => Str::uuid()]);
    }
}
