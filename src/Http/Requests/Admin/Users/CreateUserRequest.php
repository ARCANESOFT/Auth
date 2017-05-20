<?php namespace Arcanesoft\Auth\Http\Requests\Admin\Users;

/**
 * Class     CreateUserRequest
 *
 * @package  Arcanesoft\Auth\Http\Requests\Admin\Users
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class CreateUserRequest extends UserFormRequest
{
    /* -----------------------------------------------------------------
     |  Main Methods
     | -----------------------------------------------------------------
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
            'username' => ['required', 'string', 'min:3', $this->getUsernameRule()],
            'email'    => ['required', 'string', 'email', $this->getEmailRule()],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    /* -----------------------------------------------------------------
     |  Other Methods
     | -----------------------------------------------------------------
     */

    /**
     * Get the validated data.
     *
     * @return array
     */
    public function getValidatedData()
    {
        return $this->only(['username', 'email', 'first_name', 'last_name', 'password']);
    }
}
