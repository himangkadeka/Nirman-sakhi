<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TypeOfIssuerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('Masterdata.type_of_issuers')->truncate();


        $csvData = <<<CSV
        "issuer_name"
        "Individual Employer"
        "Developer"
        "Registered Contractor"
        "Contractor Company"
        "Municipal Corporation "
        "Panchayat Secretary"
        "Ward Executive Member"
        "Labour Union"
        "Registering Officer BOCW"
        CSV;

        $rows = array_map('str_getcsv', explode("\n", trim($csvData)));
        $headers = array_shift($rows);

        foreach ($rows as $row) {
            $data = array_combine($headers, $row);
            // Convert time format to be compatible with Laravel timestamp
            $data['created_at'] = now();
            $data['updated_at'] = now();

            DB::table('Masterdata.type_of_issuers')->insert($data);
        }
    }
}
