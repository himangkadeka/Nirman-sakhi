<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBenefitsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Benefit.benefits', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('description');
            // $table->string('benefit_code')->unique();
            $table->boolean('status')->default(false);
            // $table->string('role_ids')->nullable();
            // $table->unsignedBigInteger('maximum_applications_per_worker')->nullable();
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
        Schema::dropIfExists('Benefit.benefits');
    }
}
