<?php

declare(strict_types=1);

namespace Arcanesoft\Auth\Listeners\Users;

use Arcanesoft\Auth\Events\Users\CreatingUser;
use Illuminate\Support\Str;

/**
 * Class     GeneratesUuid
 *
 * @package  Arcanesoft\Auth\Listeners\Users
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
     * @param  \Arcanesoft\Auth\Events\Users\CreatingUser  $event
     */
    public function handle(CreatingUser $event)
    {
        $event->user->forceFill(['uuid' => Str::uuid()]);
    }
}
