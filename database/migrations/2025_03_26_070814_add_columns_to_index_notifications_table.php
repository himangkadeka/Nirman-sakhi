<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsToIndexNotificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
{
    Schema::table('Content.index_notifications', function (Blueprint $table) {
        $table->smallInteger('category')->nullable()->after('id'); // Make category nullable
        $table->unsignedBigInteger('district_code')->nullable();
        $table->smallInteger('benefit_id')->nullable();
        $table->boolean('status')->default(true) ;// Make status nullable
        $table->integer('year')->nullable(); // year remains nullable

    });
}

public function down()
{
    Schema::table('Content.index_notifications', function (Blueprint $table) {
        $table->dropColumn(['category', 'status', 'year']);
    });
}

}
