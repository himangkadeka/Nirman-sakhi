<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEducationScholarshipApplicationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Benefit.education_scholarship_applications', function (Blueprint $table) {
            $table->id();
            $table->string('worker_id'); // Main Worker
            $table->unsignedBigInteger('family_member_id'); // The Student (Son/Daughter)

            // Section 1: Application Details
            $table->string('application_number')->unique();
            $table->date('application_date')->nullable();
            $table->unsignedBigInteger('district_id');

            // Section 2: Student & Course Details
            $table->string('student_name')->nullable(); // Auto-filled from family table
            $table->integer('student_age')->nullable();
            $table->date('student_dob')->nullable();
            $table->string('social_category')->nullable(); // SC/ST/OBC/General
            $table->text('parent_address')->nullable();

            $table->string('college_name')->nullable();
            $table->string('university_board')->nullable();
            $table->string('course_name')->nullable();
            $table->integer('course_duration_years')->nullable();
            $table->date('admission_date')->nullable();

            // Section 3: Academic Record (Previous Exam)
            $table->string('qualifying_exam_name')->nullable(); // e.g. HSLC
            $table->string('qualifying_exam_board')->nullable(); // e.g. SEBA
            $table->string('qualifying_exam_year')->nullable(); // Month & Year
            $table->json('exam_marks')->nullable(); // Stores Subject, Total, Obtained, % as JSON

            // Section 4: Bank & Contribution
            $table->boolean('parents_are_beneficiaries')->default(0)->nullable();
            $table->date('last_contribution_date')->nullable();
            $table->string('bank_name')->nullable();
            $table->string('branch_name')->nullable();
            $table->text('branch_address')->nullable();
            $table->string('ifsc_code')->nullable();
            $table->string('account_number')->nullable();

            // Section 5: Documents (Store File Paths)
            $table->string('doc_bank_passbook')->nullable();
            $table->string('doc_caste_certificate')->nullable();
            $table->string('doc_pass_certificate')->nullable(); // From Head of Institution
            $table->string('doc_study_certificate')->nullable(); // Stating currently studying
            $table->string('doc_admission_slip')->nullable();
            $table->string('doc_marksheet')->nullable();
            $table->string('doc_student_photo')->nullable();
            $table->string('doc_student_signature')->nullable();
            $table->string('doc_affidavit')->nullable();

            // System Fields
            $table->string('status')->default('DRAFT');
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
        Schema::dropIfExists('Benefit.education_scholarship_applications');
    }
}
