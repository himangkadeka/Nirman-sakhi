<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableCscKioskDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Worker.table_csc_kiosk_details', function (Blueprint $table) {
            $table->id();
            $table->string('csc_id');
            $table->string('email');
            $table->string('user_type');
            $table->string('service_id');
            $table->string('rtps_transaction_id');
            $table->string('merchant_id');
            $table->string('merchant_receipt_no');
            $table->string('txn_amount');
            $table->string('return_url');
            $table->string('cancel_url');
            $table->string('product_id');
            $table->string('merchant_txn');
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
        Schema::dropIfExists('Worker.table_csc_kiosk_details');

    }
}
