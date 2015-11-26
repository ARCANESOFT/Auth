<?php namespace Arcanesoft\Auth\Http\Requests\Front;

use Arcanedev\Support\Bases\FormRequest;

/**
 * Class     RegisterUserRequest
 *
 * @package  Arcanesoft\Auth\Http\Requests\Front
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class RegisterUserRequest extends FormRequest
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
            'email'      => 'required|email|max:255|unique:users',
            'password'   => 'required|confirmed|min:8|max:30',
            'username'   => 'required|max:30',
            'first_name' => 'required|max:30',
            'last_name'  => 'required|max:30',
        ];
    }
}
