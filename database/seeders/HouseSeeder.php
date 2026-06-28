<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class HouseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('Masterdata.houses')->truncate();

        DB::table('Masterdata.houses')->insert([
            [
                
                'house_type'=> "Pucca",
                'created_at' => now(),
                'updated_at' =>now()
            ],
            [
                
                'house_type'=> "Kutcha",
                'created_at' => now(),
                'updated_at' =>now()
            ],
        ]);

    }
}
