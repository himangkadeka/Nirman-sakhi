<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTemporaryWorkerFormsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Worker.temporary_worker_forms', function (Blueprint $table) {
            $table->id();
            $table->string('worker_id')->unique();
            $table->string('phone_no');
            $table->string('application_no')->unique();
            $table->boolean('already_payment_status')->default(false);
            $table->string('previous_acknowledgement_number')->nullable();
            $table->unsignedBigInteger('district_id');
            $table->unsignedBigInteger('office_id');
            $table->unsignedBigInteger('already_registered')->nullable();
            $table->unsignedBigInteger('aadhaar_auth');
            $table->string('vaultToken',2000);
            $table->string('vaultPassKey',2000);
            $table->string('rtps_trans_id')->unique()->nullable();
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
        Schema::dropIfExists('Worker.temporary_worker_forms');
    }
}
