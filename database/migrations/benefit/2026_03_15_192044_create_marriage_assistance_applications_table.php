<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMarriageAssistanceApplicationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Benefit.marriage_assistance_applications', function (Blueprint $table) {
            $table->id();
            $table->string('worker_id'); // Main Worker
            $table->unsignedBigInteger('family_member_id'); // The Student (Son/Daughter)
            $table->string('application_number')->unique();
            $table->date('application_date')->nullable();
            $table->unsignedBigInteger('district_id')->index();
            $table->string('applicant_name')->nullable();
            $table->text('applicant_address')->nullable();
            $table->date('applicant_dob')->nullable();
            $table->integer('applicant_age')->nullable();
            $table->integer('social_category')->nullable();
            $table->date('last_contribution_date')->nullable();
            $table->string('membership_duration')->nullable(); // e.g., "3 Years 2 Months"

            // Core Conditional Toggle
            $table->enum('is_for_son_daughter', ['Yes', 'No'])->comment('Yes: Son/Daughter, No: Self')->nullable();

            // 2. Marriage of Son / Daughter Details (Nullable)
            $table->enum('spouse_is_beneficiary', ['Yes', 'No'])->nullable();
            $table->string('spouse_reg_details')->nullable();
            $table->enum('spouse_applied_assistance', ['Yes', 'No'])->nullable();
            $table->date('child_dob')->nullable();
            $table->string('child_spouse_name')->nullable();
            $table->text('child_spouse_address')->nullable();
            $table->date('child_marriage_date')->nullable();
            $table->integer('child_marriage_number')->nullable();
            $table->date('child_marriage_cert_date')->nullable();
            $table->string('child_marriage_cert_no')->nullable();
            $table->string('child_marriage_cert_authority')->nullable();
            $table->text('child_marriage_cert_auth_address')->nullable();
            $table->text('other_child_assistance_details')->nullable();

            // 3. Marriage of Self (Female Worker Only) Details (Nullable)
            $table->string('self_bridegroom_name')->nullable();
            $table->date('self_marriage_date')->nullable();
            $table->string('self_marriage_place')->nullable();
            $table->text('self_bridegroom_address')->nullable();
            $table->date('self_marriage_cert_date')->nullable();
            $table->string('self_marriage_cert_no')->nullable();
            $table->string('self_marriage_cert_authority')->nullable();
            $table->text('self_marriage_cert_auth_address')->nullable();

            // 4. Other Details
            $table->enum('received_other_assistance', ['Yes', 'No'])->nullable();

            // 5. Attachments (File Paths)
            $table->string('doc_bank_passbook')->nullable(); // Nullable for Draft saves
            $table->string('doc_invitation_card')->nullable();
            $table->string('doc_age_proof')->nullable();
            $table->string('doc_marriage_certificate')->nullable(); // Conditional based on form
            $table->string('doc_photographs')->nullable();
            $table->string('doc_signatures')->nullable();

            // Application Status & Tracking
            $table->enum('status', ['Draft', 'Submitted', 'Under Review', 'Approved', 'Rejected'])->default('Draft');
            $table->text('remarks')->nullable()->comment('For admin rejection/approval notes');

            $table->softDeletes(); // Useful so you don't accidentally lose user applications
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
        Schema::dropIfExists('marriage_assistance_applications');
    }
}
