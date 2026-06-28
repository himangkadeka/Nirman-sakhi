<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddResubmitStatusToMainWorkerForms extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('Worker.main_worker_forms', function (Blueprint $table) {
            $table->unsignedBigInteger('resubmit_status')->default(0)->after('active_status');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('Worker.main_worker_forms', function (Blueprint $table) {
            $table->dropColumn('resubmit_status');
        });
    }
}
