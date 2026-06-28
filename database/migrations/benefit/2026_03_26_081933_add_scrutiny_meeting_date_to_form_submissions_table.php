<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddScrutinyMeetingDateToFormSubmissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('Benefit.form_submissions', function (Blueprint $table) {
            $table->date('scrutiny_meeting_date')->nullable()->after('status');
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
            $table->dropColumn('scrutiny_meeting_date');
        });
    }
}
