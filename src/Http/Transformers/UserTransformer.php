<?php

declare(strict_types=1);

namespace Arcanesoft\Auth\Http\Transformers;

use Arcanesoft\Auth\Models\User;
use Arcanesoft\Auth\Policies\UsersPolicy;
use Arcanesoft\Foundation\Helpers\UI\Actions\{ButtonAction, LinkAction};

/**
 * Class     UsersTable
 *
 * @package  Arcanesoft\Auth\Tables
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class UserTransformer extends AbstractTransformer
{
    /* -----------------------------------------------------------------
     |  Main Methods
     | -----------------------------------------------------------------
     */

    /**
     * Transform the users for datatable.
     *
     * @param  \Arcanesoft\Auth\Models\User  $user
     *
     * @return array
     */
    public function transform(User $user): array
    {
        $actions = static::getActions($user);

        return [
            'avatar'     => '<span class="avatar" style="background-image: url('.$user->avatar.')" title="'.$user->full_name.'"></span>',
            'first_name' => $user->first_name,
            'last_name'  => $user->last_name,
            'email'      => $user->email,
            'created_at' => "<small>{$user->created_at->format('Y-m-d H:i:s')}</small>",
            'status'     => '<span class="status '.($user->isActive() ? 'status-success status-animated' : 'status-secondary').'" data-toggle="tooltip" data-placement="top" title="'.($user->isActive() ? __('Activated') : __('Deactivated')).'"></span>',
            'actions'    => static::renderActions($actions),
        ];
    }

    /* -----------------------------------------------------------------
     |  Other Methods
     | -----------------------------------------------------------------
     */

    /**
     * Get the users' actions.
     *
     * @param  \Arcanesoft\Auth\Models\User  $user
     *
     * @return array
     */
    private static function getActions(User $user): array
    {
        $actions = [];

        if (static::can(UsersPolicy::ability('show'), [$user]))
            $actions[] = LinkAction::action('show', route('admin::auth.users.show', [$user]), false)
                ->size('sm');

        if (static::can(UsersPolicy::ability('update'), [$user]))
            $actions[] = LinkAction::action('edit', route('admin::auth.users.edit', [$user]), false)
                ->size('sm');

        if (static::can(UsersPolicy::ability('activate'), [$user]))
            $actions[] = ButtonAction::action($user->isActive() ? 'deactivate' : 'activate', false)
                ->attributeIf($user->isDeletable(), 'onclick', "Foundation.\$emit('auth::users.activate', ".json_encode(['id' => $user->uuid, 'status' => $user->isActive() ? 'activated' : 'deactivated']).")")
                ->size('sm')
                ->setDisabled($user->isSuperAdmin());

        if (static::can(UsersPolicy::ability('restore'), [$user]) && $user->trashed())
            $actions[] = ButtonAction::action('restore', false)
                ->attribute('onclick', "window.Foundation.\$emit('auth::users.restore', ".json_encode(['id' => $user->uuid]).")")
                ->size('sm');

        if (static::can(UsersPolicy::ability('delete'), [$user]))
            $actions[] = ButtonAction::action('delete', false)
                ->attributeIf($user->isDeletable(), 'onclick', "window.Foundation.\$emit('auth::users.delete', ".json_encode(['id' => $user->uuid]).")")
                ->size('sm')
                ->setDisabled($user->isNotDeletable());

        return $actions;
    }
}
