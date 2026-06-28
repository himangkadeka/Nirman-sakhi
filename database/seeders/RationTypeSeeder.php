<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RationTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('Masterdata.ration_types')->truncate();

        DB::table("Masterdata.ration_types")->insert([
            [
                "name" => "Antyodaya Anna Yojana (AAY)",
                "created_at"=> now(),
                "updated_at" => now()
            ],
            [
                "name" => "Priority Household (PHH)",
                "created_at"=> now(),
                "updated_at" => now()
            ],
        ]);
    }
}
