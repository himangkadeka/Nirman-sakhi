<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTemporaryWorkerBanksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Worker.temporary_worker_banks', function (Blueprint $table) {
            $table->id();
            $table->string('worker_id')->unique();
            $table->string('application_no');
            $table->unsignedBigInteger('ifsc_pk');
            $table->string('bank_name');
            $table->string('branch_name');
            $table->string('bank_address');
            $table->string('account_no');
            $table->string('cnf_account_no')->nullable();
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
        Schema::dropIfExists('Worker.temporary_worker_banks');
    }
}
