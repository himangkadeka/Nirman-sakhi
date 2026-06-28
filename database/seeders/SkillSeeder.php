<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SkillSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('Masterdata.skills')->truncate();

        $csvData = <<<CSV
        "skill_name","created_at","updated_at"
        "Plumbing","2023-12-13 14:40:17","2023-12-13 14:40:17"
        "Masonry","2023-12-13 14:40:17","2023-12-13 14:40:17"
        "Electrician","2023-12-13 14:40:17","2023-12-13 14:40:17"
        "Carpentry","2023-12-13 14:40:17","2023-12-13 14:40:17"
        CSV;

        $rows = array_map('str_getcsv', explode("\n", trim($csvData)));
        $headers = array_shift($rows);

        foreach ($rows as $row) {
            $data = array_combine($headers, $row);
            // Convert time format to be compatible with Laravel timestamp
            $data['created_at'] = now();
            $data['updated_at'] = now();

            DB::table('Masterdata.skills')->insert($data);
        }

    }
}
