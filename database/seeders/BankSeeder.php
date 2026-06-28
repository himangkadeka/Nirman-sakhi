<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BankSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('Masterdata.banks')->truncate();

        $csvFilePath = public_path('app/database_file/banks.csv');

        $csv = array_map('str_getcsv', file($csvFilePath));
        $headers = array_shift($csv);
        $selectedHeaders = ['state', 'ifsc', 'branch_name','bank_name'];
        foreach ($csv as $row) {
            
            $data = array_combine($selectedHeaders, array_slice($row, 1, count($selectedHeaders)));
            $data['created_at'] = now();
            $data['updated_at'] = now();

            
            DB::table('Masterdata.banks')->insert($data);
        }
    }
}
