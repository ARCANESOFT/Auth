<?php

declare(strict_types=1);

namespace Arcanesoft\Auth\Models;

use Arcanesoft\Auth\Auth;
use Arcanesoft\Auth\Events\Permissions\{
    AttachedRoleToPermission, AttachingRoleToPermission, CreatedPermission, CreatingPermission, DeletedPermission,
    DeletingPermission, DetachedAllRolesFromPermission, DetachedRoleFromPermission, DetachingAllRolesFromPermission,
    DetachingRoleFromPermission, RetrievedPermission, SavedPermission, SavingPermission, UpdatedPermission,
    UpdatingPermission
};
use Arcanesoft\Auth\Models\Concerns\HasRoles;
use Arcanesoft\Auth\Models\Presenters\PermissionPresenter;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Str;

/**
 * Class     Permission
 *
 * @package  Arcanesoft\Auth\Models
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 *
 * @property  int                                            id
 * @property  string                                         uuid
 * @property  int                                            group_id
 * @property  string|null                                    category
 * @property  string                                         ability
 * @property  string                                         name
 * @property  string                                         description
 * @property  \Illuminate\Support\Carbon                     created_at
 *
 * @property  \Illuminate\Database\Eloquent\Collection       roles
 * @property  \Arcanesoft\Auth\Models\PermissionsGroup       group
 * @property  \Arcanesoft\Auth\Models\Pivots\PermissionRole  permission_role
 */
class Permission extends Model
{
    /* -----------------------------------------------------------------
     |  Constants
     | -----------------------------------------------------------------
     */

    const UPDATED_AT = null;

    /* -----------------------------------------------------------------
     |  Traits
     | -----------------------------------------------------------------
     */

    use PermissionPresenter,
        HasRoles;

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
        'group_id',
        'category',
        'ability',
        'name',
        'description',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id'       => 'integer',
        'group_id' => 'integer',
    ];

    /**
     * The event map for the model.
     *
     * Allows for object-based events for native Eloquent events.
     *
     * @var array
     */
    protected $dispatchesEvents = [
        'retrieved' => RetrievedPermission::class,
        'creating'  => CreatingPermission::class,
        'created'   => CreatedPermission::class,
        'updating'  => UpdatingPermission::class,
        'updated'   => UpdatedPermission::class,
        'saving'    => SavingPermission::class,
        'saved'     => SavedPermission::class,
        'deleting'  => DeletingPermission::class,
        'deleted'   => DeletedPermission::class,
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
        $this->setTable(Auth::table('permissions', 'permissions'));

        parent::__construct($attributes);
    }

    /* -----------------------------------------------------------------
     |  Relationships
     | -----------------------------------------------------------------
     */

    /**
     * Permission belongs to one group.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function group()
    {
        return $this->belongsTo(
            Auth::model('permissions-group', PermissionsGroup::class),
            'group_id'
        );
    }

    /**
     * Permission belongs to many roles.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function roles()
    {
        return $this->belongsToMany(
            Auth::model('role', Role::class),
            Auth::table('permission-role', 'permission_role')
        )
            ->using(Pivots\PermissionRole::class)
            ->as('permission_role')
            ->withPivot(['created_at']);
    }

    /* -----------------------------------------------------------------
     |  Setters & Getters
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
     * Set the `ability` attribute.
     *
     * @param  string  $ability
     */
    public function setAbilityAttribute($ability)
    {
        $this->attributes['ability'] = static::prepareAbility($ability);
    }

    /* -----------------------------------------------------------------
     |  Check Methods
     | -----------------------------------------------------------------
     */

    /**
     * Check if the permission has the same slug.
     *
     * @param  string  $ability
     *
     * @return bool
     */
    public function hasAbility($ability): bool
    {
        return $this->ability === $this->prepareAbility($ability);
    }

    /**
     * Check if the ability is registered (Gate).
     *
     * @return bool
     */
    public function isAbilityRegistered(): bool
    {
        return Gate::has($this->ability);
    }

    /* -----------------------------------------------------------------
     |  Other Functions
     | -----------------------------------------------------------------
     */

    /**
     * Slugify the value.
     *
     * @param  string  $ability
     *
     * @return string
     */
    protected static function prepareAbility(string $ability): string
    {
        return Str::lower(str_replace(' ', '.', $ability));
    }
}
