<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsToMainWorkerForms extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('Worker.main_worker_forms', function (Blueprint $table) {
            $table->string('ack_transaction_id')->nullable();
            $table->date('ack_payment_date')->nullable();
            $table->string('ack_payment_amount')->nullable();
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
            $table->dropColumn(['ack_transaction_id', 'ack_payment_date','ack_payment_amount']);
        });
    }
}
