<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddGenderColumnToRelationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
       Schema::table('Masterdata.relations', function (Blueprint $table) {
            $table->string('gender')->nullable()->after('relation_name');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
         Schema::table('Masterdata.relations', function (Blueprint $table) {
            $table->dropColumn('gender');
        });
    }
}
