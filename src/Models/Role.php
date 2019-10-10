<?php

declare(strict_types=1);

namespace Arcanesoft\Auth\Models;

use Arcanesoft\Auth\Auth;
use Arcanesoft\Auth\Events\Roles\{
    AttachedPermissionToRole,
    AttachedUserToRole,
    AttachingPermissionToRole,
    AttachingUserToRole,
    CreatedRole,
    CreatingRole,
    DeletedRole,
    DeletingRole,
    DetachedAllPermissionsFromRole,
    DetachedAllUsersFromRole,
    DetachedPermissionFromRole,
    DetachedUserFromRole,
    DetachingAllPermissionsFromRole,
    DetachingAllUsersFromRole,
    DetachingPermissionFromRole,
    DetachingUserFromRole,
    RetrievedRole,
    SavedRole,
    SavingRole,
    SyncedPermissionsToRole,
    SyncingPermissionsToRole,
    UpdatedRole,
    UpdatingRole
};
use Arcanesoft\Auth\Models\Concerns\Activatable;
use Illuminate\Database\Eloquent\Builder;

/**
 * Class     Role
 *
 * @package  Arcanesoft\Auth\Models
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 *
 * @property  int                                       id
 * @property  string                                    uuid
 * @property  string                                    name
 * @property  string                                    key
 * @property  string                                    description
 * @property  bool                                      is_locked
 * @property  \Illuminate\Support\Carbon                created_at
 * @property  \Illuminate\Support\Carbon                updated_at
 *
 * @property  \Illuminate\Database\Eloquent\Collection  users
 * @property  \Illuminate\Database\Eloquent\Collection  permissions
 *
 * @method  static  \Illuminate\Database\Eloquent\Builder|static  admin()
 * @method  static  \Illuminate\Database\Eloquent\Builder|static  moderator()
 * @method  static  \Illuminate\Database\Eloquent\Builder|static  member()
 *
 * @method  static  \Illuminate\Database\Eloquent\Builder|static  filterByAuthenticatedUser()
 */
class Role extends Model
{
    /* -----------------------------------------------------------------
     |  Constants
     | -----------------------------------------------------------------
     */

    const ADMINISTRATOR = 'administrator';
    const MODERATOR     = 'moderator';
    const MEMBER        = 'member';

    /* -----------------------------------------------------------------
     |  Traits
     | -----------------------------------------------------------------
     */

    use Activatable;

