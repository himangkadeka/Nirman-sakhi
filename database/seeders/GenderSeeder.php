<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GenderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('Masterdata.genders')->truncate();

        DB::table('Masterdata.genders')->insert([
            [
                
                'gender_name'=> "Male",
                'created_at'=> now(),
                'updated_at' => now()
            ],
            [
                
                'gender_name'=> "Female",
                'created_at'=> now(),
                'updated_at' => now()
            ],
            [
                
                'gender_name'=> "Others",
                'created_at'=> now(),
                'updated_at' => now()
            ],
        ]);

    }
}
