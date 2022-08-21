<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNordigenApiTokenFieldsToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->text('nordigen_access_token')->nullable();
            $table->text('nordigen_refresh_token')->nullable();
            $table->dateTime('nordigen_access_expires')->nullable();
            $table->dateTime('nordigen_refresh_expires')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'nordigen_access_token',
                'nordigen_refresh_token',
                'nordigen_access_expires',
                'nordigen_refresh_expires',
            ]);
        });
    }
}
