<?php

declare(strict_types=1);

namespace Arcanesoft\Auth\Rules\Users;

use Arcanesoft\Auth\Auth;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Database\Eloquent\Builder;

/**
 * Class     UniqueKey
 *
 * @package  Arcanesoft\Auth\Rules\Users
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class UniqueKey implements Rule
{
    /* -----------------------------------------------------------------
     |  Properties
     | -----------------------------------------------------------------
     */

    /** @var  int|null */
    protected $ignored;

    /* -----------------------------------------------------------------
     |  Setters
     | -----------------------------------------------------------------
     */

    /**
     * Ignore by the given id.
     *
     * @param  int  $id
     *
     * @return $this
     */
    public function ignore($id)
    {
        $this->ignored = $id;

        return $this;
    }

    /* -----------------------------------------------------------------
     |  Main Methods
     | -----------------------------------------------------------------
     */

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed   $value
     *
     * @return bool
     */
    public function passes($attribute, $value)
    {
        return ! Auth::makeModel('role')
            ->newQuery()
            ->where('key', Auth::slugRoleKey($value))
            ->unless(is_null($this->ignored), function (Builder $query) {
                return $query->where('id', '!=', $this->ignored);
            })
            ->exists();
    }

    /**
     * Get the validation error message.
     *
     * @return string|array
     */
    public function message()
    {
        return 'The :attribute has already been taken.';
    }
}
