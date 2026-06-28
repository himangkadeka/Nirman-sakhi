<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RelationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('Masterdata.relations')->truncate();

        DB::table('Masterdata.relations')->insert([
            [
                'relation_code' => 1,
                'relation_name'=> "Father",
                'created_at'=> now(),
                'updated_at' => now()
            ],
            [
                'relation_code' => 2,
                'relation_name'=> "Mother",
                'created_at'=> now(),
                'updated_at' => now()
            ],
            [
                'relation_code' => 3,
                'relation_name'=> "Wife",
                'created_at'=> now(),
                'updated_at' => now()
            ],
            [
                'relation_code' => 4,
                'relation_name'=> "Husband",
                'created_at'=> now(),
                'updated_at' => now()
            ],
            [
                'relation_code' => 5,
                'relation_name'=> "Son",
                'created_at'=> now(),
                'updated_at' => now()
            ],
            [
                'relation_code' => 6,
                'relation_name'=> "Daughter",
                'created_at'=> now(),
                'updated_at' => now()
            ],
            [
                'relation_code' => 7,
                'relation_name'=> "Brother",
                'created_at'=> now(),
                'updated_at' => now()
            ],
            [
                'relation_code' => 8,
                'relation_name'=> "Sister",
                'created_at'=> now(),
                'updated_at' => now()
            ],
            [
                'relation_code' => 9,
                'relation_name'=> "Grandfather",
                'created_at'=> now(),
                'updated_at' => now()
            ],
            [
                'relation_code' => 10,
                'relation_name'=> "Grandmother",
                'created_at'=> now(),
                'updated_at' => now()
            ],
            [
                'relation_code' => 11,
                'relation_name'=> "Uncle",
                'created_at'=> now(),
                'updated_at' => now()
            ],
            [
                'relation_code' => 12,
                'relation_name'=> "Aunt",
                'created_at'=> now(),
                'updated_at' => now()
            ],

            [
                'relation_code' => 13,
                'relation_name'=> "Son-In-Law",
                'created_at'=> now(),
                'updated_at' => now()
            ],
            [
                'relation_code' => 14,
                'relation_name'=> "Daughter-In-Law",
                'created_at'=> now(),
                'updated_at' => now()
            ],
            [
                'relation_code' => 15,
                'relation_name'=> "Grandson",
                'created_at'=> now(),
                'updated_at' => now()
            ],
            [
                'relation_code' => 16,
                'relation_name'=> "Granddaughter",
                'created_at'=> now(),
                'updated_at' => now()
            ],
            [
                'relation_code' => 17,
                'relation_name'=> "Others",
                'created_at'=> now(),
                'updated_at' => now()
            ],

        ]);
    }
}
