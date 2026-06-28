<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        DB::table('Masterdata.states')->truncate();
        DB::table('Masterdata.states')->insert([
            [
                'state_code' => 1,
                'state_name' => 'Jammu And Kashmir',
                'status' => 1,
                'created_at'=>now(),
                'updated_at'=>now()
            ],
            [
                'state_code' => 2,
                'state_name' => 'Himachal Pradesh',
                'status' => 1,
                'created_at'=>now(),
                'updated_at'=>now()
            ],
            [
                'state_code' => 3,
                'state_name' => 'Punjab',
                'status' => 1,
                'created_at'=>now(),
                'updated_at'=>now()
            ],
            [
                'state_code' => 4,
                'state_name' => 'Chandigarh',
                'status' => 1,
                'created_at'=>now(),
                'updated_at'=>now()
            ],
            [
                'state_code' => 5,
                'state_name' => 'Uttarakhand',
                'status' => 1,
                'created_at'=>now(),
                'updated_at'=>now()
            ],
            [
                'state_code' => 6,
                'state_name' => 'Haryana',
                'status' => 1,
                'created_at'=>now(),
                'updated_at'=>now()
            ],
            [
                'state_code' => 7,
                'state_name' => 'Delhi',
                'status' => 1,
                'created_at'=>now(),
                'updated_at'=>now()
            ],
            [
                'state_code' => 8,
                'state_name' => 'Rajasthan',
                'status' => 1,
                'created_at'=>now(),
                'updated_at'=>now()
            ],
            [
                'state_code' => 9,
                'state_name' => 'Uttar Pradesh',
                'status' => 1,
                'created_at'=>now(),
                'updated_at'=>now()
            ],
            [
                'state_code' => 10,
                'state_name' => 'Bihar',
                'status' => 1,
                'created_at'=>now(),
                'updated_at'=>now()
            ],
            [
                'state_code' => 11,
                'state_name' => 'Sikkim',
                'status' => 1,
                'created_at'=>now(),
                'updated_at'=>now()
            ],
            [
                'state_code' => 12,
                'state_name' => 'Arunachal Pradesh',
                'status' => 1,
                'created_at'=>now(),
                'updated_at'=>now()
            ],
            [
                'state_code' => 13,
                'state_name' => 'Nagaland',
                'status' => 1,
                'created_at'=>now(),
                'updated_at'=>now()
            ],
            [
                'state_code' => 14,
                'state_name' => 'Manipur',
                'status' => 1,
                'created_at'=>now(),
                'updated_at'=>now()
            ],
            [
                'state_code' => 15,
                'state_name' => 'Mizoram',
                'status' => 1,
                'created_at'=>now(),
                'updated_at'=>now()
            ],
            [
                'state_code' => 16,
                'state_name' => 'Tripura',
                'status' => 1,
                'created_at'=>now(),
                'updated_at'=>now()
            ],
            [
                'state_code' => 17,
                'state_name' => 'Meghalaya',
                'status' => 1,
                'created_at'=>now(),
                'updated_at'=>now()
            ],
            [
                'state_code' => 18,
                'state_name' => 'Assam',
                'status' => 1,
                'created_at'=>now(),
                'updated_at'=>now()
            ],
            [
                'state_code' => 19,
                'state_name' => 'West Bengal',
                'status' => 1,
                'created_at'=>now(),
                'updated_at'=>now()
            ],
            [
                'state_code' => 20,
                'state_name' => 'Jharkhand',
                'status' => 1,
                'created_at'=>now(),
                'updated_at'=>now()
            ],
            [
                'state_code' => 21,
                'state_name' => 'Odisha',
                'status' => 1,
                'created_at'=>now(),
                'updated_at'=>now()
            ],
            [
                'state_code' => 22,
                'state_name' => 'Chhattisgarh',
                'status' => 1,
                'created_at'=>now(),
                'updated_at'=>now()
            ],
            [
                'state_code' => 23,
                'state_name' => 'Madhya Pradesh',
                'status' => 1,
                'created_at'=>now(),
                'updated_at'=>now()
            ],
            [
                'state_code' => 24,
                'state_name' => 'Gujarat',
                'status' => 1,
                'created_at'=>now(),
                'updated_at'=>now()
            ],
            [
                'state_code' => 27,
                'state_name' => 'Maharashtra',
                'status' => 1,
                'created_at'=>now(),
                'updated_at'=>now()
            ],
            [
                'state_code' => 28,
                'state_name' => 'Andhra Pradesh',
                'status' => 1,
                'created_at'=>now(),
                'updated_at'=>now()
            ],
            [
                'state_code' => 29,
                'state_name' => 'Karnataka',
                'status' => 1,
                'created_at'=>now(),
                'updated_at'=>now()
            ],
            [
                'state_code' => 30,
                'state_name' => 'Goa',
                'status' => 1,
                'created_at'=>now(),
                'updated_at'=>now()
            ],
            [
                'state_code' => 31,
                'state_name' => 'Lakshadweep',
                'status' => 1,
                'created_at'=>now(),
                'updated_at'=>now()
            ],
            [
                'state_code' => 32,
                'state_name' => 'Kerala',
                'status' => 1,
                'created_at'=>now(),
                'updated_at'=>now()
            ],
            [
                'state_code' => 33,
                'state_name' => 'Tamil Nadu',
                'status' => 1,
                'created_at'=>now(),
                'updated_at'=>now()
            ],
            [
                'state_code' => 34,
                'state_name' => 'Puducherry',
                'status' => 1,
                'created_at'=>now(),
                'updated_at'=>now()
            ],
            [
                'state_code' => 35,
                'state_name' => 'Andaman And Nicobar Islands',
                'status' => 1,
                'created_at'=>now(),
                'updated_at'=>now()
            ],
            [
                'state_code' => 36,
                'state_name' => 'Telangana',
                'status' => 1,
                'created_at'=>now(),
                'updated_at'=>now()
            ],
            [
                'state_code' => 37,
                'state_name' => 'Ladakh',
                'status' => 1,
                'created_at'=>now(),
                'updated_at'=>now()
            ],
            [
                'state_code' => 38,
                'state_name' => 'The Dadra And Nagar Haveli And Daman And Diu',
                'status' => 1,
                'created_at'=>now(),
                'updated_at'=>now()
            ],
            
        ]);
    }
}
