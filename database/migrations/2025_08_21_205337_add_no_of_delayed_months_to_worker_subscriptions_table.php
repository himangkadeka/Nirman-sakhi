<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNoOfDelayedMonthsToWorkerSubscriptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('Worker.worker_subscriptions', function (Blueprint $table) {
            $table->string('no_of_delayed_months')->default(0)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('Worker.worker_subscriptions', function (Blueprint $table) {
            //
        });
    }
}
