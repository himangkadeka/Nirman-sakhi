<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BloodGroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('Masterdata.blood_groups')->truncate();

        DB::table('Masterdata.blood_groups')->insert([
            ['blood_group' => 'A+'],
            ['blood_group' => 'A-'],
            ['blood_group' => 'B+'],
            ['blood_group' => 'B-'],
            ['blood_group' => 'AB+'],
            ['blood_group' => 'AB-'],
            ['blood_group' => 'O+'],
            ['blood_group' => 'O-'],
        ]);
    }
}
