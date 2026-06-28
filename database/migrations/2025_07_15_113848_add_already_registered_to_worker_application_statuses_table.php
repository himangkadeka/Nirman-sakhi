<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAlreadyRegisteredToWorkerApplicationStatusesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('Worker.worker_application_statuses', function (Blueprint $table) {
            $table->bigInteger('already_registered')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('Worker.worker_application_statuses', function (Blueprint $table) {
            $table->dropColumn('already_registered');
        });
    }
}
