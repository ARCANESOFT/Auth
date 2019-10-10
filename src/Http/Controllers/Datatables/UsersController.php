<?php

declare(strict_types=1);

namespace Arcanesoft\Auth\Http\Controllers\Datatables;

use Arcanesoft\Auth\Http\Transformers\UserTransformer;
use Arcanesoft\Auth\Repositories\UsersRepository;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

/**
 * Class     UsersController
 *
 * @package  Arcanesoft\Auth\Http\Controllers\Datatables
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class UsersController
{
    /* -----------------------------------------------------------------
     |  Main Methods
     | -----------------------------------------------------------------
     */

    public function index(DataTables $dataTables, UsersRepository $usersRepo, Request $request, bool $trash = false)
    {
        $query = $usersRepo->onlyTrashed($trash)
                           ->filterByAuthenticatedUser($request->user());

        return $dataTables->eloquent($query)
            ->setTransformer(new UserTransformer)
            ->make(true);
    }

    public function trash(DataTables $dataTables, UsersRepository $usersRepo, Request $request)
    {
        return $this->index($dataTables, $usersRepo, $request, true);
    }
}
