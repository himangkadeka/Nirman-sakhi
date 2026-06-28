<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class NatureOfWorkSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('Masterdata.nature_of_works')->truncate();

        DB::table('Masterdata.nature_of_works')->insert([
            [
                
                'nature_of_work' => "Mason work",
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                
                'nature_of_work' => "Centering work",
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                
                'nature_of_work' => "Carpenter",
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                
                'nature_of_work' => "Welder",
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                
                'nature_of_work' => "Painter",
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                
                'nature_of_work' => "Flooring",
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                
                'nature_of_work' => "Electrician",
                'created_at' => now(),
                'updated_at' => now()
            ],

        ]);
    }
}
