<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFormSubmissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Benefit.form_submissions', function (Blueprint $table) {
            $table->id();
            $table->string('worker_id');
            $table->string('application_id')->unique();
            $table->foreignId('benefit_id')->constrained('Benefit.benefits')->onDelete('cascade');
            $table->timestamp('submitted_at')->nullable();
            $table->string('status')->nullable();
            $table->unsignedBigInteger('assigned_to_user_id')->nullable();
            $table->foreign('assigned_to_user_id')->references('id')->on('User.users');
            $table->string('application_type')->default('0')->comment('0: New, 1: Resubmitted');
            $table->string('batch_id')->nullable()->index();
            $table->string('lock_batch_number')->nullable();
            $table->decimal('sanctioned_amount', 10, 2)->nullable();
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
        Schema::dropIfExists('Benefit.form_submissions');
    }
}
