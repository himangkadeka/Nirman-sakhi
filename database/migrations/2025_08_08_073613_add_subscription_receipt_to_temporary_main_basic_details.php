<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSubscriptionReceiptToTemporaryMainBasicDetails extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('Worker.temporary_worker_basic_details', function (Blueprint $table) {
            $table->unsignedBigInteger('subscription_receipt')->after('subscription_amount_paid')->nullable();
        });

        Schema::table('Worker.main_worker_basic_details', function (Blueprint $table) {
           $table->unsignedBigInteger('subscription_receipt')->after('subscription_amount_paid')->nullable();
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
            $table->dropColumn('subscription_receipt');
        });

        Schema::table('Worker.main_worker_basic_details', function (Blueprint $table) {
            $table->dropColumn('subscription_receipt');
        });
    }
}
