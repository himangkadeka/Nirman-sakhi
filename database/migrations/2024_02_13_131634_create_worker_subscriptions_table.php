 --<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWorkerSubscriptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Worker.worker_subscriptions', function (Blueprint $table) {
            $table->id();
            $table->string('worker_id');
            $table->string('application_no');
            $table->string('ack_no');
            $table->string('id_card_no')->nullable();
            $table->string('office_id')->nullable();
            $table->string('transaction_id')->nullable();
            $table->string('total_amount')->nullable();
            $table->string('from_period')->nullable();
            $table->string('to_period')->nullable();
            $table->string('payment_status')->default('0');
            $table->string('month_paid')->default(3)->nullable();
            $table->string('amount_paid')->nullable();
            $table->string('year')->nullable();
            $table->integer('penalty_months')->default(0);
            $table->boolean('is_defaulted')->default(false);
            $table->string('subscription_type')->nullable();
            $table->string('last_subscription')->nullable();
            $table->string('fine')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('Worker.worker_subscriptions');
    }
}
