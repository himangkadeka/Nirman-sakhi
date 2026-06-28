<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SubDistrictSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('Masterdata.sub_districts')->truncate();

        $csvFilePath = public_path('app/database_file/subdistricts.csv');

        $csv = array_map('str_getcsv', file($csvFilePath));
        
        $headers = array_shift($csv);

        foreach ($csv as $row) {

            $data = array_combine($headers, $row);

            $data['created_at'] = now();
            
            $data['updated_at'] = now();

            DB::table('Masterdata.sub_districts')->insert($data);
        }
    }
}
