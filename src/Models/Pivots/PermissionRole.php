<?php

declare(strict_types=1);

namespace Arcanesoft\Auth\Models\Pivots;

use Illuminate\Database\Eloquent\Relations\Pivot;

/**
 * Class     PermissionRole
 *
 * @package  Arcanesoft\Auth\Models\Pivots
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class PermissionRole extends Pivot
{
    /* -----------------------------------------------------------------
     |  Constants
     | -----------------------------------------------------------------
     */

    const UPDATED_AT = null;

    /* -----------------------------------------------------------------
     |  Properties
     | -----------------------------------------------------------------
     */

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'permission_id' => 'integer',
        'role_id'       => 'integer',
    ];
}
