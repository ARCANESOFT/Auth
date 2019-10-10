<?php

declare(strict_types=1);

namespace Arcanesoft\Auth\Http\Requests\Roles;

use Arcanesoft\Auth\Auth;
use Arcanesoft\Auth\Http\Requests\FormRequest;
use Arcanesoft\Auth\Http\Routes\RolesRoutes;
use Arcanesoft\Auth\Rules\Users\UniqueKey;
use Illuminate\Validation\Rule;

/**
 * Class     UpdateRoleRequest
 *
 * @package  Arcanesoft\Auth\Http\Requests\Roles
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class UpdateRoleRequest extends FormRequest
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
    public function rules(): array
    {
        $role = $this->getCurrentRole();

        return [
            'name'          => [
                'required', 'string', Rule::unique(Auth::table('roles'), 'name')->ignore($role->id), (new UniqueKey)->ignore($role->id),
            ],
            'description'   => [
                'required', 'string',
            ],
            'permissions.*' => [
                'nullable', 'string', Rule::exists(Auth::table('permissions'), 'uuid'),
            ],
        ];
    }

    /**
     * Get the validated data.
     *
     * @return array
     */
    public function getValidatedData(): array
    {
        return $this->all([
            'name',
            'description',
            'permissions',
        ]);
    }

    /**
     * Get the current role.
     *
     * @return \Arcanesoft\Auth\Models\Role|mixed
     */
    private function getCurrentRole()
    {
        return $this->route()->parameter(RolesRoutes::ROLE_WILDCARD);
    }
}
