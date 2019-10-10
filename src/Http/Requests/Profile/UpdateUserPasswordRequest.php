<?php

declare(strict_types=1);

namespace Arcanesoft\Auth\Http\Requests\Profile;

use Arcanesoft\Auth\Http\Requests\FormRequest;

/**
 * Class     UpdateUserPasswordRequest
 *
 * @package  Arcanesoft\Auth\Http\Requests\Profile
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class UpdateUserPasswordRequest extends FormRequest
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
            'old_password' => ['required', 'string', 'min:8', 'password'],
            'password'     => ['required', 'string', 'min:8', 'different:old_password', 'confirmed'],
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
            'password',
        ]);
    }
}
