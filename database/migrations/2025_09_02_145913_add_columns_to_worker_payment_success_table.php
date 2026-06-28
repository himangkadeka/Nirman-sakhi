<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsToWorkerPaymentSuccessTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('Worker.worker_payment_success', function (Blueprint $table) {
            $table->char('merchant_id', 5)->nullable();
            $table->char('csc_id', 12)->nullable();
           $table->string('csc_txn_id')->nullable();
           $table->string('merchant_txn')->nullable();
           $table->dateTime('merchant_txn_datetime')->nullable();
            $table->char('product_id', 10)->nullable();
            $table->string('product_name', 32)->nullable();
           $table->string('txn_mode')->nullable();
           $table->integer('discount')->nullable();
           $table->string('merchant_receipt_no')->nullable();
           $table->string('error_code',50)->nullable();
           $table->string('error_message')->nullable();
           $table->string('bridge_response_message', 1000)->nullable();
           $table->string('enc_data',2000)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('Worker.worker_payment_success', function (Blueprint $table) {
            //
        });
    }
}
