<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTemporaryWorkerCertificatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Worker.temporary_worker_certificates', function (Blueprint $table) {
            $table->id();
            $table->string('worker_id');
            $table->string('application_no');
            $table->unsignedBigInteger('type_of_issuer')->nullable();
            $table->string('issuing_org')->nullable();
            $table->string('issue_date');
            $table->string('issuing_person')->nullable();
            $table->unsignedBigInteger('type_of_work');
            $table->string('type_of_work_others')->nullable();
            $table->string('contact_issuing_person')->nullable();
            $table->unsignedBigInteger('is_same')->nullable();
            $table->string('employer_name');
            $table->string('employer_contact_number');
            $table->string('from_date');
            $table->string('to_date');
            $table->unsignedBigInteger('date_count');
            $table->unsignedBigInteger('type_of_employer');
            $table->string('certificate_proof')->nullable();
            $table->unsignedBigInteger('profession')->nullable();
            $table->string('profession_others')->nullable();
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
        Schema::dropIfExists('Worker.temporary_worker_certificates');
    }
}
