<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AgeProofSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('Masterdata.age_proofs')->truncate();

        DB::table('Masterdata.age_proofs')->insert([

            [
                'age_proof_code'=>1,
                'age_proof_name'=> "Passport",
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'age_proof_code'=>2,
                'age_proof_name'=> "Driving License",
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'age_proof_code'=>3,
                'age_proof_name'=> "Birth Certificate",
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'age_proof_code'=>4,
                'age_proof_name'=> "School Leaving Certificate",
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'age_proof_code'=>5,
                'age_proof_name'=> "PAN",
                'created_at' => now(),
                'updated_at' => now()
            ],
        ]);
    }
}
