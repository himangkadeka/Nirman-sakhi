<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRevertBacksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Worker.revert_backs', function (Blueprint $table) {
            $table->id();
            $table->string('worker_id');
            $table->string('phone_no');
            $table->unsignedBigInteger('district');
            $table->string('status');
            $table->unsignedBigInteger('office_id')->nullable();
            $table->unsignedBigInteger('revert_back')->nullable();
            $table->string('ack_no')->nullable();
            $table->string('application_no');
            $table->unsignedBigInteger('already_registered')->nullable();
            $table->unsignedBigInteger('active_status')->default(0);
            $table->string('expiry_date')->nullable();
            $table->string('renewal_date')->nullable();
            $table->string('payment_status')->default('pending');
            $table->string('vaultToken',2000);
            $table->string('vaultPassKey',2000);
            $table->text('reasons')->nullable();
            $table->unsignedBigInteger('application_type')->comment("1:New Register, 2:Renewal")->nullable();
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
        Schema::dropIfExists('Worker.revert_backs');
    }
}
