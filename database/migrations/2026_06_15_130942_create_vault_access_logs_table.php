<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVaultAccessLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('User.vault_access_logs', function (Blueprint $table) {
            $table->id();

            $table->string('worker_id')->nullable();
            $table->unsignedBigInteger('family_id')->nullable();

            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('username')->nullable();

            $table->unsignedBigInteger('role_id')->nullable();
            $table->string('role_name')->nullable();

            $table->string('office_code')->nullable();
            $table->string('designation')->nullable();

            $table->string('module_name')->nullable();
            $table->string('action_type')->default('VIEW');

            $table->string('source')->nullable(); // CACHE/API

            $table->string('ip_address')->nullable();
            $table->text('user_agent')->nullable();

            $table->string('transaction_id')->nullable();

            $table->timestamp('accessed_at');
            $table->string('session_id')->nullable();
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
        Schema::dropIfExists('User.vault_access_logs');
    }
}
