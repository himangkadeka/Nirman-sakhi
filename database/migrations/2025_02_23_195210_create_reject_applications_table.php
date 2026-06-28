<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRejectApplicationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Worker.reject_applications', function (Blueprint $table) {
            $table->id();
            $table->string('worker_id');
            $table->string('phone_no');
            $table->unsignedBigInteger('district');
            $table->string('status');
            $table->unsignedBigInteger('office_id')->nullable();
            $table->string('ack_no')->nullable();
            $table->string('application_no');
            $table->unsignedBigInteger('already_registered')->nullable();
            $table->string('payment_status')->default('success');
            $table->string('vaultToken',2000);
            $table->string('vaultPassKey',2000);
            $table->string('remarks')->nullable();
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
        Schema::dropIfExists('Worker.reject_applications');
    }
}
