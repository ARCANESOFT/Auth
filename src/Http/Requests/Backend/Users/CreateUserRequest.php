<?php namespace Arcanesoft\Auth\Http\Requests\Backend\Users;

/**
 * Class     CreateUserRequest
 *
 * @package  Arcanesoft\Auth\Http\Requests\Backend\Users
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class CreateUserRequest extends UserRequest
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
        return [
            'username'              => 'required|min:3|unique:users,username',
            'email'                 => 'required|email|unique:users,email',
            'first_name'            => 'required|min:2',
            'last_name'             => 'required|min:2',
            'password'              => 'required|min:8|confirmed',
            'password_confirmation' => 'required|min:8',
            'roles'                 => $this->getRolesRule(),
        ];
    }
}
