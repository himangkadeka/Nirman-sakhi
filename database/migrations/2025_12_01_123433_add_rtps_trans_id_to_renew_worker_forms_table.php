<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRtpsTransIdToRenewWorkerFormsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('Worker.renew_worker_forms', function (Blueprint $table) {
            $table->string('rtps_trans_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('Worker.renew_worker_forms', function (Blueprint $table) {
            //
        });
    }
}
