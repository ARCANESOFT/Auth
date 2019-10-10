<?php

declare(strict_types=1);

namespace Arcanesoft\Auth\Http\Controllers\Datatables;

use Arcanesoft\Auth\Http\Transformers\RoleTransformer;
use Arcanesoft\Auth\Models\Role;
use Arcanesoft\Auth\Repositories\RolesRepository;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

/**
 * Class     RolesController
 *
 * @package  Arcanesoft\Auth\Http\Controllers\Datatables
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class RolesController
{
    /* -----------------------------------------------------------------
     |  Main Methods
     | -----------------------------------------------------------------
     */

    public function index(DataTables $dataTables, RolesRepository $rolesRepo, Request $request)
    {
        $query = $rolesRepo->with(['users'])
                           ->filterByAuthenticatedUser($request->user());

        return $dataTables->eloquent($query)
            ->setTransformer(new RoleTransformer)
            ->make(true);
    }
}
