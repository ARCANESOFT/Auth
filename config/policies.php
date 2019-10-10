<?php

/* -----------------------------------------------------------------
 |  Policies
 | -----------------------------------------------------------------
 */

use Arcanesoft\Auth\Policies;

return [

    Policies\DashboardPolicy::class,
    Policies\UsersPolicy::class,
    Policies\RolesPolicy::class,
    Policies\PermissionsPolicy::class,
    Policies\PasswordResetsPolicy::class,

];
