<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWorkerIdCardsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Worker.worker_id_cards', function (Blueprint $table) {
            $table->id();
            $table->string('worker_id')->unique();
            $table->unsignedBigInteger('signature_status')->default(0);
            $table->longText('certificate')->nullable();
            $table->timestamp('certificate_upload_date')->nullable();
            $table->unsignedBigInteger('is_id_card_downloadble')->default(0);
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
        Schema::dropIfExists('Worker.worker_id_cards');
    }
}
