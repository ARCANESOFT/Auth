<?php

declare(strict_types=1);

namespace Arcanesoft\Auth\Http\Transformers;

use Arcanesoft\Auth\Models\Role;
use Arcanesoft\Auth\Policies\RolesPolicy;
use Arcanesoft\Foundation\Helpers\UI\Actions\{ButtonAction, LinkAction};

/**
 * Class     RoleTransformer
 *
 * @package  Arcanesoft\Auth\Transformers
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class RoleTransformer extends AbstractTransformer
{
    /* -----------------------------------------------------------------
     |  Main Methods
     | -----------------------------------------------------------------
     */

    /**
     * Transform the roles for the datatable.
     *
     * @param  \Arcanesoft\Auth\Models\Role  $role
     *
     * @return array
     */
    public function transform(Role $role): array
    {
        $actions = static::getActions($role);

        return [
            'name'        => $role->name,
            'description' => $role->description,
            'users_count' => \arcanesoft\ui\count_pill($role->users->count())->toHtml(),
            'locked'      => '<span class="status '.($role->isLocked() ? 'status-danger' : 'status-secondary').'" data-toggle="tooltip" data-placement="top" title="'.($role->isLocked() ? __('Locked') : __('Unlocked')).'"></span>',
            'status'      => '<span class="status '.($role->isActive() ? 'status-success status-animated' : 'status-secondary').'" data-toggle="tooltip" data-placement="top" title="'.($role->isActive() ? __('Activated') : __('Deactivated')).'"></span>',
            'actions'     => static::renderActions($actions),
        ];
    }

    /* -----------------------------------------------------------------
     |  Other Methods
     | -----------------------------------------------------------------
     */

    /**
     * Get the users' actions.
     *
     * @param  \Arcanesoft\Auth\Models\Role  $role
     *
     * @return array
     */
    private static function getActions(Role $role): array
    {
        $actions = [];

        if (static::can(RolesPolicy::ability('show'), [$role]))
            $actions[] = LinkAction::action('show', route('admin::auth.roles.show', [$role]), false)
                ->size('sm');

        if (static::can(RolesPolicy::ability('update'), [$role]))
            $actions[] = LinkAction::action('edit', $role->isLocked() ? '#' : route('admin::auth.roles.edit', [$role]), false)
                ->size('sm')
                ->setDisabled($role->isLocked());

        if (static::can(RolesPolicy::ability('activate'), [$role]))
            $actions[] = ButtonAction::action($role->isActive() ? 'deactivate' : 'activate', false)
                ->size('sm')
                ->attribute('onclick', "window.Foundation.\$emit('auth::roles.activate', ".json_encode(['id' => $role->getRouteKey(), 'status' => $role->isActive() ? 'activated' : 'deactivated']).")")
                ->setDisabled($role->isLocked());

        if (static::can(RolesPolicy::ability('delete'), [$role]))
            $actions[] = ButtonAction::action('delete', false)
                ->size('sm')
                ->attributeIf($role->isDeletable(), 'onclick', "window.Foundation.\$emit('auth::roles.delete', ".json_encode(['id' => $role->getRouteKey()]).")")
                ->setDisabled($role->isNotDeletable());

        return $actions;
    }
}
