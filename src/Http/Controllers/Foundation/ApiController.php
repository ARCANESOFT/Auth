<?php namespace Arcanesoft\Auth\Http\Controllers\Foundation;

use Arcanedev\Support\Bases\Controller;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;

/**
 * Class     ApiController
 *
 * @package  Arcanesoft\Auth\Http\Controllers\Foundation
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class ApiController extends Controller
{
    /* ------------------------------------------------------------------------------------------------
     |  Traits
     | ------------------------------------------------------------------------------------------------
     */
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
}
