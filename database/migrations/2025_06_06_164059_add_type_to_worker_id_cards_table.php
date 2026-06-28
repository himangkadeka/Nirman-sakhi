<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTypeToWorkerIdCardsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('Worker.worker_id_cards', function (Blueprint $table) {
            $table->string('type')->nullable(); // Adds 'type' column
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('Worker.worker_id_cards', function (Blueprint $table) {
            $table->dropColumn('type'); // Rollback: removes the column
        });
    }
}
