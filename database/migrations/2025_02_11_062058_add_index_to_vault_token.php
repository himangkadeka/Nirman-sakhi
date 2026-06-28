<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class AddIndexToVaultToken extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('Worker.vault_data', function (Blueprint $table) {
            $table->index('vault_token', 'idx_vault_token');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('Worker.vault_data', function (Blueprint $table) {
            DB::statement('DROP INDEX IF EXISTS Worker.idx_vault_token');
        });
    }
}
