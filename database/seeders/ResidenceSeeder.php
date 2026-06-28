<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ResidenceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('Masterdata.residences')->truncate();

        DB::table("Masterdata.residences")->insert([
            [
                'residence_code' => 1,
                'residence_name' => 'Owned',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'residence_code' => 2,
                'residence_name' => 'Rented',
                'created_at' => now(),
                'updated_at' => now()
            ],
        ]);
    }
}
