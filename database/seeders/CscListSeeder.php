<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CscListSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Wipe the crime scene before inserting fresh victims
        DB::table('User.csc_lists')->truncate();

        // Path to your CSV
        $csvFilePath = public_path('app/database_file/csc_list.csv');

        // Read CSV
        $csv = array_map('str_getcsv', file($csvFilePath));

        // Remove the header row
        $headers = array_shift($csv);

        // Columns we actually care about (matching your CSV screenshot)
        $selectedHeaders = [
            'cscid',
            'vlename',
            'district',
            'subdistrict',
            'gp',
            'village',
            'locality'
        ];

        foreach ($csv as $row) {

            // slice from index 1 (skipping slno)
            $data = array_combine($selectedHeaders, array_slice($row, 1, count($selectedHeaders)));

            $data['created_at'] = now();
            $data['updated_at'] = now();

            DB::table('User.csc_lists')->insert($data);
        }
    }
}
