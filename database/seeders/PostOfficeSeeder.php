<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PostOfficeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('Masterdata.post_offices')->truncate();

        $csvFilePath = public_path('app/database_file/post_offices.csv');

        $csv = array_map('str_getcsv', file($csvFilePath));
        $headers = array_shift($csv);
        $selectedHeaders = ['post_office_name', 'pin_code', 'district_code','state_code'];

        foreach ($csv as $row) {
            
            $data = array_combine($selectedHeaders, array_slice($row, 1, count($selectedHeaders)));
            $data['created_at'] = now();
            $data['updated_at'] = now();
            
            DB::table('Masterdata.post_offices')->insert($data);
        }
    }
}
