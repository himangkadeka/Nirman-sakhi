<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OfficeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('Masterdata.offices')->truncate();


        // production data
        DB::table('Masterdata.offices')->insert([
            ["egrass_office_code"=>"LED000","district_code"=>"291","office_name"=>"Office of Labour Inspector, Chaygaon","created_at"=>now(),"updated_at"=>now()],
            ["egrass_office_code"=>"LED001","district_code"=>"295","office_name"=>"Office of Labour Inspector, Narayanpur","created_at"=>now(),"updated_at"=>now()],
            ["egrass_office_code"=>"LED002","district_code"=>"705","office_name"=>"Office of Labour Officer, Biswanath Chariali","created_at"=>now(),"updated_at"=>now()],
            ["egrass_office_code"=>"LED003","district_code"=>"288","office_name"=>"Office of Labour Officer, Bokakhat","created_at"=>now(),"updated_at"=>now()],
            ["egrass_office_code"=>"LED004","district_code"=>"281","office_name"=>"Office of Labour Officer, Bongaigaon","created_at"=>now(),"updated_at"=>now()],
            ["egrass_office_code"=>"LED005","district_code"=>"292","office_name"=>"Office of Labour Officer, Bokajan","created_at"=>now(),"updated_at"=>now()],
            ["egrass_office_code"=>"LED006","district_code"=>"280","office_name"=>"Office of Labour Officer, Barpeta","created_at"=>now(),"updated_at"=>now()],
            ["egrass_office_code"=>"LED007","district_code"=>"280","office_name"=>"Office of Labour Inspector, Rupsi","created_at"=>now(),"updated_at"=>now()],
            ["egrass_office_code"=>"LED008","district_code"=>"282","office_name"=>"Office of Asst. Labour Commissioner, Silchar","created_at"=>now(),"updated_at"=>now()],
            ["egrass_office_code"=>"LED009","district_code"=>"283","office_name"=>"Office of Labour Officer, Mangaldoi","created_at"=>now(),"updated_at"=>now()],
            ["egrass_office_code"=>"LED010","district_code"=>"285","office_name"=>"Office of Asst. Labour Commissioner, Dhubri","created_at"=>now(),"updated_at"=>now()],
            ["egrass_office_code"=>"LED011","district_code"=>"286","office_name"=>"Office of Asst. Labour Commissioner, Dibrugarh","created_at"=>now(),"updated_at"=>now()],
            ["egrass_office_code"=>"LED012","district_code"=>"284","office_name"=>"Office of Labour Officer, Dhemaji","created_at"=>now(),"updated_at"=>now()],
            ["egrass_office_code"=>"LED013","district_code"=>"292","office_name"=>"Office of Labour Officer, Diphu","created_at"=>now(),"updated_at"=>now()],
            ["egrass_office_code"=>"LED014","district_code"=>"292","office_name"=>"Office of Labour Inspector, Howraghat","created_at"=>now(),"updated_at"=>now()],
            ["egrass_office_code"=>"LED015","district_code"=>"706","office_name"=>"Office of Labour Inspector, Majuli","created_at"=>now(),"updated_at"=>now()],
            ["egrass_office_code"=>"LED016","district_code"=>"287","office_name"=>"Office of Labour Officer, Goalpara","created_at"=>now(),"updated_at"=>now()],
            ["egrass_office_code"=>"LED017","district_code"=>"288","office_name"=>"Office of Asst. Labour Commissioner, Golaghat","created_at"=>now(),"updated_at"=>now()],
            ["egrass_office_code"=>"LED018","district_code"=>"292","office_name"=>"Office of Labour Officer, Hamren","created_at"=>now(),"updated_at"=>now()],
            ["egrass_office_code"=>"LED018","district_code"=>"292","office_name"=>"Office of Labour Inspector, Rongkhong","created_at"=>now(),"updated_at"=>now()],
            ["egrass_office_code"=>"LED019","district_code"=>"299","office_name"=>"Office of Labour Officer, Halflong","created_at"=>now(),"updated_at"=>now()],
            ["egrass_office_code"=>"LED020","district_code"=>"289","office_name"=>"Office of Labour Officer, Hailakandi","created_at"=>now(),"updated_at"=>now()],
            ["egrass_office_code"=>"LED021","district_code"=>"709","office_name"=>"Office of Labour Officer, Hojai","created_at"=>now(),"updated_at"=>now()],
            ["egrass_office_code"=>"LED022","district_code"=>"290","office_name"=>"Office of Asst. Labour Commissioner, Jorhat","created_at"=>now(),"updated_at"=>now()],
            ["egrass_office_code"=>"LED020","district_code"=>"289","office_name"=>"Office of Labour Inspector, Hailakandi (Attached with LO Hailakandi)","created_at"=>now(),"updated_at"=>now()],
            ["egrass_office_code"=>"LED024","district_code"=>"618","office_name"=>"Office of Asst. Labour Commissioner, Kamrup (M)","created_at"=>now(),"updated_at"=>now()],
            ["egrass_office_code"=>"LED025","district_code"=>"293","office_name"=>"Office of Labour Officer, Karimganj","created_at"=>now(),"updated_at"=>now()],
            ["egrass_office_code"=>"LED026","district_code"=>"297","office_name"=>"Office of Labour Inspector, Kaliabor","created_at"=>now(),"updated_at"=>now()],
            ["egrass_office_code"=>"LED027","district_code"=>"295","office_name"=>"Office of Labour Officer, Lakhimpur","created_at"=>now(),"updated_at"=>now()],
            ["egrass_office_code"=>"LED028","district_code"=>"296","office_name"=>"Office of Labour Officer, Morigaon","created_at"=>now(),"updated_at"=>now()],
            ["egrass_office_code"=>"LED029","district_code"=>"296","office_name"=>"Office of Labour Inspector, Mayong","created_at"=>now(),"updated_at"=>now()],
            ["egrass_office_code"=>"LED030","district_code"=>"297","office_name"=>"Office of Asst. Labour Commissioner, Nagaon","created_at"=>now(),"updated_at"=>now()],
            ["egrass_office_code"=>"LED031","district_code"=>"298","office_name"=>"Office of Labour Officer, Nalbari","created_at"=>now(),"updated_at"=>now()],
            ["egrass_office_code"=>"LED033","district_code"=>"291","office_name"=>"Office of Labour Inspector, Rangia","created_at"=>now(),"updated_at"=>now()],
            ["egrass_office_code"=>"LED034","district_code"=>"708","office_name"=>"Office of Labour Officer, Sonari","created_at"=>now(),"updated_at"=>now()],
            ["egrass_office_code"=>"LED035","district_code"=>"301","office_name"=>"Office of Asst. Labour Commissioner, Tezpur","created_at"=>now(),"updated_at"=>now()],
            ["egrass_office_code"=>"LED036","district_code"=>"288","office_name"=>"Office of Labour Inspector, Sarupathar","created_at"=>now(),"updated_at"=>now()],
            ["egrass_office_code"=>"LED037","district_code"=>"300","office_name"=>"Office of Asst. Labour Commissioner, Sivasagar","created_at"=>now(),"updated_at"=>now()],
            ["egrass_office_code"=>"LED038","district_code"=>"302","office_name"=>"Office of Asst. Labour Commissioner, Tinsukia","created_at"=>now(),"updated_at"=>now()],
            ["egrass_office_code"=>"LED039","district_code"=>"705","office_name"=>"Office of Labour Inspector, Behali","created_at"=>now(),"updated_at"=>now()],
            ["egrass_office_code"=>"LED040","district_code"=>"282","office_name"=>"Office of Labour Inspector, Udarbond","created_at"=>now(),"updated_at"=>now()],
            ["egrass_office_code"=>"LED041","district_code"=>"282","office_name"=>"Office of Labour Inspector, Lakhipur","created_at"=>now(),"updated_at"=>now()],
            ["egrass_office_code"=>"LED042","district_code"=>"707","office_name"=>"Office of Labour Inspector, Mancachar","created_at"=>now(),"updated_at"=>now()],
            ["egrass_office_code"=>"LED043","district_code"=>"285","office_name"=>"Office of Labour Inspector, Bilasipara","created_at"=>now(),"updated_at"=>now()],
            ["egrass_office_code"=>"LED044","district_code"=>"286","office_name"=>"Office of Labour Inspector, Khowang","created_at"=>now(),"updated_at"=>now()],
            ["egrass_office_code"=>"LED045","district_code"=>"286","office_name"=>"Office of Labour Inspector, Joypore","created_at"=>now(),"updated_at"=>now()],
            ["egrass_office_code"=>"LED046","district_code"=>"287","office_name"=>"Office of Labour Inspector, Dudhnoi","created_at"=>now(),"updated_at"=>now()],
            ["egrass_office_code"=>"LED047","district_code"=>"299","office_name"=>"Office of Labour Inspector, Diyung Valley","created_at"=>now(),"updated_at"=>now()],
            ["egrass_office_code"=>"LED048","district_code"=>"299","office_name"=>"Office of Labour Inspector, Jatinga Valley","created_at"=>now(),"updated_at"=>now()],
            ["egrass_office_code"=>"LED049","district_code"=>"709","office_name"=>"Office of Labour Inspector, Lanka(Attached With LO Hojai)","created_at"=>now(),"updated_at"=>now()],
            ["egrass_office_code"=>"LED050","district_code"=>"290","office_name"=>"Office of Labour Inspector, Titabor","created_at"=>now(),"updated_at"=>now()],
            ["egrass_office_code"=>"LED051","district_code"=>"293","office_name"=>"Office of Labour Inspector, Patharkandi","created_at"=>now(),"updated_at"=>now()],
            ["egrass_office_code"=>"LED052","district_code"=>"295","office_name"=>"Office of Labour Inspector, Nowboicha","created_at"=>now(),"updated_at"=>now()],
            ["egrass_office_code"=>"LED053","district_code"=>"300","office_name"=>"Office of Labour Inspector, Demow","created_at"=>now(),"updated_at"=>now()],
            ["egrass_office_code"=>"LED054","district_code"=>"300","office_name"=>"Office of Labour Inspector, Nazira","created_at"=>now(),"updated_at"=>now()],
            ["egrass_office_code"=>"LED055","district_code"=>"302","office_name"=>"Office of Labour Inspector, Kakopathar","created_at"=>now(),"updated_at"=>now()],
            ["egrass_office_code"=>"LED056","district_code"=>"302","office_name"=>"Office of Labour Inspector, Hapjan","created_at"=>now(),"updated_at"=>now()],
            ["egrass_office_code"=>"LED057","district_code"=>"302","office_name"=>"Office of Labour Officer, Margherita","created_at"=>now(),"updated_at"=>now()],
            ["egrass_office_code"=>"LED058","district_code"=>"301","office_name"=>"Office of Labour Inspector, Dhekiajuli","created_at"=>now(),"updated_at"=>now()],
            ["egrass_office_code"=>"LED059","district_code"=>"297","office_name"=>"Office of Labour Inspector, Batadraba","created_at"=>now(),"updated_at"=>now()],
            ["egrass_office_code"=>"LED060","district_code"=>"302","office_name"=>"Office of Labour Inspector, Doom Dooma","created_at"=>now(),"updated_at"=>now()],
            ["egrass_office_code"=>"LED061","district_code"=>"283","office_name"=>"Labour Officer Mangaldai","created_at"=>now(),"updated_at"=>now()],
            ["egrass_office_code"=>"LED063","district_code"=>"294","office_name"=>"Office of Labour Inspector, Gossaigaon","created_at"=>now(),"updated_at"=>now()],
            ["egrass_office_code"=>"LED064","district_code"=>"617","office_name"=>"Office of Labour Inspector, Khoirabari","created_at"=>now(),"updated_at"=>now()],
            ["egrass_office_code"=>"LED065","district_code"=>"739","office_name"=>"Office of Labour Inspector, Bhawanipur","created_at"=>now(),"updated_at"=>now()],
            ["egrass_office_code"=>"LED066","district_code"=>"289","office_name"=>"Office of Labour Inspector, Patharkandi","created_at"=>now(),"updated_at"=>now()],
            // ["egrass_office_code"=>"LED018","district_code"=>"618","office_name"=>"ASSAM BUILDING AND OTHER CONSTRUCTIONS WORKERS WELFARE BOARD","created_at"=>now(),"updated_at"=>now()]
        ]);
    }
}
