<?php namespace Arcanesoft\Auth\Http\Requests;

use Arcanedev\Support\Http\FormRequest as BaseFormRequest;

/**
 * Class     FormRequest
 *
 * @package  Arcanesoft\Auth\Http\Requests
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
abstract class FormRequest extends BaseFormRequest
{
    /* -----------------------------------------------------------------
     |  Other Methods
     | -----------------------------------------------------------------
     */

    /**
     * Get the database connection.
     *
     * @return string
     */
    protected function getDbConnection()
    {
        return config('arcanesoft.auth.database.connection', null);
    }

    /**
     * Get the table's prefix.
     *
     * @return string
     */
    protected function getPrefixTable()
    {
        return config('arcanesoft.auth.database.prefix', 'auth_');
    }
}
