<?php namespace Arcanesoft\Auth\Http\Requests\Backend\Users;

use Arcanesoft\Auth\Bases\FormRequest;
use Illuminate\Support\Facades\Cache;

/**
 * Class     CreateUserRequest
 *
 * @package  Arcanesoft\Auth\Http\Requests\Backend\Users
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class CreateUserRequest extends FormRequest
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
        'username'              => 'required|min:3|unique:users,username',
        'email'                 => 'required|email|unique:users,email',
        'first_name'            => 'required|min:2',
        'last_name'             => 'required|min:2',
        'password'              => 'required|min:8|confirmed',
        'password_confirmation' => 'required|min:8',
        'roles'                 => 'required|array|min:1',
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
        $rules = $this->rules;

        $rules['roles'] .= '|in:' . $this->getRoleIds()->implode(',');

        return $rules;
    }

    /**
     * {@inheritdoc}
     */
    public function all()
    {
        return array_merge(parent::all(), [
            'username' => str_slug($this->get('username'))
        ]);
    }

    /* ------------------------------------------------------------------------------------------------
     |  Other Functions
     | ------------------------------------------------------------------------------------------------
     */
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
