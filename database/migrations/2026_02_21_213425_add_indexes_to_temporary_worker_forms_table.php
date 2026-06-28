<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIndexesToTemporaryWorkerFormsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('Worker.temporary_worker_forms', function (Blueprint $table) {
            $table->index('phone_no', 'twf_phone_no_index');

            // Composite index on worker_id + already_registered
            $table->index(
                ['worker_id', 'already_registered'],
                'twf_worker_registered_index'
            );
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('temporary_worker_forms', function (Blueprint $table) {
            //
        });
    }
}
