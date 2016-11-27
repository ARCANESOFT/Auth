<?php namespace Arcanesoft\Auth\Http\Controllers\Front;

use Arcanedev\LaravelAuth\Services\UserImpersonator;

/**
 * Class     ImpersonateController
 *
 * @package  Arcanesoft\Auth\Http\Controllers\Front
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class ImpersonateController extends Controller
{
    /* ------------------------------------------------------------------------------------------------
     |  Main Functions
     | ------------------------------------------------------------------------------------------------
     */
    public function stop()
    {
        if (UserImpersonator::isImpersonating()) {
            UserImpersonator::stop();

            return redirect()->to('/');
        }

        return self::pageNotFound();
    }
}
