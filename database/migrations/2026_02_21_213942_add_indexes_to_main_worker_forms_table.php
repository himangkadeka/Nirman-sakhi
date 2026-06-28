<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIndexesToMainWorkerFormsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('Worker.main_worker_forms', function (Blueprint $table) {

            // Phone number index
            $table->index('phone_no', 'mwf_phone_no_index');

            // Composite index for worker_id + already_registered
            $table->index(
                ['worker_id', 'already_registered'],
                'mwf_worker_registered_index'
            );

            // id_card index
            $table->index('id_card', 'mwf_id_card_index');

            // ack_no index
            $table->index('ack_no', 'mwf_ack_no_index');

            // id_card_expiry_date index
            $table->index('id_card_expiry_date', 'mwf_id_card_expiry_index');
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

            $table->dropIndex('mwf_phone_no_index');
            $table->dropIndex('mwf_worker_registered_index');
            $table->dropIndex('mwf_id_card_index');
            $table->dropIndex('mwf_ack_no_index');
            $table->dropIndex('mwf_id_card_expiry_index');
        });
    }
}
