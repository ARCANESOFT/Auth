<?php

declare(strict_types=1);

namespace Arcanesoft\Auth\Http\Controllers\Datatables;

use Arcanesoft\Auth\Http\Transformers\PermissionTransformer;
use Arcanesoft\Auth\Repositories\PermissionsRepository;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

/**
 * Class     PermissionsController
 *
 * @package  Arcanesoft\Auth\Http\Controllers\Datatables
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class PermissionsController
{
    /* -----------------------------------------------------------------
     |  Main Methods
     | -----------------------------------------------------------------
     */

    public function index(DataTables $dataTables, PermissionsRepository $permissionsRepo, Request $request)
    {
        $query = $permissionsRepo->with(['group', 'roles' => function ($query) use ($request) {
            return $query->filterByAuthenticatedUser($request->user());
        }]);

        return $dataTables->eloquent($query)
            ->setTransformer(new PermissionTransformer)
            ->make(true);
    }
}
