<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMainWorkerEmployerDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Worker.main_worker_employer_details', function (Blueprint $table) {
            $table->id();
            $table->string('worker_id')->unique();
            $table->string('application_no');
            $table->tinyInteger('current_employer');
            $table->string('employer_name')->nullable();
            $table->unsignedBigInteger('board')->nullable();
            $table->unsignedBigInteger('type_of_work')->nullable();
            $table->string('workplace')->nullable();
            $table->string('mobile_no')->nullable();
            $table->unsignedBigInteger('district')->nullable();
            $table->unsignedBigInteger('subdistrict')->nullable();
            $table->string('city')->nullable();
            $table->string('pin_code')->nullable();
            $table->string('doj')->nullable();
            $table->unsignedBigInteger('nature_of_work')->nullable();
            $table->string('mgnrega_no')->nullable()->nullable();
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
        Schema::dropIfExists('Worker.main_worker_employer_details');
    }
}
