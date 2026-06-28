<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTemporaryWorkerAddressesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Worker.temporary_worker_addresses', function (Blueprint $table) {
            $table->id();
            $table->string('worker_id')->unique();
            $table->string('application_no');
            $table->unsignedBigInteger('c_residence');
            $table->unsignedBigInteger('c_house_type');
            $table->string('c_house_no')->nullable();
            $table->string('c_road')->nullable();
            $table->string('c_area');
            $table->string('c_city');
            $table->string('c_state');
            $table->string('c_district');
            $table->string('c_post_office');
            $table->string('c_pin');
            $table->string('c_circle');
            $table->string('landmark')->nullable();
            $table->string('building')->nullable();
            $table->unsignedBigInteger('do')->nullable();
            $table->unsignedBigInteger('type_of_document')->nullable();
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
        Schema::dropIfExists('Worker.temporary_worker_addresses');
    }
}
