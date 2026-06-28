<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCscListsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('User.csc_lists', function (Blueprint $table) {
            $table->id();
            $table->string('cscid')->nullable();
            $table->string('vlename')->nullable();
            $table->string('district')->nullable();
            $table->string('subdistrict')->nullable();
            $table->string('gp')->nullable();
            $table->string('village')->nullable();
            $table->string('locality')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('User.csc_lists');
    }

}
