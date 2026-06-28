<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIsInchargedToUserTransfersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('User.user_transfers', function (Blueprint $table) {
            $table->boolean('is_incharged')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('User.user_transfers', function (Blueprint $table) {
            $table->boolean('is_incharged')->nullable();
        });
    }
}
