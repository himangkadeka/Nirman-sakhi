<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GalleryCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('Content.gallery_categories')->truncate();

        DB::table('Content.gallery_categories')->insert([
            [
                'category_name' => 'Balamguri CSTC',
                'created_at' => now(),
            ],
            [
                'category_name' => 'Ceremonial Distribution of Stipend by Minister',
                'created_at' => now(),
            ],
            [
                'category_name' => 'Gogamukh',
                'created_at' => now(),
            ],
            [
                'category_name' => 'Shramik Kalyan Divas',
                'created_at' => now(),
            ],
            [
                'category_name' => 'See More',
                'created_at' => now(),
            ],
        ]);
    }
}
