<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPaymentAcknowledgementSlipBasicDetails extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('Worker.temporary_worker_basic_details', function (Blueprint $table) {
            $table->string('payment_acknowledgement_slip')->after('profession_others')->nullable();
            $table->string('payment_acknowledgement_slip_ext')->after('profession_others')->nullable();
        });

        Schema::table('Worker.main_worker_basic_details', function (Blueprint $table) {
            $table->string('payment_acknowledgement_slip')->after('profession_others')->nullable();
            $table->string('payment_acknowledgement_slip_ext')->after('profession_others')->nullable();
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
            $table->dropColumn('payment_acknowledgement_slip');
            $table->dropColumn('payment_acknowledgement_slip_ext');
        });

        Schema::table('Worker.main_worker_basic_details', function (Blueprint $table) {
            $table->dropColumn('payment_acknowledgement_slip');
            $table->dropColumn('payment_acknowledgement_slip_ext');
        });
    }
}
