<?php namespace Arcanesoft\Auth\Http\Controllers\Front;

use Arcanedev\Support\Bases\Controller as BaseController;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;

/**
 * Class     Controller
 *
 * @package  Arcanesoft\Auth\Http\Controllers\Front
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
abstract class Controller extends BaseController
{
    /* ------------------------------------------------------------------------------------------------
     |  Traits
     | ------------------------------------------------------------------------------------------------
     */
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
}
