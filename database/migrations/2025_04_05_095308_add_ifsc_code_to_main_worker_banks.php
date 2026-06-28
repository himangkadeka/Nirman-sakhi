<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIfscCodeToMainWorkerBanks extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('Worker.main_worker_banks', function (Blueprint $table) {
            $table->string('ifsc_code')->nullable()->after('cnf_account_no');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('Worker.main_worker_banks', function (Blueprint $table) {
            $table->string('ifsc_code')->nullable()->after('cnf_account_no');
        });
    }
}
