<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EducationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('Masterdata.educations')->truncate();
        DB::table('Masterdata.educations')->insert([
            [
                
                'education_name' => 'ITI',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                
                'education_name' => 'Below 8',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                
                'education_name' => '10',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                
                'education_name' => '12',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                
                'education_name' => 'Graduation',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                
                'education_name' => 'Diploma',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                
                'education_name' => 'Illiterate',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                
                'education_name' => 'Post graduation',
                'created_at' => now(),
                'updated_at' => now()
            ],
        ]);
    }
}
