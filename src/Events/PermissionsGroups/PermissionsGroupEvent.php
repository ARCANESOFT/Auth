<?php

declare(strict_types=1);

namespace Arcanesoft\Auth\Events\PermissionsGroups;

use Arcanesoft\Auth\Models\PermissionsGroup;

/**
 * Class     PermissionsGroupEvent
 *
 * @package  Arcanesoft\Auth\Events\PermissionsGroups
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
abstract class PermissionsGroupEvent
{
    /* -----------------------------------------------------------------
     |  Properties
     | -----------------------------------------------------------------
     */

    /** @var  \Arcanesoft\Auth\Models\PermissionsGroup */
    public $group;

    /* -----------------------------------------------------------------
     |  Constructor
     | -----------------------------------------------------------------
     */

    /**
     * PermissionsGroupEvent constructor.
     *
     * @param  \Arcanesoft\Auth\Models\PermissionsGroup  $group
     */
    public function __construct(PermissionsGroup $group)
    {
        $this->group = $group;
    }
}
