<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWorkerPaymentSuccess extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Worker.worker_payment_success', function (Blueprint $table) {
            $table->id();
            $table->string("worker_id");
            $table->unsignedBigInteger('payment_type');
            // $table->string('application_no');
            $table->string('DEPARTMENT_ID',40);
            $table->char('GRN',18)->nullable();
            $table->decimal('AMOUNT',14,2)->nullable();
            $table->char('BANKCODE',3)->nullable();
            $table->char('BANKCIN',20)->nullable();
            $table->char('PRN',100)->nullable();
            $table->string('TRANSCOMPLETIONDATETIME')->nullable();
            $table->char('STATUS',1)->nullable();
            $table->string('PARTYNAME',75)->nullable();
            $table->char('TAXID',25)->nullable();
            $table->string('BANKNAME',30)->nullable();
            $table->string('ENTRY_DATE')->nullable();
            $table->string('PORTAL_ENCDATA')->nullable();
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
        Schema::dropIfExists('Worker.worker_payment_success');
    }
}
