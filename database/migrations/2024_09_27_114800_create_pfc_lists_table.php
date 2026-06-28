<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePfcListsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('User.pfc_lists', function (Blueprint $table) {
            $table->id();
            $table->string('name_of_pfc');
            $table->string('pfc_name');
            $table->string('postal_address')->nullable();
            $table->string('pin_code')->nullable();
            $table->string('nearby_landmark')->nullable();
            $table->string('latitude')->nullable();
            $table->string('longitude')->nullable();
            $table->string('district_code')->nullable();
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
        Schema::dropIfExists('User.pfc_lists');
    }
}
