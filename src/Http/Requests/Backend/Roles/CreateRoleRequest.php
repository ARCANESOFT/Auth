<?php namespace Arcanesoft\Auth\Http\Requests\Backend\Roles;

use Arcanesoft\Auth\Bases\FormRequest;

/**
 * Class     CreateRoleRequest
 *
 * @package  Arcanesoft\Auth\Http\Requests\Backend\Roles
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class CreateRoleRequest extends FormRequest
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
            'slug' => 'required|min:3|unique:roles,slug',
        ]);
    }
}
