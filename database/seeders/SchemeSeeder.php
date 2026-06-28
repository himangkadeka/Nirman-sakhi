<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SchemeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('Masterdata.schemes')->truncate();


        $csvData = <<<CSV
"scheme_name","created_at","updated_at"
"PMJAY","2023-11-03 13:20:01","2023-11-03 13:20:01"
"PMJJBY","2023-11-03 13:20:01","2023-11-03 13:20:01"
"PMSBY","2023-11-03 13:20:01","2023-11-03 13:20:01"
"PMSYM","2023-11-03 13:20:01","2023-11-03 13:20:01"
"NPS","2023-11-03 13:20:01","2023-11-03 13:20:01"
"APY","2023-11-03 13:20:01","2023-11-03 13:20:01"
"PDS","2023-11-03 13:20:01","2023-11-03 13:20:01"
"PMAY-G","2023-11-03 13:20:01","2023-11-03 13:20:01"
"NSAP","2023-11-03 13:20:01","2023-11-03 13:20:01"
"HIS","2023-11-03 13:20:01","2023-11-03 13:20:01"
"MGNREGA","2023-11-03 13:20:01","2023-11-03 13:20:01"
"DDUGKY","2023-11-03 13:20:01","2023-11-03 13:20:01"
"Garib Kalyan Prime Minister","2023-11-03 13:20:01","2023-11-03 13:20:01"
"Employment Generation ","2023-11-03 13:20:01","2023-11-03 13:20:01"
"Programme (PMEGP)","2023-11-03 13:20:01","2023-11-03 13:20:01"
"Yojana","2023-11-03 13:20:01","2023-11-03 13:20:01"
"Deen Dayal Updhyaya ","2023-11-03 13:20:01","2023-11-03 13:20:01"
"Antyodaya Yojana (Day)","2023-11-03 13:20:01","2023-11-03 13:20:01"
"PM SVANidhi","2023-11-03 13:20:01","2023-11-03 13:20:01"
"Pradhan Mantri Kaushal Vikas","2023-11-03 13:20:01","2023-11-03 13:20:01"
"Yojana (PMKVY)","2023-11-03 13:20:01","2023-11-03 13:20:01"
CSV;

        $rows = array_map('str_getcsv', explode("\n", trim($csvData)));
        $headers = array_shift($rows);

        foreach ($rows as $row) {
            $data = array_combine($headers, $row);
            // Convert time format to be compatible with Laravel timestamp
            $data['created_at'] = now();
            $data['updated_at'] = now();

            DB::table('Masterdata.schemes')->insert($data);
        }
    }
}
