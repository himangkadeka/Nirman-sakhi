<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePostOfficesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Masterdata.post_offices', function (Blueprint $table) {
            $table->id('post_office_id');
            $table->string('post_office_name');
            $table->string('pin_code');
            $table->unsignedBigInteger('district_code');
            $table->unsignedBigInteger('state_code');
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
        Schema::dropIfExists('Masterdata.post_offices');
    }
}
