<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddBenefitCodeToBenefitsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('Benefit.benefits', function (Blueprint $table) {
            $table->string('benefit_code')->unique();
            $table->string('role_ids')->nullable();
            $table->unsignedBigInteger('maximum_applications_per_worker')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('Benefit.benefits', function (Blueprint $table) {
            $table->dropIfExists('benefit_code');
            $table->string('role_ids')->nullable();
            $table->dropIfExists('role_ids');
            $table->dropIfExists('maximum_applications_per_worker');
        });
    }
}
