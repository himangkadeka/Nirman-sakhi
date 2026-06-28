<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIsRenewalToWorkerApplicationStatusesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('Worker.worker_application_statuses', function (Blueprint $table) {
            $table->bigInteger('is_renewal')->default('0');
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
            Schema::dropIfExists('Worker.worker_application_statuses');
        });
    }
}
