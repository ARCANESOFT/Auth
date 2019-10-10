<?php

use Arcanesoft\Auth\Auth;
use Arcanesoft\Auth\Database\Migration;
use Illuminate\Database\Schema\Blueprint;

/**
 * Class     CreateRolesTable
 *
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 *
 * @see  \Arcanesoft\Auth\Models\Role
 */
class CreateAuthRolesTable extends Migration
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

        $this->setTable(Auth::table('roles', 'roles', false));
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
            $table->uuid('uuid');

            $table->string('name');
            $table->string('key')->unique();
            $table->string('description')->nullable();
            $table->boolean('is_locked')->default(false);

            $table->timestamps();
            $table->timestamp('activated_at')->nullable();

            $table->index(['uuid', 'key']);
        });
    }
}
