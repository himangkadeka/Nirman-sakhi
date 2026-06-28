<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTemporaryWorkerEmployerDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Worker.temporary_worker_employer_details', function (Blueprint $table) {
            $table->id();
            $table->string('worker_id');
            $table->string('application_no');
            $table->tinyInteger('current_employer');
            $table->string('employer_name')->nullable();
            $table->unsignedBigInteger('type_of_employer')->nullable();
            $table->unsignedBigInteger('type_of_work')->nullable();
            $table->string('workplace')->nullable();
            $table->string('employer_address')->nullable();
            $table->string('mobile_no')->nullable();
            $table->string('date_of_joining')->nullable();
            $table->unsignedBigInteger('nature_of_work')->nullable();

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
        Schema::dropIfExists('Worker.temporary_worker_employer_details');
    }
}
