<?php

declare(strict_types=1);

namespace Arcanesoft\Auth\Http\Transformers;

use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Support\Facades\Gate;
use League\Fractal\TransformerAbstract as Transformer;

/**
 * Class     AbstractTransformer
 *
 * @package  Arcanesoft\Auth\Http\Transformers
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
abstract class AbstractTransformer extends Transformer
{
    /* -----------------------------------------------------------------
     |  Common Methods
     | -----------------------------------------------------------------
     */

    /**
     * Render the action buttons.
     *
     * @param  array  $actions
     *
     * @return string
     */
    protected static function renderActions(array $actions)
    {
        return implode(PHP_EOL, array_map(function (Htmlable $action) {
            return $action->toHtml();
        }, $actions));
    }

    /**
     * Determine if all of the given abilities should be granted for the current user.
     *
     * @param  iterable|string  $abilities
     * @param  array|mixed      $arguments
     *
     * @return bool
     */
    protected static function can($abilities, $arguments = [])
    {
        return Gate::check($abilities, $arguments);
    }
}
