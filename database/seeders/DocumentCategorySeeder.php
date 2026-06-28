<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DocumentCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('Masterdata.document_categories')->truncate();

        DB::table('Masterdata.document_categories')->insert([
            [

                'category_name' => "Index Notifications",

                'created_at' => now(),
                'updated_at' => now()
            ],
            [

                'category_name' => "Index Newsletters",
                'created_at' => now(),
                'updated_at' => now()
            ],
            [

                'category_name' => "Index Tenders",
                'created_at' => now(),
                'updated_at' => now()
            ],
            [

                'category_name' => "Disbursed Benefits",
                'created_at' => now(),
                'updated_at' => now()
            ],
            [

                'category_name' => "Benefits Returned",
                'created_at' => now(),
                'updated_at' => now()
            ],
            [

                'category_name' => "Alert index",
                'created_at' => now(),
                'updated_at' => now()
            ],

            [

                'category_name' => "Downloads",

                'created_at' => now(),
                'updated_at' => now()
            ],
            [

                'category_name' => "IIT",

                'created_at' => now(),
                'updated_at' => now()
            ],

        ]);
    }
}
