<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAadhaarVerificationToMainWorkerFamiliesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('Worker.main_worker_families', function (Blueprint $table) {
            $table->boolean('is_aadhar_verified')->default(false)->after('relation_others');
            $table->timestamp('aadhar_verified_at')->after('is_aadhar_verified')->nullable();
            $table->text('vault_data')->nullable()->comment('Encrypted Aadhaar data from KYC service')->after('is_aadhar_verified');
            $table->text('vault_pass_key')->nullable()->comment('Key to decrypt vault data')->after('vault_data');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('Worker.main_worker_families', function (Blueprint $table) {
            $table->dropColumn(['is_aadhar_verified', 'vault_data', 'vault_pass_key']);
        });
    }
}
