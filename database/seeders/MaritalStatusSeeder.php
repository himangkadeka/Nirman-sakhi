<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MaritalStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('Masterdata.marital_statuses')->truncate();

        DB::table('Masterdata.marital_statuses')->insert([
            [
                
                "marital_status" => "Single",
                "created_at" => now(),
                "updated_at" => now()
            ],
            [
                
                "marital_status" => "Married",
                "created_at" => now(),
                "updated_at" => now()
            ],
            [
                
                "marital_status" => "Divorced",
                "created_at" => now(),
                "updated_at" => now()
            ],
            [
                
                "marital_status" => "Widow",
                "created_at" => now(),
                "updated_at" => now()
            ]

        ]);
    }
}
