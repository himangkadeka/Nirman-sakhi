<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWorkersWorkbookDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Worker.workers_workbook_details', function (Blueprint $table) {
            $table->id();
            $table->string('worker_id');
            $table->string('application_no');
            $table->unsignedBigInteger('type_of_work');
            $table->string('type_of_work_others')->nullable();
            $table->string('employer_name');
            $table->string('employer_contact_number');
            $table->string('from_date');
            $table->string('to_date');
            $table->unsignedBigInteger('date_count');
            $table->unsignedBigInteger('type_of_employer');
            $table->string('certificate_proof')->nullable();
            $table->unsignedBigInteger('profession');
            $table->string('profession_others')->nullable();
            $table->string('row_id')->nullable();
            $table->softDeletes();
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
        Schema::dropIfExists('Worker.workers_workbook_details');

    }
}
