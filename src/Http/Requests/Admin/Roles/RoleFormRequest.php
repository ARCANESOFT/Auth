<?php namespace Arcanesoft\Auth\Http\Requests\Admin\Roles;

use Arcanesoft\Auth\Http\Requests\FormRequest;
use Arcanesoft\Auth\Models\Permission;
use Arcanesoft\Auth\Models\Role;
use Illuminate\Validation\Rule;

/**
 * Class     RoleFormRequest
 *
 * @package  Arcanesoft\Auth\Http\Requests\Admin\Roles
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
abstract class RoleFormRequest extends FormRequest
{
    /* -----------------------------------------------------------------
     |  Main Methods
     | -----------------------------------------------------------------
     */
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name'        => ['required', 'min:3'],
            'slug'        => ['required', 'min:3', $this->getSlugRule()],
            'description' => ['required', 'min:10'],
            'permissions' => ['required', 'array', 'in:'.Permission::getIds()->implode(',')],
        ];
    }

    /* -----------------------------------------------------------------
     |  Other Methods
     | -----------------------------------------------------------------
     */
    /**
     * Sanitize the inputs.
     *
     * @return array
     */
    protected function sanitize()
    {
        return [
            'slug' => (new Role)->makeSlugName($this->get($this->has('slug') ? 'slug' : 'name'))
        ];
    }

    /**
     * Get the slug rule.
     *
     * @param  string  $column
     *
     * @return \Illuminate\Validation\Rules\Unique
     */
    protected function getSlugRule($column = 'slug')
    {
        return Rule::unique('roles', $column);
    }
}
