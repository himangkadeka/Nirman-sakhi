<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIsLoginCscToPfcKioskDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('Worker.pfc_kiosk_details', function (Blueprint $table) {
           $table->boolean('is_login_csc')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('Worker.pfc_kiosk_details', function (Blueprint $table) {
            //
        });
    }
}
