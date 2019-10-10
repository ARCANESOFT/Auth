<?php

declare(strict_types=1);

namespace Arcanesoft\Auth\Http\Controllers\Datatables;

use Arcanesoft\Auth\Http\Transformers\PasswordResetTransformer;
use Arcanesoft\Auth\Repositories\PasswordResetsRepository;
use Yajra\DataTables\DataTables;

/**
 * Class     PasswordResetsController
 *
 * @package  Arcanesoft\Auth\Http\Controllers\Datatables
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class PasswordResetsController
{
    /* -----------------------------------------------------------------
     |  Main Methods
     | -----------------------------------------------------------------
     */

    public function index(DataTables $dataTables, PasswordResetsRepository $repo)
    {
        $query = $repo->query();

        return $dataTables->eloquent($query)
            ->setTransformer(new PasswordResetTransformer)
            ->make(true);
    }
}
