<?php

use Arcanesoft\Auth\Events;
use Arcanesoft\Auth\Listeners;

return [

    /* -----------------------------------------------------------------
     |  User's events
     | -----------------------------------------------------------------
     */

    Events\Users\RetrievedUser::class => [],

    Events\Users\CreatingUser::class => [
        Listeners\Users\GeneratesUuid::class
    ],
    Events\Users\CreatedUser::class => [],

    Events\Users\UpdatingUser::class => [],
    Events\Users\UpdatedUser::class => [],

    Events\Users\SavingUser::class => [],
    Events\Users\SavedUser::class => [],

    Events\Users\DeletingUser::class => [],
    Events\Users\DeletedUser::class => [],
    Events\Users\ForceDeletedUser::class => [],

    Events\Users\RestoringUser::class => [],
    Events\Users\RestoredUser::class => [],

    Events\Users\ReplicatingUser::class => [],

    Events\Users\ActivatingUser::class => [],
    Events\Users\ActivatedUser::class => [],
    Events\Users\DeactivatingUser::class => [],
    Events\Users\DeactivatedUser::class => [],

    Events\Users\AttachingRoleToUser::class => [],
    Events\Users\AttachedRoleToUser::class => [],
    Events\Users\DetachingRoleFromUser::class => [],
    Events\Users\DetachedRoleFromUser::class => [],

    Events\Users\DetachingRolesFromUser::class => [],
    Events\Users\DetachedRolesFromUser::class => [],
    Events\Users\SyncingRolesToUser::class => [],
    Events\Users\SyncedRolesToUser::class => [],

    /* -----------------------------------------------------------------
     |  Role's events
     | -----------------------------------------------------------------
     */

    Events\Roles\RetrievedRole::class                   => [],

    Events\Roles\CreatingRole::class                    => [
        Listeners\Roles\GeneratesUuid::class,
    ],
    Events\Roles\CreatedRole::class                     => [],

    Events\Roles\UpdatingRole::class                    => [],
    Events\Roles\UpdatedRole::class                     => [],

    Events\Roles\SavingRole::class                      => [],
    Events\Roles\SavedRole::class                       => [],

    Events\Roles\DeletingRole::class                    => [
        Listeners\Roles\DetachPermissions::class,
        Listeners\Roles\DetachUsers::class,
    ],
    Events\Roles\DeletedRole::class                     => [],

    Events\Roles\AttachingUserToRole::class             => [],
    Events\Roles\AttachedUserToRole::class              => [],
    Events\Roles\DetachingUserFromRole::class           => [],
    Events\Roles\DetachedUserFromRole::class            => [],

    Events\Roles\DetachingAllUsersFromRole::class       => [],
    Events\Roles\DetachedAllUsersFromRole::class        => [],

    Events\Roles\AttachingPermissionToRole::class       => [],
    Events\Roles\AttachedPermissionToRole::class        => [],
    Events\Roles\DetachingPermissionFromRole::class     => [],
    Events\Roles\DetachedPermissionFromRole::class      => [],

    Events\Roles\SyncingPermissionsToRole::class        => [],
    Events\Roles\SyncedPermissionsToRole::class         => [],
    Events\Roles\DetachingAllPermissionsFromRole::class => [],
    Events\Roles\DetachedAllPermissionsFromRole::class  => [],

    /* -----------------------------------------------------------------
     |  Permission's events
     | -----------------------------------------------------------------
     */

    Events\Permissions\RetrievedPermission::class => [],

    Events\Permissions\CreatingPermission::class => [
        Listeners\Permissions\GeneratesUuid::class,
    ],
    Events\Permissions\CreatedPermission::class => [],

    Events\Permissions\UpdatingPermission::class => [],
    Events\Permissions\UpdatedPermission::class => [],

    Events\Permissions\SavingPermission::class => [],
    Events\Permissions\SavedPermission::class => [],

    Events\Permissions\DeletingPermission::class => [],
    Events\Permissions\DeletedPermission::class => [],

    Events\Permissions\AttachingRoleToPermission::class => [],
    Events\Permissions\AttachedRoleToPermission::class => [],
    Events\Permissions\DetachingRoleFromPermission::class => [],
    Events\Permissions\DetachedRoleFromPermission::class => [],

    Events\Permissions\SyncedRolesToPermission::class => [],
    Events\Permissions\SyncingRolesToPermission::class => [],
    Events\Permissions\DetachingAllRolesFromPermission::class => [],
    Events\Permissions\DetachedAllRolesFromPermission::class => [],

];
