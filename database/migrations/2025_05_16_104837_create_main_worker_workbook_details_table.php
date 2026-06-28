<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMainWorkerWorkbookDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Worker.main_worker_workbook_details', function (Blueprint $table) {
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
        Schema::dropIfExists('Worker.main_worker_workbook_details');
    }
}
