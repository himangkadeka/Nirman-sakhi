<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMaternityAssistanceApplicationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Benefit.maternity_assistance_applications', function (Blueprint $table) {
            $table->id();
            $table->string('worker_id'); // Main Worker
            $table->unsignedBigInteger('family_member_id'); // The Student (Son/Daughter)
            $table->string('application_number')->unique();
            $table->date('application_date')->nullable();
            $table->unsignedBigInteger('district_id')->index();
            $table->string('applicant_name')->nullable();
            $table->text('applicant_address')->nullable();
            $table->string('hospital_name')->nullable();
            $table->text('hospital_address')->nullable();
            $table->integer('applicant_age')->nullable();
            $table->date('applicant_dob')->nullable();
            $table->string('husband_name')->nullable();
            $table->date('date_of_confinement')->nullable();
            $table->enum('applied_earlier', ['Yes', 'No'])->nullable();
            $table->integer('times_applied_earlier')->nullable();
            $table->text('previous_application_details')->nullable();
            $table->date('last_contribution_date')->nullable();
            $table->string('bank_name')->nullable();
            $table->string('ifsc_code')->nullable();
            $table->text('branch_address')->nullable();
            $table->string('bank_account_number')->nullable();
            $table->string('doc_account_paybook')->nullable();
            $table->string('doc_medical_certificate')->nullable();
            $table->enum('status', ['Draft', 'Submitted', 'Under Review', 'Approved', 'Rejected'])->default('Draft');
            $table->text('remarks')->nullable()->comment('For administrative notes/rejection reasons');
            $table->timestamps();
            $table->softDeletes(); // Preserves data if accidentally deleted
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('maternity_assistance_applications');
    }
}
