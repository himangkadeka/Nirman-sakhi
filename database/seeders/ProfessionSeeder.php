<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProfessionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('Masterdata.professions')->truncate();

        DB::table('Masterdata.professions')->insert([
            [
                'profession_code'=>0,
                'profession_name'=>'Health and Safety',
                'created_at'=> now(),
                'updated_at'=>now()
            ],
            [
                'profession_code'=>1,
                'profession_name'=>'Bar Bender',
                'created_at'=> now(),
                'updated_at'=>now()
            ],
            [
                'profession_code'=>2,
                'profession_name'=>'Electrician',
                'created_at'=> now(),
                'updated_at'=>now()
            ],
            [
                'profession_code'=>3,
                'profession_name'=>'Concrete finisher',
                'created_at'=> now(),
                'updated_at'=>now()
            ],
            [
                'profession_code'=>4,
                'profession_name'=>'Painter',
                'created_at'=> now(),
                'updated_at'=>now()
            ],
            [
                'profession_code'=>5,
                'profession_name'=>'Masonry',
                'created_at'=> now(),
                'updated_at'=>now()
            ],
            [
                'profession_code'=>6,
                'profession_name'=>'Draughtsman',
                'created_at'=> now(),
                'updated_at'=>now()
            ],
            [
                'profession_code'=>7,
                'profession_name'=>'Electrical Works',
                'created_at'=> now(),
                'updated_at'=>now()
            ],
            [
                'profession_code'=>8,
                'profession_name'=>'General Mason',
                'created_at'=> now(),
                'updated_at'=>now()
            ],
            [
                'profession_code'=>9,
                'profession_name'=>'Interior and Exterior Finishes',
                'created_at'=> now(),
                'updated_at'=>now()
            ],
            [
                'profession_code'=>10,
                'profession_name'=>'Iron worker',
                'created_at'=> now(),
                'updated_at'=>now()
            ],
            [
                'profession_code'=>11,
                'profession_name'=>'Pipe Fitter',
                'created_at'=> now(),
                'updated_at'=>now()
            ],
            [
                'profession_code'=>12,
                'profession_name'=>'Plumbing and sanitary',
                'created_at'=> now(),
                'updated_at'=>now()
            ],
            [
                'profession_code'=>13,
                'profession_name'=>'Fabrication',
                'created_at'=> now(),
                'updated_at'=>now()
            ],
            [
                'profession_code'=>14,
                'profession_name'=>'Foreman Electrical Works (Construction)',
                'created_at'=> now(),
                'updated_at'=>now()
            ],
            [
                'profession_code'=>15,
                'profession_name'=>'Prestressing',
                'created_at'=> now(),
                'updated_at'=>now()
            ],
            [
                'profession_code'=>16,
                'profession_name'=>'Quality Assurance and Quality Control',
                'created_at'=> now(),
                'updated_at'=>now()
            ],
            [
                'profession_code'=>17,
                'profession_name'=>'Rigging',
                'created_at'=> now(),
                'updated_at'=>now()
            ],
            [
                'profession_code'=>18,
                'profession_name'=>'Roads and Runways Construction',
                'created_at'=> now(),
                'updated_at'=>now()
            ],
            [
                'profession_code'=>19,
                'profession_name'=>'Roofer',
                'created_at'=> now(),
                'updated_at'=>now()
            ],
            [
                'profession_code'=>20,
                'profession_name'=>'Scaffolder',
                'created_at'=> now(),
                'updated_at'=>now()
            ],
            [
                'profession_code'=>21,
                'profession_name'=>'Steel Fixer',
                'created_at'=> now(),
                'updated_at'=>now()
            ],
            [
                'profession_code'=>22,
                'profession_name'=>'Shuttering Carpenter',
                'created_at'=> now(),
                'updated_at'=>now()
            ],
            [
                'profession_code'=>23,
                'profession_name'=>'Store Keeping',
                'created_at'=> now(),
                'updated_at'=>now()
            ],
            [
                'profession_code'=>24,
                'profession_name'=>'Surveying',
                'created_at'=> now(),
                'updated_at'=>now()
            ],
            [
                'profession_code'=>25,
                'profession_name'=>'Tile setter',
                'created_at'=> now(),
                'updated_at'=>now()
            ],
            [
                'profession_code'=>26,
                'profession_name'=>'Environment',
                'created_at'=> now(),
                'updated_at'=>now()
            ],
            [
                'profession_code'=>27,
                'profession_name'=>'Plumbing',
                'created_at'=> now(),
                'updated_at'=>now()
            ],
            [
                'profession_code'=>28,
                'profession_name'=>'Others',
                'created_at'=> now(),
                'updated_at'=>now()
            ],
        ]);
    }
}
