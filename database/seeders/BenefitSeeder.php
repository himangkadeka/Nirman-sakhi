<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BenefitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('Benefit.benefits')->truncate();

        DB::table('Benefit.benefits')->insert([
            [
                'name' => 'Application for Death Benefit',
                'description' => "NA",
                'benefit_code' => 'DB',
                'role_ids' => '10,11',
                'maximum_applications_per_worker'=>1,
                'created_at' => now()
            ],
            [
                'name' => 'Application for Funeral Assistance',
                'description' => "NA",
                'benefit_code' => 'FA',
                'role_ids' => '10,11',
                'maximum_applications_per_worker'=>1,
                'created_at' => now()
            ],
            [
                'name' => 'Application for General Pension',
                'description' => "NA",
                'benefit_code' => 'GP',
                'role_ids' => 5,
                'maximum_applications_per_worker'=>1,
                'created_at' => now()
            ],
            [
                'name' => 'Application for Family Pension',
                'description' => "NA",
                'benefit_code' => 'FP',
                'role_ids' => 5,
                'maximum_applications_per_worker'=>1,
                'created_at' => now()
            ],
            [
                'name' => 'Application for Disability Pension',
                'description' => "NA",
                'benefit_code' => 'DP',
                'role_ids' => 5,
                'maximum_applications_per_worker'=>1,
                'created_at' => now()
            ],
            [
                'name' => 'Application for Cash Award For Education',
                'description' => "NA",
                'benefit_code' => 'CE',
                'role_ids' => 5,
                'maximum_applications_per_worker'=>2,
                'created_at' => now()
            ],
            [
                'name' => 'Application for One Time Educational Assistance',
                'description' => "NA",
                'benefit_code' => 'EA',
                'role_ids' => '5,10,11',
                'maximum_applications_per_worker'=>2,
                'created_at' => now()
            ],
            [
                'name' => 'Application for Medical Assistance',
                'description' => "NA",
                'benefit_code' => 'MA',
                'role_ids' => '5,10,11',
                'maximum_applications_per_worker'=>6,
                'created_at' => now()
            ],
            [
                'name' => 'Application for Medical Assistance (Disability), as per Rule 284 of BOCW Assam rules 2017',
                'description' => "NA",
                'benefit_code' => 'MD',
                'role_ids' => '5,10,11',
                'maximum_applications_per_worker'=>6,
                'created_at' => now()
            ],
            [
                'name' => 'Application for Maternity Assistance',
                'description' => "NA",
                'benefit_code' => 'MT',
                'role_ids' => '5',
                'maximum_applications_per_worker'=>2,
                'created_at' => now()
            ],
            [
                'name' => 'Application for Marriage Assistance',
                'description' => "NA",
                'benefit_code' => 'MR',
                'role_ids' => '5',
                'maximum_applications_per_worker'=>2,
                'created_at' => now()
            ],
            [
                'name' => 'Application for Night Shelter',
                'description' => "NA",
                'benefit_code' => 'NS',
                'role_ids' => '5',
                'maximum_applications_per_worker'=>0,
                'created_at' => now()
            ],

        ]);
    }
}
