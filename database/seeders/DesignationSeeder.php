<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DesignationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('Masterdata.designations')->truncate();
        DB::table("Masterdata.designations")->insert([
            [
                // 'id'=>1,
                'designation'=> "Labour Commissioner",
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                // 'id'=>2,
                'designation'=> "Asstt. Labour Commissioner",
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                // 'id'=>3,
                'designation'=> "Labour Inspector",
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                // 'id'=>4,
                'designation'=> "Dealing Asstt.",
                'created_at' => now(),
                'updated_at' => now()
            ],
        ]);
    }
}
