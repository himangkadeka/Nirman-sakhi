<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTemporaryWorkerFamiliesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Worker.temporary_worker_families', function (Blueprint $table) {
            $table->id();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('guardain_name')->nullable();
            $table->string('dob');
            $table->unsignedBigInteger('relation');
            $table->string('relation_others')->nullable();
            $table->unsignedBigInteger('profession')->nullable();
            $table->unsignedBigInteger('education')->nullable();
            $table->string('nominee');
            $table->string('already_registered')->nullable();
            $table->string('bocwwb_id')->nullable();
            $table->string('nominee_percentage')->nullable();
            $table->string('worker_id');
            $table->string('application_no');
            $table->unsignedBigInteger('already_registered_state')->nullable();
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
        Schema::dropIfExists('Worker.temporary_worker_families');
    }
}
