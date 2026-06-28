<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWorkerRenewalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Worker.worker_renewals', function (Blueprint $table) {
            $table->id();
            $table->string('worker_id');
            $table->string('ack_no');
            $table->string('id_card');
            $table->integer('renewal_fee');
            $table->string('office_id')->nullable();
            $table->integer('total_amount')->nullable();
            $table->integer('fine')->nullable();
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
        Schema::dropIfExists('Worker.worker_renewals');
    }
}
