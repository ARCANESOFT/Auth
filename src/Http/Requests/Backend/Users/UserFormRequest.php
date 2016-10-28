<?php namespace Arcanesoft\Auth\Http\Requests\Backend\Users;

use Arcanesoft\Auth\Bases\FormRequest;
use Arcanesoft\Contracts\Auth\Models\Role as RoleContract;
use Cache;
use Illuminate\Support\Str;

/**
 * Class     UserFormRequest
 *
 * @package  Arcanesoft\Auth\Http\Requests\Backend\Users
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
abstract class UserFormRequest extends FormRequest
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
            'first_name' => 'required|min:2',
            'last_name'  => 'required|min:2',
            'roles'      => $this->getRolesRule(),
        ];
    }

    /**
     * Sanitize all inputs.
     *
     * @param  array  $inputs
     *
     * @return array
     */
    public function sanitize(array $inputs)
    {
        $inputs['username'] = $this->sanitizeUsername($inputs);

        return $inputs;
    }

    /* ------------------------------------------------------------------------------------------------
     |  Other Functions
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Sanitize the username.
     *
     * @param  array  $inputs
     *
     * @return string
     */
    protected function sanitizeUsername(array $inputs)
    {
        $username = $this->has('username')
            ? $inputs['username']
            : Str::limit($inputs['first_name'], 1, '.') . ' ' . $inputs['last_name'];

        return Str::slug($username, config('arcanesoft.auth.slug-separator', '.'));
    }

    /**
     * Get the roles rule.
     *
     * @return string
     */
    protected function getRolesRule()
    {
        $rolesIds = Cache::remember('auth.roles.ids', 1, function () {
            return app(RoleContract::class)->pluck('id');
        });

        return 'required|array|min:1|in:' . $rolesIds->implode(',');
    }
}
