<?php namespace Arcanesoft\Auth\Http\Requests\Backend\Roles;

use Arcanesoft\Auth\Bases\FormRequest;
use Arcanesoft\Auth\Models\Permission;
use Arcanesoft\Auth\Models\Role;

/**
 * Class     CreateRoleRequest
 *
 * @package  Arcanesoft\Auth\Http\Requests\Backend\Roles
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class CreateRoleRequest extends FormRequest
{
    /* ------------------------------------------------------------------------------------------------
     |  Properties
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Role validation rules.
     *
     * @var array
     */
    protected $rules = [
        'name'        => 'required|min:3',
        'slug'        => 'required|min:3|unique:roles,slug',
        'description' => 'required|min:10',
        'permissions' => 'required|array',
    ];

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
        $rules                 = $this->rules;
        $rules['permissions'] .= '|in:' . Permission::getIds()->implode(',');

        return $rules;
    }

    /**
     * {@inheritdoc}
     */
    public function all()
    {
        $value = empty($this->get('slug'))
            ? $this->get('name')
            : $this->get('slug');

        return array_merge(parent::all(), [
            'slug' => (new Role)->makeSlugName($value)
        ]);
    }
}
