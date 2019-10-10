<?php

declare(strict_types=1);

namespace Arcanesoft\Auth\Http\Transformers;

use Arcanesoft\Auth\Models\Permission;
use Arcanesoft\Foundation\Helpers\UI\Actions\LinkAction;

/**
 * Class     PermissionTransformer
 *
 * @package  Arcanesoft\Auth\Http\Transformers
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class PermissionTransformer extends AbstractTransformer
{
    /* -----------------------------------------------------------------
     |  Main Methods
     | -----------------------------------------------------------------
     */

    /**
     * Transform the users for datatable.
     *
     * @param  \Arcanesoft\Auth\Models\Permission  $permission
     *
     * @return array
     */
    public function transform(Permission $permission)
    {
        return [
            'group_id'    => $permission->group->name,
            'category'    => $permission->category,
            'name'        => $permission->name,
            'description' => '<small>'.$permission->description.'</small>',
            'roles_count' => \arcanesoft\ui\count_pill($permission->roles->count())->toHtml(),
            'actions'     => static::renderActions([
                LinkAction::action('show', route('admin::auth.permissions.show', [$permission]), false)->size('sm'),
            ]),
        ];
    }
}
