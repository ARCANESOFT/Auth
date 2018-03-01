<?php namespace Arcanesoft\Auth\Rules;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\Hash;

/**
 * Class     OldPasswordRule
 *
 * @package  Arcanesoft\Auth\Rules
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class OldPasswordRule implements Rule
{
    /* -----------------------------------------------------------------
     |  Properties
     | -----------------------------------------------------------------
     */

    /** @var  \Illuminate\Contracts\Auth\Authenticatable */
    protected $user;

    /* -----------------------------------------------------------------
     |  Constructor
     | -----------------------------------------------------------------
     */

    /**
     * OldPasswordRule constructor.
     *
     * @param  \Illuminate\Contracts\Auth\Authenticatable  $user
     */
    public function __construct(Authenticatable $user)
    {
        $this->user = $user;
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
        return Hash::check($value, $this->user->getAuthPassword());
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return trans('auth::validation.user_password');
    }
}
