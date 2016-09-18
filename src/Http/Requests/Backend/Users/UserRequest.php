<?php namespace Arcanesoft\Auth\Http\Requests\Backend\Users;

use Arcanesoft\Auth\Bases\FormRequest;
use Cache;
use Illuminate\Support\Str;

/**
 * Class     UserRequest
 *
 * @package  Arcanesoft\Auth\Http\Requests\Backend\Users
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
abstract class UserRequest extends FormRequest
{
    /* ------------------------------------------------------------------------------------------------
     |  Main Functions
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Get all of the input and files for the request.
     *
     * @return array
     */
    public function all()
    {
        $username = Str::slug(
            $this->get('username'),
            config('arcanesoft.auth.slug-separator', '.')
        );

        return array_merge(parent::all(), compact('username'));
    }

    /* ------------------------------------------------------------------------------------------------
     |  Other Functions
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Get the roles rule.
     *
     * @return string
     */
    protected function getRolesRule()
    {
        return 'required|array|min:1|in:' . $this->getRoleIds()->implode(',');
    }

    /**
     * Get the role ids.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    private function getRoleIds()
    {
        return Cache::remember('auth.roles.ids', 5, function () {
            return app(\Arcanesoft\Contracts\Auth\Models\Role::class)->lists('id');
        });
    }
}
