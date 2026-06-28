<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDocumentCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Masterdata.document_categories', function (Blueprint $table) {
            $table->id(); // Primary key (auto-increment)
            $table->string('category_name'); // VARCHAR for category name
            $table->boolean('status')->default(true); // 1 for active, 0 for inactive
            $table->timestamps(); // created_at and updated_at columns
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('Masterdata.document_categories');
    }
}
