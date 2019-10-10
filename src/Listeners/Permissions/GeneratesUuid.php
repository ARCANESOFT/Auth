<?php

declare(strict_types=1);

namespace Arcanesoft\Auth\Listeners\Permissions;

use Arcanesoft\Auth\Events\Permissions\CreatingPermission;
use Illuminate\Support\Str;

/**
 * Class     GeneratesUuid
 *
 * @package  Arcanesoft\Auth\Listeners\Permissions
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
     * @param  \Arcanesoft\Auth\Events\Permissions\CreatingPermission  $event
     */
    public function handle(CreatingPermission $event)
    {
        $event->permission->forceFill(['uuid' => Str::uuid()]);
    }
}
