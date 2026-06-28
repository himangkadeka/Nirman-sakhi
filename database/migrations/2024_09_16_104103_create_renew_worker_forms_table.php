<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRenewWorkerFormsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Worker.renew_worker_forms', function (Blueprint $table) {
            $table->id();
            $table->string('worker_id')->unique();
            $table->string('phone_no');
            $table->unsignedBigInteger('district');
            $table->string('status');
            $table->string('renewal_date')->nullable();
            $table->unsignedBigInteger('office_id')->nullable();
            $table->unsignedBigInteger('pull_back')->nullable();
            $table->unsignedBigInteger('da_forward')->nullable();
            $table->unsignedBigInteger('revert_back')->nullable();
            $table->string('ack_no')->nullable();
            $table->string('application_no');
            $table->string('id_card')->nullable();
            $table->timestamp('id_card_created_at')->nullable();
            $table->unsignedBigInteger('already_registered')->nullable();
            $table->unsignedBigInteger('active_status')->default(0);
            $table->unsignedBigInteger('application_receiver_user_id')->nullable();
            $table->unsignedBigInteger('application_sender_user_id')->nullable();
            $table->string('subscription_status')->nullable();
//            $table->string('subscription_validity_date')->nullable();
            $table->string('last_subscription_date')->nullable();
//            $table->string('last_registration_date')->comment('old_register')->nullable();
            $table->string('id_card_expiry_date')->nullable();
            $table->string('next_renewal_date')->nullable();
            $table->string('payment_status')->nullable();
            $table->date('date_of_retirement')->nullable();
            $table->string('vaultToken',2000);
            $table->string('vaultPassKey',2000);
//            $table->unsignedBigInteger('application_type')->comment("1:New Register, 2:Renewal")->nullable();
            $table->string('rtps_trans_id')->unique()->nullable();
            $table->timestamp('ro_approval_time')->nullable();
            $table->timestamp('forward_to_da')->nullable();
            $table->timestamp('forward_to_ro')->nullable();
            $table->bigInteger('is_renewal')->nullable();
            $table->string('sender_role_id')->nullable();
            $table->string('application_receiver_role_id')->nullable();
            $table->bigInteger('resubmit_status')->default('0')->nullable();
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
        Schema::dropIfExists('Worker.renew_worker_forms');
    }
}
