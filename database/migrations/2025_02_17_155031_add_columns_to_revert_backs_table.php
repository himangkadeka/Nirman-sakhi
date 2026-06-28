<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsToRevertBacksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('Worker.revert_backs', function (Blueprint $table) {
           $table->unsignedBigInteger('revert_back_status')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('Worker.revert_backs', function (Blueprint $table) {
            $table->dropColumn(['revert_back_status']);
        });
    }
}
