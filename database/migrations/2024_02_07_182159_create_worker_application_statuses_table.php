<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWorkerApplicationStatusesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Worker.worker_application_statuses', function (Blueprint $table) {
            $table->id();
            $table->string('application_status');
            $table->string('remarks');
            $table->string('worker_id');
            $table->string('ack_no');
            $table->string('application_no');
            $table->unsignedBigInteger('sender_role_id')->nullable();
            $table->unsignedBigInteger('sender_user_id')->nullable();
            $table->unsignedBigInteger('sender_office_id')->nullable();
            $table->string('application_from_user')->nullable();
            $table->unsignedBigInteger('application_receiver_user_id')->nullable();
            $table->unsignedBigInteger('application_receiver_role_id')->nullable();
            $table->unsignedBigInteger('service_id')->nullable();
            $table->timestamp('expiry')->nullable();
            $table->unsignedBigInteger('pull_back')->nullable();
            $table->unsignedBigInteger('revert_back')->nullable();
            $table->unsignedBigInteger('re_route')->nullable();
            $table->timestamp('re_route_time')->nullable();
            $table->timestamp('ro_approval_time')->nullable();
            $table->timestamp('forward_to_da')->nullable();
            $table->timestamp('forward_to_ro')->nullable();
            $table->text('reasons')->nullable();
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
        Schema::dropIfExists('Worker.worker_application_statuses');
    }
}
