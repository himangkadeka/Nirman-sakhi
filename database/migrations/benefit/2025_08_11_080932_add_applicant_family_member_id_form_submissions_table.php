<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddApplicantFamilyMemberIdFormSubmissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('Benefit.form_submissions', function (Blueprint $table) {
            $table->unsignedBigInteger('applicant_family_member_id')->nullable()->after('benefit_id');
            $table->foreign('applicant_family_member_id')
                  ->references('id') // Assumes the primary key of the family table is 'id'
                  ->on('Worker.main_worker_families')
                  ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('Benefit.form_submissions', function (Blueprint $table) {
            $table->dropForeign(['applicant_family_member_id']);
            $table->dropColumn('applicant_family_member_id');
        });
    }
}
