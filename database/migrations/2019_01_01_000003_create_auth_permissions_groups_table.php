<?php

use Arcanesoft\Auth\Auth;
use Arcanesoft\Auth\Database\Migration;
use Illuminate\Database\Schema\Blueprint;

/**
 * Class     CreatePermissionsTable
 *
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 *
 * @see  \Arcanesoft\Auth\Models\PermissionsGroup
 */
class CreateAuthPermissionsGroupsTable extends Migration
{
    /* -----------------------------------------------------------------
     |  Constructor
     | -----------------------------------------------------------------
     */

    /**
     * Make a migration instance.
     */
    public function __construct()
    {
        parent::__construct();

        $this->setTable(Auth::table('permissions-groups', 'permissions_groups', false));
    }

    /* -----------------------------------------------------------------
     |  Main Methods
     | -----------------------------------------------------------------
     */

    /**
     * Run the migrations.
     */
    public function up()
    {
        $this->createSchema(function (Blueprint $table) {
            $table->increments('id');

            $table->string('name');
            $table->string('slug');
            $table->string('description')->nullable();

            $table->timestamps();

            $table->unique(['slug']);
        });
    }
}
