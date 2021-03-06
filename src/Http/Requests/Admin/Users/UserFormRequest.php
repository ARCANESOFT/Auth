<?php namespace Arcanesoft\Auth\Http\Requests\Admin\Users;

use Arcanesoft\Auth\Http\Requests\FormRequest;
use Arcanesoft\Contracts\Auth\Models\Role as RoleContract;
use Cache;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

/**
 * Class     UserFormRequest
 *
 * @package  Arcanesoft\Auth\Http\Requests\Admin\Users
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
abstract class UserFormRequest extends FormRequest
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
            'first_name' => ['required', 'string', 'min:2'],
            'last_name'  => ['required', 'string', 'min:2'],
            'roles'      => $this->getRolesRule(),
        ];
    }

    /**
     * Sanitize all inputs.
     *
     * @return array
     */
    protected function sanitize()
    {
        return [
            'username' => $this->sanitizeUsername(),
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
            'roles' => trans('auth::roles.titles.roles')
        ];
    }

    /* -----------------------------------------------------------------
     |  Other Methods
     | -----------------------------------------------------------------
     */

    /**
     * Sanitize the username.
     *
     * @return string
     */
    protected function sanitizeUsername()
    {
        $username = $this->has('username')
            ? $this->get('username')
            : $this->get('first_name').' '.$this->get('last_name');

        return Str::slug($username, config('arcanesoft.auth.slug-separator', '.'));
    }

    /**
     * Get the email rule.
     *
     * @param  string  $column
     *
     * @return \Illuminate\Validation\Rules\Unique
     */
    protected function getEmailRule($column = 'email')
    {
        return Rule::unique($this->getUsersTable(), $column);
    }

    /**
     * Get the username rule.
     *
     * @param  string  $column
     *
     * @return \Illuminate\Validation\Rules\Unique
     */
    protected function getUsernameRule($column = 'username')
    {
        return Rule::unique($this->getUsersTable(), $column);
    }

    /**
     * Get the users table name.
     *
     * @return string
     */
    protected function getUsersTable()
    {
        return $this->getPrefixTable().config('arcanesoft.auth.users.table', 'users');
    }

    /**
     * Get the roles rule.
     *
     * @return array
     */
    protected function getRolesRule()
    {
        $rolesIds = Cache::remember('auth.roles.ids', 1, function () {
            return app(RoleContract::class)->pluck('id');
        });

        return ['required', 'array', 'min:1', 'in:'.$rolesIds->implode(',')];
    }
}
