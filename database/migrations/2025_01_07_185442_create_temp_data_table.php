<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTempDataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Worker.temp_data', function (Blueprint $table) {
            $table->id();
            $table->string('old_name')->nullable();
            $table->string('old_fathers_name')->nullable();
            $table->unsignedBigInteger('old_gender')->nullable();
            $table->date('old_dob')->nullable();
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
        Schema::dropIfExists('Worker.temp_data');
    }
}
