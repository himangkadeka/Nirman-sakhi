<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMedicalAssistanceApplicationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Benefit.medical_assistance_applications', function (Blueprint $table) {
            $table->id();
            $table->string('worker_id'); // Main Worker
            $table->unsignedBigInteger('family_member_id');
            $table->string('application_number')->unique();
            $table->date('application_date')->nullable();
            $table->unsignedBigInteger('district_id')->index();
            $table->string('applicant_name')->nullable();
            $table->text('applicant_address')->nullable();
            $table->integer('applicant_age')->nullable();
            $table->date('applicant_dob')->nullable();
            $table->enum('social_category', ['SC', 'ST', 'OBC', 'General'])->nullable();
            $table->date('last_contribution_date')->nullable();
            $table->text('medical_condition_details')->nullable();
            $table->text('disability_details')->nullable();
            $table->string('hospital_name')->nullable();
            $table->text('hospital_address')->nullable();
            $table->integer('treatment_period_days')->nullable();
            $table->date('admission_date')->nullable();
            $table->date('discharge_date')->nullable();
            $table->text('previous_benefits_details')->nullable();
            $table->string('bank_name')->nullable();
            $table->string('ifsc_code')->nullable();
            $table->text('branch_address')->nullable();
            $table->string('account_number')->nullable();
            $table->string('doc_account_paybook')->nullable();
            $table->string('doc_accident_report')->nullable();
            $table->string('doc_treatment_documents')->nullable();
            $table->string('doc_affected_person_photograph')->nullable();
            $table->string('doc_disability_certificate')->nullable();
            $table->enum('status', ['Draft', 'Submitted', 'Under Review', 'Approved', 'Rejected'])->default('Draft');
            $table->text('remarks')->nullable()->comment('For administrative notes/rejection reasons')->nullable();
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
        Schema::dropIfExists('medical_assistance_applications');
    }
}
