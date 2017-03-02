<?php namespace Arcanesoft\Auth\Http\Requests;

use Arcanedev\Support\Bases\FormRequest as BaseFormRequest;

/**
 * Class     FormRequest
 *
 * @package  Arcanesoft\Auth\Http\Requests
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
abstract class FormRequest extends BaseFormRequest
{
    /* -----------------------------------------------------------------
     |  Properties
     | -----------------------------------------------------------------
     */
    /**
     * The message format.
     *
     * @var string
     */
    protected $errorsFormat = '<i class="fa fa-fw fa-exclamation-circle"></i> :message';

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
