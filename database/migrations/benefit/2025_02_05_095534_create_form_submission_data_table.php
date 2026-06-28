<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFormSubmissionDataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Benefit.form_submission_data', function (Blueprint $table) {
            $table->id();
            $table->foreignId('form_submission_id')->constrained('Benefit.form_submissions')->onDelete('cascade');
            $table->foreignId('form_field_id')->constrained('Benefit.form_fields')->onDelete('cascade');  // reference to field
            $table->text('value');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('Benefit.form_submission_data');
    }
}
