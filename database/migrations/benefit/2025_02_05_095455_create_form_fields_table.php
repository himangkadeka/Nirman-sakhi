<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFormFieldsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Benefit.form_fields', function (Blueprint $table) {
            $table->id();
            $table->foreignId('benefit_id')->constrained('Benefit.benefits')->onDelete('cascade');
            $table->string('name');
            $table->string('type')->comment('text,number,select');
            $table->string('masterdata_table')->nullable();
            $table->boolean('use_masterdata')->nullable();
            $table->string('masterdata_table_key')->nullable();
            $table->string('masterdata_table_value')->nullable();
            $table->string('masterdata_table_condition')->nullable();
            $table->string('validation_rules');
            $table->string('error_messages');
            $table->text('options')->nullable();
            $table->integer('order')->default(0);
            $table->boolean('use_prefilled_data')->default(0);
            $table->integer('prefilled_data_type')->nullable()->comment('1: VaultData, 2: Worker Table Data');
            $table->string('prefilled_vault_data_key')->nullable();
            $table->string('prefilled_worker_data_table')->nullable();
            $table->string('prefilled_worker_data_key')->nullable();
            $table->boolean('use_masterdata_value')->nullable()->default(0);
            $table->string('masterdata_value_table')->nullable();
            $table->string('masterdata_value_table_key')->nullable();
            $table->string('masterdata_value_table_value')->nullable();
            $table->boolean('is_required')->default(0);
            $table->boolean('is_readonly')->default(0);
            $table->boolean('is_hidden')->default(0);
            $table->boolean('is_disabled')->default(0);
            $table->boolean('is_dependent_field')->default(false);
            $table->foreignId('dependent_field_id')->nullable()->constrained('Benefit.form_fields')->onDelete('cascade');
            $table->string('dependent_field_value')->nullable();
            $table->boolean('status')->default(1);
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
        Schema::dropIfExists('Benefit.form_fields');
    }
}
