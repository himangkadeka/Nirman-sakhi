<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePpaBatchFilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Benefit.ppa_batch_files', function (Blueprint $table) {
            $table->id();
            $table->string('batch_id')->unique();
            $table->string('ppa_signed_by_accounts')->nullable();
            $table->timestamp('accounts_signed_at')->nullable();
            $table->string('ppa_signed_by_lc')->nullable();
            $table->timestamp('lc_signed_at')->nullable();
            $table->string('ppa_signed_by_lm')->nullable();
            $table->timestamp('lm_signed_at')->nullable();
            $table->string('transaction_id')->nullable();
            $table->timestamp('disbursed_at')->nullable();
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
        Schema::dropIfExists('Benefit.ppa_batch_files');
    }
}
