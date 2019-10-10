<?php

declare(strict_types=1);

namespace Arcanesoft\Auth\Http\Requests\Users;

use Arcanesoft\Auth\Http\Requests\FormRequest;

/**
 * Class     UserFormRequest
 *
 * @package  Arcanesoft\Auth\Http\Requests\Users
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
abstract class UserFormRequest extends FormRequest
{
    /* -----------------------------------------------------------------
     |  Main Methods
     | -----------------------------------------------------------------
     */

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
            'password',
            'roles',
        ]);
    }
}
