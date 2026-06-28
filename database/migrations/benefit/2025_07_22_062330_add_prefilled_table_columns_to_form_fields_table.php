<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPrefilledTableColumnsToFormFieldsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('Benefit.form_fields', function (Blueprint $table) {
            $table->string('prefilled_table_name')->nullable()->after('is_dependent_field');
            $table->text('prefilled_table_columns')->nullable()->after('prefilled_table_name');
            $table->text('prefilled_table_headers')->nullable()->after('prefilled_table_columns');
            // Optional: A column to define the relationship/filter condition
            $table->string('prefilled_table_condition_column')->nullable()->after('prefilled_table_headers');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('Benefit.form_fields', function (Blueprint $table) {
            $table->dropColumn([
                'prefilled_table_name',
                'prefilled_table_columns',
                'prefilled_table_headers',
                'prefilled_table_condition_column'
            ]);
        });
    }
}
