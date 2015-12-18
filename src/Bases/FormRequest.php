<?php namespace Arcanesoft\Auth\Bases;

use Arcanedev\Support\Bases\FormRequest as BaseFormRequest;
use Illuminate\Contracts\Validation\Validator;

/**
 * Class     FormRequest
 *
 * @package  Arcanesoft\Auth\Bases
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
abstract class FormRequest extends BaseFormRequest
{
    /* ------------------------------------------------------------------------------------------------
     |  Properties
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * The message format.
     *
     * @var string
     */
    protected $messageFormat = '<i class="fa fa-fw fa-exclamation-circle"></i> :message';

    /* ------------------------------------------------------------------------------------------------
     |  Main Functions
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * {@inheritdoc}
     */
    protected function formatErrors(Validator $validator)
    {
        $errors   = [];
        $messages = $validator->getMessageBag();

        foreach ($messages->keys() as $key) {
            $errors[$key] = $messages->get($key, $this->messageFormat);
        }

        return $errors;
    }
}
