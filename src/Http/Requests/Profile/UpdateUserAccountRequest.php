<?php

declare(strict_types=1);

namespace Arcanesoft\Auth\Http\Requests\Profile;

use Arcanesoft\Auth\Http\Requests\FormRequest;
use Arcanesoft\Auth\Rules\Users\UserEmailRule;

/**
 * Class     UpdateUserAccountRequest
 *
 * @package  Arcanesoft\Auth\Http\Requests\Profile
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class UpdateUserAccountRequest extends FormRequest
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
        return [
            'first_name' => ['required', 'string', 'max:50'],
            'last_name'  => ['required', 'string', 'max:50'],
            'email'      => ['required', 'string', 'email', 'max:255', UserEmailRule::unique()->ignore($this->user()->id)],
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
            'first_name',
            'last_name',
            'email',
        ]);
    }
}
