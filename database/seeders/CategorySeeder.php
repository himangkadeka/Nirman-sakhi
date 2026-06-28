<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('Masterdata.categories')->truncate();

        DB::table('Masterdata.categories')->insert([
            [
                
                'category_name'=> "GEN",
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                
                'category_name'=> "SC",
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                
                'category_name'=> "ST",
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                
                'category_name'=> "OBC",
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                
                'category_name'=> "Others",
                'created_at' => now(),
                'updated_at' => now()
            ],
        ]);
    }
}
