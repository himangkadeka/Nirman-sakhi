<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddProfessionOthersToTemporaryAndMainBasic extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('Worker.temporary_worker_basic_details', function (Blueprint $table) {
            $table->string('profession_others')->after('profession')->nullable();
        });

        Schema::table('Worker.main_worker_basic_details', function (Blueprint $table) {
            $table->string('profession_others')->after('profession')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('Worker.temporary_worker_basic_details', function (Blueprint $table) {
            $table->dropColumn('profession_others');
        });

        Schema::table('Worker.main_worker_basic_details', function (Blueprint $table) {
            $table->dropColumn('profession_others');
        });
    }
}
