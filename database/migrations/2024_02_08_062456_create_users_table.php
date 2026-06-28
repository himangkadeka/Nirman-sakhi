<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('User.users', function (Blueprint $table) {
            $table->id();
            $table->string('username')->unique();
            $table->string('password');
            $table->string('firstname')->nullable();
            $table->string('lastname')->nullable();
            $table->string('phone');
            $table->string('email')->nullable();
            $table->bigInteger('role_id');
            $table->bigInteger('office_id')->nullable();
            $table->bigInteger('district')->nullable();
            $table->bigInteger('designation_id')->nullable();
            $table->bigInteger('status');
            $table->boolean('password_change_first_attempt')->nullable();
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
        Schema::dropIfExists('User.users');
    }


}
