<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOldWorkersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return voidaccount_no
     */
    public function up()
    {
        Schema::create('Worker.old_workers', function (Blueprint $table) {
            $table->id();
            $table->string('worker_id')->unique();
            $table->string('Name')->nullable();
            $table->string('father_husband')->nullable();
            $table->string('dob')->nullable();
            $table->unsignedBigInteger('district')->nullable();
            $table->string('pin')->nullable();
            $table->string('account_no')->nullable();
            $table->unsignedBigInteger('gender')->nullable();
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
        Schema::dropIfExists('Worker.old_workers');
    }
}
