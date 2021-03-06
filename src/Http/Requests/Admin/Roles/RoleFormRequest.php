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
            'name'        => ['required', 'string', 'min:3'],
            'description' => ['required', 'string', 'min:10'],
            'permissions' => ['required', 'array', 'in:'.Permission::getIds()->implode(',')],
        ];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array
     */
    public function attributes()
    {
        return [
            'permissions' => trans('auth::permissions.titles.permissions')
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
            'slug' => (new Role)->makeSlugName(
                $this->get($this->has('slug') ? 'slug' : 'name')
            )
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
        return Rule::unique($this->getRolesTable(), $column);
    }

    /**
     * Get the roles table name.
     *
     * @return string
     */
    protected function getRolesTable()
    {
        return $this->getPrefixTable().config('arcanesoft.auth.roles.table', 'roles');
    }
}
