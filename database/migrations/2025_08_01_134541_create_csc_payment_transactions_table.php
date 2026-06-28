<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCscPaymentTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Worker.csc_payment_transactions', function (Blueprint $table) {
            $table->id();
            $table->string('csc_txn')->nullable();
            $table->string('merchant_id')->nullable();
            $table->string('csc_id')->nullable();
            $table->string('merchant_txn')->nullable();
            $table->string('txn_mode')->nullable();
            $table->string('txn_type')->nullable();
            $table->string('merchant_receipt_no')->nullable();
            $table->string('txn_status_message')->nullable();
            $table->string('status_message')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('Worker.csc_payment_transactions');
    }
}
