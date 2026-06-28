<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TypeOfWorkSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('Masterdata.type_of_works')->truncate();

        DB::table('Masterdata.type_of_works')->insert([
            [

                'work_type_name' => "Buildings",
                'created_at' => now(),
                'updated_at' => now()
            ],
            [

                'work_type_name' => "Roads",
                'created_at' => now(),
                'updated_at' => now()
            ],
            [

                'work_type_name' => "Railways",
                'created_at' => now(),
                'updated_at' => now()
            ],
            [

                'work_type_name' => "Bridges",
                'created_at' => now(),
                'updated_at' => now()
            ],
            [

                'work_type_name' => "Others",
                'created_at' => now(),
                'updated_at' => now()
            ],
        ]);
    }
}
