<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWorkerIdCardsHistoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Worker.worker_id_cards_history', function (Blueprint $table) {
            $table->id();
            $table->string('worker_id');
            $table->bigInteger('id_card_status')->nullable();
            $table->integer('signature_status')->nullable();
            $table->longText('certificate')->nullable();
            $table->timestamp('certificate_upload_date')->nullable();
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
        Schema::dropIfExists('Worker.worker_id_cards_history');
    }
}
