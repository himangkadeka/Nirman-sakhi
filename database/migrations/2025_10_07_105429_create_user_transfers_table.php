<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserTransfersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('User.user_transfers', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id');
            $table->string('username');
            $table->string('firstname');
            $table->string('lastname');
            $table->string('phone');
            $table->string('email');
            $table->unsignedBigInteger('designation');
            $table->unsignedBigInteger('role');
            $table->boolean('is_retired')->nullable();
            $table->timestamp('retired_at')->nullable();
            $table->unsignedBigInteger('transfer_from_district')->nullable();
            $table->unsignedBigInteger('transfer_to_district')->nullable();
            $table->unsignedBigInteger('transfer_from_office')->nullable();
            $table->unsignedBigInteger('transfer_to_office')->nullable();
            $table->timestamp('tenure_end_date')->nullable();
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
        Schema::dropIfExists('User.user_transfers');
    }
}
