<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHoForwardingDocumentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Benefit.ho_forwarding_documents', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('office_id');
            $table->foreignId('user_id')->constrained('User.users')->onDelete('cascade');
            $table->string('meeting_minutes_path');
            $table->string('attendance_sheet_path');
            $table->string('accepted_list_path');
            $table->string('rejected_list_path');
            $table->date('submission_date');
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
        Schema::dropIfExists('Benefit.ho_forwarding_documents');
    }
}
