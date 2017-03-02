<?php namespace Arcanesoft\Auth\Http\Requests\Admin\Roles;

/**
 * Class     CreateRoleRequest
 *
 * @package  Arcanesoft\Auth\Http\Requests\Admin\Roles
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class CreateRoleRequest extends RoleFormRequest
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
            'slug' => ['required', 'min:3', $this->getSlugRule()],
        ]);
    }
}
