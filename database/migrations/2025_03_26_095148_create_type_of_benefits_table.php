<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTypeOfBenefitsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Masterdata.type_of_benefits', function (Blueprint $table) {
            $table->id(); // Auto-incremented ID
            $table->string('benefit_name'); // Benefit Name
            // $table->text('details_of_benefit')->nullable(); // Details of the Benefit
            // $table->text('eligibility_criteria')->nullable(); // Eligibility Criteria
            // $table->text('documents_required')->nullable(); // Documents Required
            // $table->decimal('benefit_amount', 10, 2)->nullable(); // Benefit Amount
            // $table->string('e_services')->nullable(); // E-services URL or info
            // $table->boolean('status')->nullable() ;// Make status nullable
            $table->boolean('status')->default(true); // 1 for active, 0 for inactive
            $table->timestamps(); // Created_at and updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('type_of_benefits');
    }
}
