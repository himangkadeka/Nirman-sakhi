<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AmountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('Masterdata.amounts')->truncate();

        DB::table('Masterdata.amounts')->insert([
            [
                'amount_description' => 'Registration Amount',
                'amount' => 25,
                'created_at' => now()
            ],
            [
                'amount_description' => 'Subscription Amount',
                'amount' => 20,
                'created_at' => now()
            ],
            // [
            //     'amount_description' => 'Late Fine Amount',
            //     'amount' => 0,
            //     'created_at' => now()
            // ],

        ]);
    }
}
