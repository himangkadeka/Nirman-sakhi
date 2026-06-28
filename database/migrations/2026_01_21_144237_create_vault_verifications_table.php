<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVaultVerificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vault_verifications', function (Blueprint $table) {
            $table->id();
            $table->string('worker_id')->unique();
            $table->string('transaction_id')->nullable();
            $table->text('enc_response_data')->nullable(); // Store raw response for audit
            $table->text('decrypted_data')->nullable();    // Store decrypted result
            $table->string('status');                      // 'verified', 'retry', 'failed'
            $table->string('api_response_time')->nullable();
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
        Schema::dropIfExists('vault_verifications');
    }
}
