<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PfcListSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('User.pfc_lists')->truncate();

        $csvFilePath = public_path('app/database_file/pfc_list.csv');

        $csv = array_map('str_getcsv', file($csvFilePath));
        $headers = array_shift($csv);
        $selectedHeaders = ['name_of_pfc', 'pfc_name', 'postal_address','pin_code','nearby_landmark','latitude','longitude','district_code'];

        foreach ($csv as $row) {

            $data = array_combine($selectedHeaders, array_slice($row, 1, count($selectedHeaders)));
            $data['created_at'] = now();
            $data['updated_at'] = now();

            DB::table('User.pfc_lists')->insert($data);
        }
    }
}
