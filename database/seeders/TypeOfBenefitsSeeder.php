<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TypeOfBenefitsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('Masterdata.type_of_benefits')->truncate();

        DB::table('Masterdata.type_of_benefits')->insert([
            [
                'benefit_name' => 'Death Benefit',

                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'benefit_name' => 'Funeral Assistance',

                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'benefit_name' => 'General Pension',

                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'benefit_name' => 'Family Pension',

                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'benefit_name' => 'Disability Pension',

                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'benefit_name' => 'Transit Shelter – one time- (as per Model Welfare Scheme)',

                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'benefit_name' => 'Cash Award',

                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'benefit_name' => 'One Time Educational Assistance',

                'created_at' => now(),
                'updated_at' => now(),
            ],


            [
                'benefit_name' => 'Medical Assistance',

                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'benefit_name' => 'Maternity Assistance',

                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'benefit_name' => 'Skill Development Training',

                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'benefit_name' => 'Marriage Assistance',

                'created_at' => now(),
                'updated_at' => now(),
            ],



        ]);
    }
}