    /* -----------------------------------------------------------------
     |  Properties
     | -----------------------------------------------------------------
     */

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'key',
        'description',
    ];

    /**
     * The event map for the model.
     *
     * @var array
     */
    protected $dispatchesEvents = [
        'retrieved' => RetrievedRole::class,
        'creating'  => CreatingRole::class,
        'created'   => CreatedRole::class,
        'updating'  => UpdatingRole::class,
        'updated'   => UpdatedRole::class,
        'saving'    => SavingRole::class,
        'saved'     => SavedRole::class,
        'deleting'  => DeletingRole::class,
        'deleted'   => DeletedRole::class,
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id'           => 'integer',
        'is_locked'    => 'boolean',
        'activated_at' => 'datetime',
    ];

    /* -----------------------------------------------------------------
     |  Constructor
     | -----------------------------------------------------------------
     */

    /**
     * Create a new Eloquent model instance.
     *
     * @param  array  $attributes
     */
    public function __construct(array $attributes = [])
    {
        $this->setTable(Auth::table('roles'));

        parent::__construct($attributes);
    }

    /* -----------------------------------------------------------------
     |  Relationships
     | -----------------------------------------------------------------
     */

    /**
     * Role belongs to many users.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function users()
    {
        return $this
            ->belongsToMany(
                Auth::model('user', User::class),
                Auth::table('role-user', 'role_user')
            )
            ->using(Pivots\RoleUser::class)
            ->as('role_user')
            ->withPivot(['created_at']);
    }

    /**
     * Role belongs to many permissions.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function permissions()
    {
        return $this
            ->belongsToMany(
                Auth::model('permission', Permission::class),
                Auth::table('permission-role', 'permission_role')
            )
            ->using(Pivots\PermissionRole::class)
            ->as('permission_role')
            ->withPivot(['created_at']);
    }

    /* -----------------------------------------------------------------
     |  Scopes
     | -----------------------------------------------------------------
     */

    /**
     * Scope by the authenticated user.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  \Arcanesoft\Auth\Models\User           $user
     *
     * @return \Illuminate\Database\Eloquent\Builder|mixed
     */
    public function scopeFilterByAuthenticatedUser(Builder $query, User $user)
    {
        if ($user->isSuperAdmin())
            return $query;

        return $query->where('key', '!=', static::ADMINISTRATOR);
    }

    /**
     * Scope only with administrator role.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeAdmin(Builder $query): Builder
    {
        return $query->where('key', Role::ADMINISTRATOR);
    }

    /**
     * Scope only with moderator role.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeModerator(Builder $query): Builder
    {
        return $query->where('key', Role::MODERATOR);
    }

    /**
     * Scope only with member role.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeMember(Builder $query): Builder
    {
        return $query->where('key', Role::MEMBER);
    }

    /* -----------------------------------------------------------------
     |  Getters & Setters
     | -----------------------------------------------------------------
     */

    /**
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName(): string
    {
        return 'uuid';
    }

    /**
     * Set the name attribute.
     *
     * @param  string  $name
     */
    public function setNameAttribute(string $name)
    {
        $this->attributes['name'] = $name;
        $this->setKeyAttribute($name);
    }

    /**
     * Set the `key` attribute.
     *
     * @param  string  $key
     */
    public function setKeyAttribute(string $key)
    {
        $this->attributes['key'] = Auth::slugRoleKey($key);
    }

    /* ------------------------------------------------------------------------------------------------
     |  CRUD Functions
     | ------------------------------------------------------------------------------------------------
     */

    /**
     * Activate the model.
     *
     * @param  bool  $save
     *
     * @return bool
     */
    public function activate(bool $save = true)
    {
        return $this->switchActive(true, $save);
    }

    /**
     * Deactivate the model.
     *
     * @param  bool  $save
     *
     * @return bool
     */
    public function deactivate(bool $save = true)
    {
        return $this->switchActive(false, $save);
    }

    /**
     * Activate/deactivate the model.
     *
     * @param  bool  $active
     * @param  bool  $save
     *
     * @return bool
     */
    protected function switchActive($active, $save = true)
    {
        $this->forceFill([
            'activated_at' => $active === true ? $this->freshTimestamp() : null,
        ]);

        return $save ? $this->save() : false;
    }

    /**
     * Attach a permission to a role.
     *
     * @param  \Arcanesoft\Auth\Models\User|int  $user
     * @param  bool                              $reload
     */
    public function attachUser($user, bool $reload = true)
    {
        if ($this->hasUser($user))
            return;

        event(new AttachingUserToRole($this, $user));
        $this->users()->attach($user);
        event(new AttachedUserToRole($this, $user));

        $this->loadUsers($reload);
    }

    // TODO: Adding attach multiple users to a role ?

    /**
     * Detach a user from a role.
     *
     * @param  \Arcanesoft\Auth\Models\User|int  $user
     * @param  bool                              $reload
     *
     * @return int
     */
    public function detachUser($user, bool $reload = true)
    {
        event(new DetachingUserFromRole($this, $user));
        $results = $this->users()->detach($user);
        event(new DetachedUserFromRole($this, $user, $results));

        $this->loadUsers($reload);

        return $results;
    }

    // TODO: Adding detach multiple users to a role ?

    /**
     * Attach a permission to a role.
     *
     * @param  \Arcanesoft\Auth\Models\Permission|int  $permission
     * @param  bool                                    $reload
     */
    public function attachPermission($permission, bool $reload = true)
    {
        if ($this->hasPermission($permission))
            return;

        event(new AttachingPermissionToRole($this, $permission));
        $this->permissions()->attach($permission);
        event(new AttachedPermissionToRole($this, $permission));

        $this->loadPermissions($reload);
    }

    /* -----------------------------------------------------------------
     |  Check Methods
     | -----------------------------------------------------------------
     */

    /**
     * Check if role has the given user (User Model or Id).
     *
     * @param  \Arcanesoft\Auth\Models\User|int  $id
     *
     * @return bool
     */
    public function hasUser($id): bool
    {
        $id = $id instanceof Model ? $id->getKey() : $id;

        return $this->users->contains('id', $id);
    }

    /**
     * Check if role has the given permission (Permission Model or Id).
     *
     * @param  \Arcanesoft\Auth\Models\Permission|int  $id
     *
     * @return bool
     */
    public function hasPermission($id): bool
    {
        $id = $id instanceof Model ? $id->getKey() : $id;

        return $this->permissions->contains('id', $id);
    }

    /**
     * Check if role is associated with a permission by ability.
     *
     * @param  string  $ability
     *
     * @return bool
     */
    public function can(string $ability): bool
    {
        if ( ! $this->isActive())
            return false;

        return $this->permissions->filter(function (Permission $permission) use ($ability) {
            return $permission->hasAbility($ability);
        })->first() !== null;
    }

    /**
     * Check if a role is associated with any of given permissions.
     *
     * @param  \Illuminate\Support\Collection|array  $permissions
     * @param  \Illuminate\Support\Collection        &$failed
     *
     * @return bool
     */
    public function canAny($permissions, &$failed = null): bool
    {
        $permissions = is_array($permissions) ? collect($permissions) : $permissions;

        $failed = $permissions->reject(function ($permission) {
            return $this->can($permission);
        })->values();

        return $permissions->count() !== $failed->count();
    }

    /**
     * Check if role is associated with all given permissions.
     *
     * @param  \Illuminate\Support\Collection|array  $permissions
     * @param  \Illuminate\Support\Collection        &$failed
     *
     * @return bool
     */
    public function canAll($permissions, &$failed = null): bool
    {
        $this->canAny($permissions, $failed);

        return $failed->isEmpty();
    }

    /**
     * Check if the role is locked.
     *
     * @return bool
     */
    public function isLocked(): bool
    {
        return $this->is_locked;
    }

    /**
     * Check if key is the same as the given value.
     *
     * @param  string  $key
     *
     * @return bool
     */
    public function hasKey(string $key): bool
    {
        return $this->key === Auth::slugRoleKey($key);
    }

    /**
     * Check if the records is deletable.
     *
     * @return bool
     */
    public function isDeletable(): bool
    {
        return ! $this->isLocked();
    }

    /**
     * Check if the record is not deletable.
     *
     * @return bool
     */
    public function isNotDeletable(): bool
    {
        return ! $this->isDeletable();
    }

    /* -----------------------------------------------------------------
     |  Other Methods
     | -----------------------------------------------------------------
     */

    /**
     * Load the users.
     *
     * @param  bool  $load
     *
     * @return $this
     */
    protected function loadUsers(bool $load = true)
    {
        return $load ? $this->load('users') : $this;
    }

    /**
     * Load the permissions.
     *
     * @param  bool  $load
     *
     * @return $this
     */
    protected function loadPermissions(bool $load = true)
    {
        return $load ? $this->load('permissions') : $this;
    }
}
