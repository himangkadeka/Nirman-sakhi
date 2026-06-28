<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddGroupAndSubRowToWorkersWorkbookDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('Worker.workers_workbook_details', function (Blueprint $table) {
            $table->unsignedInteger('group_id')
                ->nullable()
                ->after('row_id');

            $table->unsignedInteger('sub_row')
                ->default(0)
                ->after('group_id');

            $table->index(['worker_id', 'group_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('Worker.workers_workbook_details', function (Blueprint $table) {
            //
        });
    }
}
