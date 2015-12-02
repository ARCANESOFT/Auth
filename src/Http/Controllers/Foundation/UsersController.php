<?php namespace Arcanesoft\Auth\Http\Controllers\Foundation;

use Arcanesoft\Auth\Bases\FoundationController;

/**
 * Class     UsersController
 *
 * @package  Arcanesoft\Auth\Http\Controllers\Foundation
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class UsersController extends FoundationController
{
    /* ------------------------------------------------------------------------------------------------
     |  Main Functions
     | ------------------------------------------------------------------------------------------------
     */
    public function index()
    {
        return $this->view('foundation.users.list');
    }

    public function create()
    {
        return $this->view('foundation.users.create');
    }

    public function store()
    {
        //
    }

    public function show($userId)
    {
        return $this->view('foundation.users.show');
    }

    public function edit($userId)
    {
        return $this->view('foundation.users.edit');
    }

    public function update($userId)
    {
        //
    }

    public function delete($userId)
    {
        //
    }
}
