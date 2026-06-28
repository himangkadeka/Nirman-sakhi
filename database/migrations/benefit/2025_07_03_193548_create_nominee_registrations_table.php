<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNomineeRegistrationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Benefit.nominee_registrations', function (Blueprint $table) {
            $table->id();
            $table->string('worker_id');
            $table->string('name');
            $table->string('phone');
            $table->longText('vault_token');
            $table->longText('valut_passkey');
            $table->integer('nominee_or_legal')->comment('0 for nominee ,1 for legal');
            $table->unsignedBigInteger('family_id')->unique()->nullable();
            $table->string('nominee_percentage')->nullable();
            $table->integer('status')->default(0);
            $table->integer('approved_by')->nullable();
            $table->timestamp('approved_at')->nullable();
            $table->integer('rejected_by')->nullable();
            $table->timestamp('rejected_at')->nullable();
            $table->longText('rejected_reason')->nullable();
            $table->string('uploaded_file_path')->nullable();
            $table->string('nomine_id')->unique()->nullable();
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
        Schema::dropIfExists('Benefit.nominee_registrations');
    }
}
