<?php namespace Arcanesoft\Auth\Http\Requests\Backend\Roles;

use Arcanesoft\Auth\Bases\FormRequest;
use Arcanesoft\Auth\Models\Permission;
use Arcanesoft\Auth\Models\Role;

/**
 * Class     RoleFormRequest
 *
 * @package  Arcanesoft\Auth\Http\Requests\Backend\Roles
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
abstract class RoleFormRequest extends FormRequest
{
    /* ------------------------------------------------------------------------------------------------
     |  Main Functions
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name'        => 'required|min:3',
            'slug'        => 'required|min:3|unique:roles,slug',
            'description' => 'required|min:10',
            'permissions' => 'required|array|in:' . Permission::getIds()->implode(','),
        ];
    }

    /**
     * Sanitize the inputs.
     *
     * @param  array  $inputs
     *
     * @return array
     */
    public function sanitize(array $inputs)
    {
        $inputs['slug'] = (new Role)->makeSlugName(
            $this->get($this->has('slug') ? 'slug' : 'name')
        );

        return $inputs;
    }
}
