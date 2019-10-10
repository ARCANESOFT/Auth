<?php

use Arcanesoft\Auth\Auth;
use Arcanesoft\Auth\Database\Migration;
use Illuminate\Database\Schema\Blueprint;

/**
 * Class     CreatePasswordResetsTable
 *
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 *
 * @see  \Arcanesoft\Auth\Models\PasswordReset
 */
class CreateAuthPasswordResetsTable extends Migration
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

        $this->setPrefix(null);
        $this->setTable(Auth::table('password-resets', 'password_resets', true));
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
            $table->string('email');
            $table->string('token');
            $table->timestamp('created_at')->nullable();

            $table->index(['email', 'token']);
        });
    }
}
