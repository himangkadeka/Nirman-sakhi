<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMainWorkerBasicDetails extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Worker.main_worker_basic_details', function (Blueprint $table) {
            $table->id();
            $table->string('worker_id')->unique();
            $table->string('application_no');
            $table->string('old_name')->nullable();
            $table->string('old_care_of')->nullable();
            $table->date('old_dob')->nullable();
            $table->date('date_of_retirement');
            $table->unsignedBigInteger('maritial_status_id');
            $table->unsignedBigInteger('category');
            $table->unsignedBigInteger('gender_id')->nullable();
            $table->string('boc');
            $table->string('boc_no')->nullable();
            $table->string('eshram_no')->nullable();
            $table->unsignedBigInteger('education_id');
            $table->string('pf_no')->nullable();
            $table->string('esic_no')->nullable();
            $table->string('email')->nullable();
            $table->date('card_validity_date')->nullable();
            $table->date('last_registration_date')->nullable();
            $table->string('pan');
            $table->string('pan_no')->nullable();
            $table->unsignedBigInteger('state_id')->nullable();
            $table->unsignedBigInteger('other_state')->nullable();
            $table->unsignedBigInteger('skill_id')->nullable();
            $table->string('resident_type')->nullable();
            $table->string('has_ration_card');
            $table->string('ration_no')->nullable();
            $table->unsignedBigInteger('ration_type')->nullable();
            $table->unsignedBigInteger('blood_group')->nullable();
            $table->date('last_renewal_date')->nullable();
            $table->unsignedBigInteger('profession')->nullable();
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
        Schema::dropIfExists('Worker.main_worker_basic_details');
    }
}
