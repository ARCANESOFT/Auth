<?php

declare(strict_types=1);

namespace Arcanesoft\Auth\Http\Transformers;

use Arcanesoft\Auth\Models\PasswordReset;
use function ui\action_link_icon;

/**
 * Class     PasswordResetTransformer
 *
 * @package  Arcanesoft\Auth\Http\Transformers
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class PasswordResetTransformer extends AbstractTransformer
{
    /* -----------------------------------------------------------------
     |  Main Methods
     | -----------------------------------------------------------------
     */

    /**
     * Transform the response.
     *
     * @param  \Arcanesoft\Auth\Models\PasswordReset  $reset
     *
     * @return array
     */
    public function transform(PasswordReset $reset): array
    {
        return [
            'email'      => $reset->email,
            'created_at' => '<small>'.$reset->created_at.'</small>',
            'actions'     => static::renderActions([
                //action_link_icon('show', route('admin::auth.password-resets.show', [$reset]))->size('sm'),
            ]),
        ];
    }
}
