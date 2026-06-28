<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KeyValueSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('Masterdata.key_values')->truncate();

        DB::table('Masterdata.key_values')->insert([
            [

                'key'=> "LICENSE_KEY",
                'value' => "eyJjaXBoZXJ0ZXh0IjoidlZrR2lCN0tBRllsdWduZHlOZnNcL1kzeXgrTlNlR1wvclBlK2N4ajBFSFlVPSIsIml2IjoiMWIyMGJjNDYwNzViMzUzMGU0N2U2MDI3ZGRjMzliODUiLCJzYWx0IjoiNGNhMTM5NjZmM2IzMTY2NDZhOTQyNTYwNWQxN2Q0ZTFkNGY0NmM1N2NmNWRhYzc5YWY3MTE5OTJhZjA2ZmNjZTY3YTFkNzNlNDQ1MjA5NjY2YTBmMGJhZWExZDExYTQwZjAwZjIxZDZiNjBjNGUxMDZhOGNmOWU1Y2U4ZjU2ZTcyNWYwY2Q3ZGExNjJlOTZkNTRmODU0MDJkNjEyM2M5OTdlNGI1ZWRhZjUyNzBmY2ZiY2ViOGEyN2JhZjMwNWM1Y2VlNzllZmNhODQ4NGQ0ZTI3MjJkZmFjZTMxNDI5YmJkNDM1NDQxNTdiNTdiZWI3MDJhMzg5YWQ2MzQxZTY0ZTM1NDUzZmJjZDMxNWE1OWEzYWIzMzUyYTRiMzAyZjljOTBlOWZmMmZhMDM1ZTJlNzgzOGY4NWNlYmQzNGE4NjdhMDFjOGMyYThjMTc1Y2VlNWEzYzhmNDg3MGY5OWZlNWQ4YjVlMzBkNDg1NmZmZDE5ZGY5Y2IzNmExOTBmOTQwZDVmMTU4YTNiM2NiZTZjNmIwY2U0OWE3ZWNlYzEwNWY1OTUxOTVjYWM0ZmNmNzQ3ZDMwZjRhNjM0N2FhNmQ4Njg3M2U2OTRmMmFkN2YzMmI1OTRhNjJkN2Q0MzkzNmE1MzJkOWZmMjY4ZDA1NzY2Zjk5YTQyMjk3OWQ2ZTIxZDgiLCJpdGVyYXRpb25zIjo5OTl9",
                'created_at'=> now(),
                'updated_at' => now()
            ],

            [

                'key'=> "SECRET_KEY_TOKEN",
                'value' => "cb337a199c797cac72594e20639e1e804b0f45d50fa1c621c86be43aa0aed6c9",
                'created_at'=> now(),
                'updated_at' => now()
            ],

            [

                'key'=> "SECRET_CODE",
                'value' => "asdfghjpparvezoiuytuandobqwerl",
                'created_at'=> now(),
                'updated_at' => now()
            ],

            [

                'key'=> "SALT_VALUE_ESHRAM",
                'value' => "561982709",
                'created_at'=> now(),
                'updated_at' => now()
            ],

            [

                'key'=> "SALT_VALUE",
                'value' => "VGHJnjhgvhfGCGVBhjghh45678iHgTFgvhbjnFFGHJ87FGHJRTYUIO",
                'created_at'=> now(),
                'updated_at' => now()
            ],


        ]);

    }
}
