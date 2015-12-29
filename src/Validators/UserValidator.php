<?php namespace Arcanesoft\Auth\Validators;

use Illuminate\Support\Facades\Hash;

/**
 * Class     UserValidator
 *
 * @package  Arcanesoft\Auth\Validators
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class UserValidator
{
    /* ------------------------------------------------------------------------------------------------
     |  Validation Functions
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Validate the user current/old password.
     *
     * @param  string                            $attribute
     * @param  string                            $value
     * @param  array                             $parameters
     * @param  \Illuminate\Validation\Validator  $validator
     *
     * @return bool
     */
    public function validateUserPassword($attribute, $value, $parameters, $validator)
    {
        if (auth()->guest()) {
            return false;
        }

        return Hash::check($value, auth()->user()->password);
    }
}
