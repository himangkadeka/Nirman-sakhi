<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIdCardExpiryDateIndexToMainWorkerFormsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('Worker.main_worker_forms', function (Blueprint $table) {
            $table->index('id_card_expiry_date');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('Worker.main_worker_forms', function (Blueprint $table) {
            $table->dropIndex('id_card_expiry_date');
        });
    }
}
