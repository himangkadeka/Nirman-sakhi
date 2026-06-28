<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePfcKioskDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Worker.pfc_kiosk_details', function (Blueprint $table) {
            $table->id();
            $table->string('rtps_trans_id')->unique();
            $table->string('user_id');
            $table->string('service_id');
            $table->string('portal_no');
            $table->string('mobile');
            $table->string('process');
            $table->string('user_type')->nullable();
            $table->string('response_url');
            $table->string('kiosk_email')->nullable();
            $table->string('kiosk_name')->nullable();
            $table->string('kiosk_registration_id')->nullable();
            $table->string('office_address')->nullable();
            $table->string('worker_id')->nullable();
            $table->string('is_worker_registered');
            $table->boolean('isLoginWithPfc');
            // $table->boolean('transaction_status')->nullable();
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
        Schema::dropIfExists('Worker.pfc_kiosk_details');
    }
}
