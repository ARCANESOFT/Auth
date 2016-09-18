<?php namespace Arcanesoft\Auth\Http\Requests\Backend\Users;

/**
 * Class     UpdateUserRequest
 *
 * @package  Arcanesoft\Auth\Http\Requests\Backend\Users
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class UpdateUserRequest extends UserRequest
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
        /** @var \Arcanesoft\Contracts\Auth\Models\User  $user */
        $user = $this->route('user_id');

        return [
            'username'              => "required|min:3|unique:users,username,{$user->id}",
            'email'                 => "required|email|unique:users,email,{$user->id}",
            'first_name'            => 'required|min:2',
            'last_name'             => 'required|min:2',
            'password'              => 'required_with:password_confirmation|min:8|confirmed',
            'password_confirmation' => 'required_with:password|min:8',
            'roles'                 => $this->getRolesRule(),
        ];
    }
}
