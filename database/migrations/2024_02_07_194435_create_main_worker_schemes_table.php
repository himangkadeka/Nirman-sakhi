<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMainWorkerSchemesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Worker.main_worker_schemes', function (Blueprint $table) {
            $table->id();
            $table->string('worker_id');
            $table->string('application_no');
            $table->unsignedBigInteger('scheme_name')->nullable();
            $table->string('registration_id')->nullable();
            $table->string('date')->nullable();
            $table->unsignedBigInteger('enrolled')->nullable();
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
        Schema::dropIfExists('Worker.main_worker_schemes');
    }
}
