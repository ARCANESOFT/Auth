<?php namespace Arcanesoft\Auth\Http\Requests\Admin\Users;

/**
 * Class     CreateUserRequest
 *
 * @package  Arcanesoft\Auth\Http\Requests\Admin\Users
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class CreateUserRequest extends UserFormRequest
{
    /* ------------------------------------------------------------------------------------------------
     |  Main Functions
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return array_merge(parent::rules(), [
            'username' => 'required|min:3|unique:users,username',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|min:8|confirmed',
        ]);
    }
}
