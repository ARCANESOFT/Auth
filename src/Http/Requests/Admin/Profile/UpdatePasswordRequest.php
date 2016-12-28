<?php namespace Arcanesoft\Auth\Http\Requests\Admin\Profile;

use Arcanesoft\Auth\Http\Requests\FormRequest;

/**
 * Class     UpdatePasswordRequest
 *
 * @package  Arcanesoft\Auth\Http\Requests\Admin\Profile
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class UpdatePasswordRequest extends FormRequest
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
        /** @var  \Arcanesoft\Contracts\Auth\Models\User  $user */
        $user = $this->route('auth_user');

        return $user->id === auth()->user()->id;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'old_password' => ['required', 'min:8', 'different:password', 'user_password'],
            'password'     => ['required', 'min:8', 'different:old_password', 'confirmed'],
        ];
    }

    /**
     * Set custom messages for validator errors.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'old_password.different' => 'The old and new passwords must be different.',
            'password.different'     => 'The old and new passwords must be different.',
        ];
    }
}
