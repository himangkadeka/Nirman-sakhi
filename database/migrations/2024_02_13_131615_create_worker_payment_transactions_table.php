<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWorkerPaymentTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Worker.worker_payment_transactions', function (Blueprint $table) {
            $table->id();
            $table->string('worker_id');
            $table->string('ack_no');
            $table->string('application_no');
            $table->timestamp('from_period')->nullable();
            $table->timestamp('to_period')->nullable();
            $table->float('fine')->nullable();
            $table->float('total_amount')->nullable();
            $table->string('transaction_id')->nullable();
            $table->string('status')->nullable();
            $table->unsignedBigInteger('office_id');
            $table->float('previous_dues')->nullable();
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

        Schema::dropIfExists('Worker.worker_payment_transactions');

    }
}
