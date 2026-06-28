<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsToMainWorkerBasicDetails extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('Worker.main_worker_basic_details', function (Blueprint $table) {
            $table->date('subscription_payment_date')->nullable();
            $table->string('subscription_amount_paid')->nullable();
//            $table->string('transaction_id')->nullable();
//            $table->string('ack_amount')->nullable();
//            $table->date('ack_payment_date')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('Worker.main_worker_basic_details', function (Blueprint $table) {
            $table->dropColumn(['subscription_payment_date', 'subscription_amount_paid']);
        });
    }
}
