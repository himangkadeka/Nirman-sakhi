<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMainWorkerBanksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Worker.main_worker_banks', function (Blueprint $table) {
            $table->id();
            $table->string('worker_id')->unique();
            $table->string('application_no');
            $table->unsignedBigInteger('ifsc_pk');
            $table->string('bank_name');
            $table->string('branch_name');
            $table->string('bank_address');
            $table->string('micr')->nullable();
            $table->string('account_no')->nullable();
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
        Schema::dropIfExists('Worker.main_worker_banks');
    }
}
