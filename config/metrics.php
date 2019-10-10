<?php

use Arcanesoft\Auth\Metrics;

return [

    /* -----------------------------------------------------------------
     |  Dashboard
     | -----------------------------------------------------------------
     */

    'dashboard' => [
        'index' => [
            Metrics\Users\TotalUsers::class,
            Metrics\Users\UsersPerDay::class,
        ],
    ],

    /* -----------------------------------------------------------------
     |  Users' Metrics
     | -----------------------------------------------------------------
     */

    'users' => [
        Metrics\Users\TotalUsers::class,
        Metrics\Users\NewUsers::class,
        Metrics\Users\VerifiedEmails::class,
        Metrics\Users\ActivatedUsers::class,
        Metrics\Users\UsersPerDay::class,
    ],

    /* -----------------------------------------------------------------
     |  Roles' Metrics
     | -----------------------------------------------------------------
     */

    'roles' => [
        Metrics\Roles\TotalUsersByRoles::class,
        Metrics\Roles\TotalRoles::class,
    ],

    /* -----------------------------------------------------------------
     |  Password resets' Metrics
     | -----------------------------------------------------------------
     */

    'password-resets' => [
        Metrics\PasswordResets\TotalPasswordResets::class,
        Metrics\PasswordResets\PasswordResetsPerDay::class,
    ],

];
