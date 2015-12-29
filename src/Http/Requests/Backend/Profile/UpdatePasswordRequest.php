<?php namespace Arcanesoft\Auth\Http\Requests\Backend\Profile;

use Arcanesoft\Auth\Bases\FormRequest;

/**
 * Class     UpdatePasswordRequest
 *
 * @package  Arcanesoft\Auth\Http\Requests\Backend\Profile
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class UpdatePasswordRequest extends FormRequest
{
    /* ------------------------------------------------------------------------------------------------
     |  Properties
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * The Validation rules.
     *
     * @var array
     */
    protected $rules = [
        'old_password'          => 'required|min:8|different:password|user_password',
        'password'              => 'required|min:8|different:old_password|confirmed',
        'password_confirmation' => 'required|min:8',
    ];

    /**
     * @var \Arcanesoft\Contracts\Auth\Models\User $user
     */
    protected $user;

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
        /** @var \Arcanesoft\Contracts\Auth\Models\User $user */
        $user = $this->route('user_id');

        return $user->id === auth()->user()->id;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return $this->rules;
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
