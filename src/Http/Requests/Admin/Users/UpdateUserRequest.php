<?php namespace Arcanesoft\Auth\Http\Requests\Admin\Users;

/**
 * Class     UpdateUserRequest
 *
 * @package  Arcanesoft\Auth\Http\Requests\Admin\Users
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class UpdateUserRequest extends UserFormRequest
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
        /** @var  \Arcanesoft\Contracts\Auth\Models\User  $user */
        $user = $this->route('auth_user');

        return array_merge(parent::rules(), [
            'username'              => ['required', 'min:3', $this->getUsernameRule()->ignore($user->id)],
            'email'                 => ['required', 'email', $this->getEmailRule()->ignore($user->id)],
            'password'              => ['nullable', 'required_with:password_confirmation', 'min:8', 'confirmed'],
            'password_confirmation' => ['nullable', 'required_with:password'],
        ]);
    }
}
