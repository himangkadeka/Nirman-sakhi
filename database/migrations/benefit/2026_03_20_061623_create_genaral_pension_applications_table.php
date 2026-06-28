<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGenaralPensionApplicationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Benefit.genaral_pension_applications', function (Blueprint $table) {
            $table->id();
            $table->string('worker_id'); // Main Worker
            $table->unsignedBigInteger('family_member_id');
            $table->string('application_number')->unique();
            $table->date('application_date')->nullable();
            $table->unsignedBigInteger('district_id')->index();
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->text('applicant_address')->nullable();
            $table->date('last_contribution_date')->nullable();
            $table->date('applicant_dob')->nullable();
            $table->integer('applicant_age')->nullable();
            $table->date('date_of_60_years')->nullable();
            $table->string('recovered_loan_amount')->nullable()->comment('Amount or details of loan to be recovered');
            $table->json('family_members_details')->nullable();
            $table->text('pension_address')->nullable();
            $table->string('bank_name')->nullable();
            $table->string('bank_branch_name')->nullable();
            $table->string('account_number')->nullable();
            $table->string('mobile_number')->nullable();
            $table->string('doc_account_paybook')->nullable();
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
        Schema::dropIfExists('Benefit.genaral_pension_applications');
    }
}
