<?php

declare(strict_types=1);

namespace Arcanesoft\Auth\Repositories;

use Arcanesoft\Auth\Auth;

/**
 * Class     PasswordResetsRepository
 *
 * @package  Arcanesoft\Auth\Repositories
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class PasswordResetsRepository extends Repository
{
    /* -----------------------------------------------------------------
     |  Query Methods
     | -----------------------------------------------------------------
     */

    /**
     * Get the permission instance.
     *
     * @return \Arcanesoft\Auth\Models\Permission|mixed
     */
    public static function model()
    {
        return Auth::makeModel('password-resets');
    }
}
