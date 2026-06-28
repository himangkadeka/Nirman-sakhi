@extends('layouts.user-app')

@section('title', 'Disbursed benefit 2023')

@section('style')
    <style>
        section.background {
            width: 100%;
            padding: 50px 0px;

            position: relative;
        }

        section.background .box {
            margin: 0 auto;
            width: 80%;
            display: block;
            background: white;
            padding: 20px;
            box-sizing: border-box;
            box-shadow: rgba(149, 157, 165, 0.2) 0px 8px 24px;
        }

        @media(min-width:1600px) {
            section.background .box {
                width: 60%;
                display: block;
            }
        }

        section.background .box ul {
            padding: 0px;
            margin: 0px;
            list-style: none;
            counter-reset: list-counter;
        }

        section.background .box ul li {
            counter-increment: list-counter;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px;
            background: #f9f9f9;
            margin-bottom: 12px;
            border: 1px solid #ddd;
            border-radius: 5px;
            transition: 0.4s linear;
        }

        section.background .box ul li:hover {
            background: #dddddd;
        }

        .container {
            display: flex;
        }

        .sidebar {
            border-right: 2px solid #ccc;
            border-left: 1px solid #ccc;
            border-bottom: 1px solid #ccc;
            border-top: 1px solid #ccc;
            background-color: white;

            padding-top: 20px;
            padding-bottom: 0.5px;
            border-radius: 0;
            width: 20%;
            /* Width of the sidebar */
            /* Make sure the sidebar takes up the full height of the screen */
        }


        .sidebar .nav-link {
            display: block;
            padding: 10px 20px;
            border-bottom: 1px solid #eee;
            color: black;
            cursor: pointer;

        }

        .sidebar .nav-link.active {
            color: #007bff;
            font-weight: bold;
        }


        .table td {
            border: 1px solid #ccc;

        }



        .content {
            flex-grow: 1;

        }

        .content h2 {
            border-bottom: 2px solid #007bff;
            width: 40%;
            padding-bottom: 10px;
            margin-bottom: 30px;
        }

        .content h4 {
            border-bottom: 2px solid #007bff;
            padding-bottom: 10px;
            margin-bottom: 30px;
            color: #454141;
        }

        .table {
            width: 100%;
            border-collapse: collapse;

        }

        .table th,
        .table td {
            border: 1px solid #ddd;

            padding: 8px;

            text-align: left;

        }

        .table th {
            background-color: #f5f5f5;
            /* Light background for headers */
        }

        .last-updated {
            position: absolute;



            right: 10%;

            font-size: 12px;

            color: gray;

        }

        .tab-content {
            display: none;
            border-left: 1px;
        }

        .tab-content.active {
            display: block;
        }



        .list {

            padding: 3px 0px;
            margin-top: 15px;
        }

        .list a {
            color: red;
            font-size: 16px
        }

        .list a:hover {
            color: blue;
            text-shadow: none;
            text-decoration: none;
        }
    </style>
@endsection

@section('content')

    <section class="background">
        <div class="container">
            <div class="pagination text-center">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb justify-content-center">
                        <li class="breadcrumb-item"><a href="#">Schemes and Benefits</a></li>
                        <li class="breadcrumb-item active" aria-current="page" style="color: green;">List of Disbursed benefit
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Year 2023</li>
                    </ol>
                </nav>
            </div>
            <div class="sidebar mt-5" style="">
                <nav class="nav flex-column">
                    <a class="nav-link active" onclick="showTab('home')">Home&rsaquo;</a>
                    {{-- <a class="nav-link" onclick="showTab('deathbenefit')">Death Benefit&rsaquo;</a> --}}

                    <a class="nav-link" onclick="showTab('familypension')">Family Pension&rsaquo;</a>



                    {{-- documents to get --}}

                    {{--         <a class="nav-link" onclick="showTab('maternity_benefit')">Maternity Assistance&rsaquo;</a>
                    <a class="nav-link" onclick="showTab('educational_assistance')">Educational Assistance&rsaquo;</a>
                    <a class="nav-link" onclick="showTab('medical_assistance')">Medical Assistance&rsaquo;</a>
                    <a class="nav-link" onclick="showTab('deathbenefit')">Death Benefit&rsaquo;</a>
                    <a class="nav-link" onclick="showTab('pension')">General Pension&rsaquo;</a>
                    <a class="nav-link" onclick="showTab('disabilitypension')">Disability Pension&rsaquo;</a>
                     <a class="nav-link" onclick="showTab('FuneralAssistance')">Funeral Assistance&rsaquo;</a>
                    <a class="nav-link" onclick="showTab('TransitShelter')">Transit Shelter – one time- (as per Model
                        Welfare Scheme)&rsaquo;</a>
                    <a class="nav-link" onclick="showTab('CashAward')">Cash Award&rsaquo;</a>
                    <a class="nav-link" onclick="showTab('skilldevelopmenttraining')">Skill Development Training&rsaquo;</a>
                    <a class="nav-link" onclick="showTab('MarriageAssistance')">Marriage Assistance&rsaquo;</a> --}}


                </nav>
            </div>

            <!-- Main Content -->
            <div class="content">
                <div id="home" class="tab-content active ml-5" style="margin-top: 4.5%;">
                    <div class="last-updated ">Last Updated on: <span id="lastUpdatedhome"></span></div>
                    <h4>DISBURSED BENEFIT LIST FOR THE YEAR 2023</h4>


                </div>

                <div id="deathbenefit" class="tab-content mx-5" style="margin-top: 4.5%;">
                    <div class="last-updated">Last Updated on: <span id="lastUpdatedDeathBenefit"></span></div>
                    <h4>Death Benefit</h4>

                    <table class="table">
                        <thead>
                            <tr>
                                <th class="text-primary " style="font-weight: 550;">Sno.</th>
                                <th class="text-primary" style="font-weight: 550;">Districts</th>
                                {{-- <th class="text-primary" style="font-weight: 550;">Size</th> --}}
                                <th class="text-primary" style="font-weight: 550;">Downloads</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="snodeathbenefit"></td>
                                <td class="text-primary" style="font-weight: 550;">Sonitpur </td>
                                {{-- <td id="fileSizeSonitpur1">Loading...</td> --}}
                                <td class="col-md-2 list"><a
                                        href="{{ route('download', 'Sonitpur_2024_L2_Sonitpur_List1.pdf') }}"
                                        id="pdfLinkSonitpur1" style="text-decoration: none;">List 1</a><span class="mx-2">|</span> <a
                                        href="{{ route('download', 'disbursed_deathbenefit_sonitpur.pdf') }}"
                                        id="pdfLinkSonitpur2" style="text-decoration: none;">List 2</a></td>


                            </tr>


                            <tr>
                                <td class="snodeathbenefit"></td>
                                <td class="text-primary" style="font-weight: 550;">Barpeta</td>

                                <td class="col-md-2 list"><a
                                        href="{{ route('download', 'Barpeta_2024_L1_Barpeta_List1.pdf') }}"
                                        id="pdfLinkBarpeta1" style="text-decoration: none;">List 1</a> <span class="mx-2">|</span> <a
                                        href="{{ route('download', 'Barpeta_2024_L2_Barpeta_List2.pdf') }}"
                                        id="pdfLinkBarpeta2" style="text-decoration: none;">List 2</a></td>

                            </tr>



                            <tr>
                                <td class="snodeathbenefit"></td>
                                <td class="text-primary" style="font-weight: 550;">Charaideo</td>
                                <td class="col-md-2 list"><a
                                        href="{{ route('download', 'Charaideo_2024_L1_Charaideo_List_1.pdf') }}"
                                        id="pdfLinkCharaideo1" style="text-decoration: none;">List 1</a> </td>
                            </tr>



                            <tr>
                                <td class="snodeathbenefit"></td>
                                <td class="text-primary" style="font-weight: 550;">Darrang</td>
                                <td class="col-md-2 list"><a
                                        href="{{ route('download', 'Darrang_2024_L1_Darrang_list1.pdf') }}"
                                        id="pdfLinkDarrang1" style="text-decoration: none;">List 1 </a><span class="mx-2">|</span>
                                    <a href="{{ route('download', 'Darrang_2024_L2_Darrang_List2.pdf') }}"
                                        id="pdfLinkDarrang2" style="text-decoration: none;">List 2</a>
                                </td>
                            </tr>



                            <tr>
                                <td class="snodeathbenefit"></td>
                                <td class="text-primary" style="font-weight: 550;">Baksa</td>
                                <td class="col-md-2 list"><a
                                        href="{{ route('download', 'DB_BAKSA_2024_L1_Baksa_List_1.pdf') }}"
                                        id="pdfLinkBaksa" style="text-decoration: none;">List 1</a> </td>
                            </tr>







                            <tr>
                                <td class="snodeathbenefit"></td>
                                <td class="text-primary" style="font-weight: 550;">Dhubri</td>
                                <td class="col-md-2 list"><a
                                        href="{{ route('download', 'Dhubri_2024_L2_Dhubri_List1.pdf') }}"
                                        id="pdfLinkDhubri1" style="text-decoration: none;">List 1 </a><span class="mx-2">|</span>
                                    <a href="{{ route('download', 'DHB_DB_2024_L2_Dhubri_List2.pdf') }}"
                                        id="pdfLinkDhubri2" style="text-decoration: none;">List 2</a>
                                </td>
                            </tr>






                            <tr>
                                <td class="snodeathbenefit"></td>
                                <td class="text-primary" style="font-weight: 550;">Dibrugarh</td>
                                <td class="col-md-2 list"><a
                                        href="{{ route('download', 'Dibrugarh_2024_L1_Dibrugarh_List1.pdf') }}"
                                        id="pdfLinkDibrugarh" style="text-decoration: none;">List 1</a>
                                </td>
                            </tr>



                            <tr>
                                <td class="snodeathbenefit"></td>
                                <td class="text-primary" style="font-weight: 550;">Goalpara</td>
                                <td class="col-md-2 list"><a
                                        href="{{ route('download', 'Goalpara_2024_L1_Goalpara_List1.pdf') }}"
                                        id="pdfLinkGoalpara1" style="text-decoration: none;">List 1 </a><span class="mx-2">|</span>
                                    <a href="{{ route('download', 'Goalpara_2024_L2_Goalpara_List_2.pdf') }}"
                                        id="pdfLinkGoalpara2" style="text-decoration: none;">List 2</a>
                                </td>
                            </tr>




                            <tr>
                                <td class="snodeathbenefit"></td>
                                <td class="text-primary" style="font-weight: 550;">Golaghat</td>
                                <td class="col-md-2 list"><a
                                        href="{{ route('download', 'Golaghat_2024_L1_Golaghat_List1.pdf') }}"
                                        id="pdfLinkGolaghat1" style="text-decoration: none;">List 1 </a><span class="mx-2">|</span>
                                    <a href="{{ route('download', 'Golaghat_2024_L2_Golaghat_List_2.pdf') }}"
                                        id="pdfLinkGolaghat2" style="text-decoration: none;">List 2</a>
                                </td>
                            </tr>




                            <tr>
                                <td class="snodeathbenefit"></td>
                                <td class="text-primary" style="font-weight: 550;">Hailakandi</td>
                                <td class="col-md-2 list"><a
                                        href="{{ route('download', 'Hailakandi_2024_L1_Hailakandi_List1.pdf') }}"
                                        id="pdfLinkHailakandi1" style="text-decoration: none;">List 1</a>
                                </td>
                            </tr>




                            <tr>
                                <td class="snodeathbenefit"></td>
                                <td class="text-primary" style="font-weight: 550;">Jorhat</td>
                                <td class="col-md-2 list"><a
                                        href="{{ route('download', 'Jorhat_2024_L1_Jorhat_List1.pdf') }}"
                                        id="pdfLinkJorhat1" style="text-decoration: none;">List 1 </a><span class="mx-2">|</span>
                                    <a href="{{ route('download', 'Jorhat_2024_L2_Jorhat_List_2.pdf') }}"
                                        id="pdfLinkJorhat2" style="text-decoration: none;">List 2</a>
                                </td>
                            </tr>




                            <tr>
                                <td class="snodeathbenefit"></td>
                                <td class="text-primary" style="font-weight: 550;">Kamrup(M)</td>
                                <td class="col-md-2 list"><a
                                        href="{{ route('download', 'Kamrup_M_2024_L1_Kamrup_M_List1.pdf') }}"
                                        id="pdfLinkKamrupMetro1" style="text-decoration: none;">List 1</a>
                                </td>
                            </tr>





                            <tr>
                                <td class="snodeathbenefit"></td>
                                <td class="text-primary" style="font-weight: 550;">Karbi Anglong </td>
                                <td class="col-md-2 list"><a
                                        href="{{ route('download', 'Karbi_Anglong_2024_L1_Karbi_Anglong_List1.pdf') }}"
                                        id="pdfLinkKarbiAnglong1" style="text-decoration: none;">List 1</a>
                                </td>
                            </tr>




                            <tr>
                                <td class="snodeathbenefit"></td>
                                <td class="text-primary" style="font-weight: 550;">Karimganj</td>
                                <td class="col-md-2 list"><a
                                        href="{{ route('download', 'Karimganj_2024_L1_Karimganj_list1.pdf') }}"
                                        id="pdfLinkKarimganj1" style="text-decoration: none;">List 1 </a><span class="mx-2">|</span>
                                    <a href="{{ route('download', 'Karimganj_2024_L2_Karimganj_List2.pdf') }}"
                                        id="pdfLinkKarimganj2" style="text-decoration: none;">List 2</a>
                                </td>
                            </tr>



                            <tr>
                                <td class="snodeathbenefit"></td>
                                <td class="text-primary" style="font-weight: 550;">Kokrajhar</td>
                                <td class="col-md-2 list"><a
                                        href="{{ route('download', 'Kokrajhar_2024_L1_Kokrajhar_List1.pdf') }}"
                                        id="pdfLinkKokrajhar1" style="text-decoration: none;">List 1</a>
                                </td>
                            </tr>





                            <tr>
                                <td class="snodeathbenefit"></td>
                                <td class="text-primary" style="font-weight: 550;">Lakhimpur</td>
                                <td class="col-md-2 list"><a
                                        href="{{ route('download', 'LKP_2024_L1_Lakhimpur_List1.pdf') }}"
                                        id="pdfLinkLakhimpur1" style="text-decoration: none;">List 1 </a><span class="mx-2">|</span>
                                    <a href="{{ route('download', 'Lakhimpur_2024_L2_Lakhimpur_List2.pdf') }}"
                                        id="pdfLinkLakhimpur2" style="text-decoration: none;">List 2</a>
                                </td>
                            </tr>





                            <tr>
                                <td class="snodeathbenefit"></td>
                                <td class="text-primary" style="font-weight: 550;">Majuli</td>
                                <td class="col-md-2 list"><a
                                        href="{{ route('download', 'Majuli_2024_L1_Majuli_List1.pdf') }}"
                                        id="pdfLinkMajuli1" style="text-decoration: none;">List 1</a>
                                </td>
                            </tr>



                            <tr>
                                <td class="snodeathbenefit"></td>
                                <td class="text-primary" style="font-weight: 550;">Morigaon</td>
                                <td class="col-md-2 list"><a
                                        href="{{ route('download', 'Morigaon_2024_L1_Morigaon_List_1.pdf') }}"
                                        id="pdfLinkMorigaon1" style="text-decoration: none;">List 1 </a><span class="mx-2">|</span>
                                    <a href="{{ route('download', 'Morigaon_2024_L2_Morigaon_List2.pdf') }}"
                                        id="pdfLinkMorigaon2" style="text-decoration: none;">List 2</a>
                                </td>
                            </tr>



                            <tr>
                                <td class="snodeathbenefit"></td>
                                <td class="text-primary" style="font-weight: 550;">Nagaon</td>
                                <td class="col-md-2 list"><a
                                        href="{{ route('download', 'Nagaon_2024_L1_Nagaon_List1.pdf') }}"
                                        id="pdfLinkNagaon1" style="text-decoration: none;">List 1</a>
                                </td>
                            </tr>




                            <tr>
                                <td class="snodeathbenefit"></td>
                                <td class="text-primary" style="font-weight: 550;">Sivasagar</td>
                                <td class="col-md-3 list"><a
                                        href="{{ route('download', 'Sivasagar_2024_L1_Sivasagar_List_1.pdf') }}"
                                        id="pdfLinkSivasagar1" style="text-decoration: none;">List 1 </a><span class="mx-2">|</span>
                                    <a href="{{ route('download', 'Sivasagar_2024_L2_Sivasagar_List2.pdf') }}"
                                        id="pdfLinkSivasagar2" style="text-decoration: none;">List 2</a><span class="mx-2">|</span>
                                    <a href="{{ route('download', 'Sivasagar_2024_L3_Sivasagar_List3.pdf') }}"
                                        id="pdfLinkSivasagar3" style="text-decoration: none;">List 3</a>
                                </td>
                            </tr>




                            <tr>
                                <td class="snodeathbenefit"></td>
                                <td class="text-primary" style="font-weight: 550;">South Salmara Mankachar</td>
                                <td class="col-md-2 list"><a
                                        href="{{ route('download', 'South_salmara_2024_L1_South_Salmara_Mankachar_List1.pdf') }}"
                                        id="pdfLinkMankachar1" style="text-decoration: none;">List 1</a>
                                </td>
                            </tr>




                            <tr>
                                <td class="snodeathbenefit"></td>
                                <td class="text-primary" style="font-weight: 550;">Tinsukia</td>
                                <td class="col-md-2 list"><a href="{{ route('download', 'Tinsukia_2024_L1_Tinsukia_List_1.pdf') }}" id="pdfLinkDhubri1"
                                        style="text-decoration: none;">List 1 </a><span class="mx-2">|</span>
                                    <a href="{{ route('download', 'Tinsukia_2024_L2_Tinsukia_List2.pdf') }}" id="pdfLinkDhubri2"
                                        style="text-decoration: none;">List 2</a><span class="mx-2">|</span>
                                        <a href="{{ route('download', 'Tinsukia_2024_L3_Tinsukia_List3.pdf') }}" id="pdfLinkDhubri2"
                                        style="text-decoration: none;">List 3</a>
                                </td>
                            </tr>





                        </tbody>
                    </table>
                </div>

                <div id="pension" class="tab-content mx-5" style="margin-top: 4.5%;">
                    <div class="last-updated">Last Updated on: <span id="lastUpdatedpension"></span></div>
                    <h4>General Pension</h4>

                    <table class="table">
                        <thead>
                            <tr>
                                <th class="text-primary " style="font-weight: 550;">Sno.</th>
                                <th class="text-primary " style="font-weight: 550;">Districts</th>
                                {{-- <th class="text-primary " style="font-weight: 550;">Size</th> --}}
                                <th class="text-primary " style="font-weight: 550;">Downloads</th>
                            </tr>
                        </thead>
                        <tbody>

                            <tr>
                                <td class="snopension"></td>
                                <td class="text-primary" style="font-weight: 550;">Kamrup(M) (new sanctioned)</td>
                                <td class="col-md-2 list"><a href="{{ route('download', 'for_website-Sanction_list_of_General_Pension_for_Dist-KamMetro-2023LIST-1_KamrupMetro_new_sanctioned_List1.pdf') }}" id="pdfLinkPensionKamrupMetro1"
                                        style="text-decoration: none;">List 1 </a><span class="mx-2">|</span>
                                    <a href="{{ route('download', 'for_website-Sanction_list_of_General_Pension_for_Dist-KamMetro-2023_LIST-2_KamrupMetro_new_sanctioned_List2.pdf') }}" id="pdfLinkPensionKamrupMetro2"
                                        style="text-decoration: none;">List 2</a>
                                </td>
                            </tr>




                            <tr>
                                <td class="snopension"></td>
                                <td class="text-primary" style="font-weight: 550;">Kamrup Rural (new sanctioned)</td>
                                <td class="col-md-2 list"><a href="{{ route('download', 'for_website-Sanction_list_of_General_Pension_for_Dist-KamrupRural-2023LIST-1_Kamrup_new_sanctioned_List1.pdf') }}" id="pdfLinkPensionKamrupRural1"
                                        style="text-decoration: none;">List 1 </a>
                                </td>
                            </tr>



                            <tr>
                                <td class="snopension"></td>
                                <td class="text-primary" style="font-weight: 550;">Monthly Pension (upto Nov'2024) :: All
                                    district </td>
                                <td class="col-md-2 list"><a href="{{ route('download', 'MONTHLY_PENSION_UPTO_NOV_24.pdf') }}" id="pdfLinkPensionAllDistrict"
                                        style="text-decoration: none;">List 1 </a>
                                </td>
                            </tr><tr>
                                <td class="snopension"></td>
                                <td class="text-primary" style="font-weight: 550;">Monthly Pension (upto Feb'2024) :: All
                                    district </td>
                                <td class="col-md-2 list"><a href="{{ route('download', 'monthly_pension_details_upto_feb_2024_Monthly_Pension_upto_Feb_2024_All_district.pdf') }}" id="pdfLinkPensionAllDistrict"
                                        style="text-decoration: none;">List 1 </a>
                                </td>
                            </tr>






                            <tr>
                                <td class="snopension"></td>
                                <td class="text-primary" style="font-weight: 550;">Golaghat (new sanctioned) :: List</td>
                                <td class="col-md-2 list"><a href="{{ route('download', 'new_golaghatGP17_06_2024_Golaghat_new_sanctioned_List1.pdf') }}" id="pdfLinkPensionGolaghat1"
                                        style="text-decoration: none;">List 1 </a>
                                        <span class="mx-2">|</span>
                                    <a href="{{ route('download', 'gp_glg.pdf') }}" id="pdfLinkPensionKamrupMetro2"
                                        style="text-decoration: none;">List 2</a>
                                </td>
                            </tr>

                            <tr>
                                <td class="snopension"></td>
                                <td class="text-primary" style="font-weight: 550;">Darrang :: Accept list</td>
                                <td class="col-md-2 list"><a href="{{ route('download', 'gp_darrang.pdf') }}" id="pdfLinkPensionGolaghat1"
                                        style="text-decoration: none;">List 1 </a>
                                </td>
                            </tr>
                            <tr>
                                <td class="snopension"></td>
                                <td class="text-primary" style="font-weight: 550;">Dhubri :: Accept list</td>
                                <td class="col-md-2 list"><a href="{{ route('download', 'gp_dhubri.pdf') }}" id="pdfLinkPensionGolaghat1"
                                        style="text-decoration: none;">List 1 </a>
                                </td>
                            </tr>
                            <tr>
                                <td class="snopension"></td>
                                <td class="text-primary" style="font-weight: 550;">Lakhimpur :: Accept list</td>
                                <td class="col-md-2 list"><a href="{{ route('download', 'gp_lkp.pdf') }}" id="pdfLinkPensionGolaghat1"
                                        style="text-decoration: none;">List 1 </a>
                                </td>
                            </tr>
                            <tr>
                                <td class="snopension"></td>
                                <td class="text-primary" style="font-weight: 550;">Kokrajhar :: Accept list</td>
                                <td class="col-md-2 list"><a href="{{ route('download', 'gp_kkj.pdf') }}" id="pdfLinkPensionGolaghat1"
                                        style="text-decoration: none;">List 1 </a>
                                </td>
                            </tr>
                            <tr>
                                <td class="snopension"></td>
                                <td class="text-primary" style="font-weight: 550;">Nalbari :: Accept list</td>
                                <td class="col-md-2 list"><a href="{{ route('download', 'gp_nalbari.pdf') }}" id="pdfLinkPensionGolaghat1"
                                        style="text-decoration: none;">List 1 </a>
                                </td>
                            </tr>
                            <tr>
                                <td class="snopension"></td>
                                <td class="text-primary" style="font-weight: 550;">Barpeta :: Accept list</td>
                                <td class="col-md-2 list"><a href="{{ route('download', 'gp_barpeta.pdf') }}" id="pdfLinkPensionGolaghat1"
                                        style="text-decoration: none;">List 1 </a>
                                </td>
                            </tr>



                        </tbody>
                    </table>
                </div>
                <div id="disabilitypension" class="tab-content mx-5" style="margin-top: 4.5%;">
                    <div class="last-updated">Last Updated on: <span id="lastUpdateddisabilitypension"></span></div>
                    <h4>Disability Pension</h4>

                    <table class="table">
                        <thead>
                            <tr class="text-primary " style="font-weight: 550;">
                                <th>Sno.</th>
                                <th>Districts</th>
                                {{-- <th>Size</th> --}}
                                <th>Downloads</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="snodisabilitypension"></td>
                                <td class="text-primary" style="font-weight: 550;">All Districts</td>
                                <td class="col-md-2 list"><a href="{{ route('download', 'DISABILITY_PENSION_2024_L1.pdf') }}" id="pdfLinkdisabilitypensionCachar1"
                                        style="text-decoration: none;">List 1 </a>
                                        <span class="mx-2">|</span>
                                    <a href="{{ route('download', 'DISABILITY_PENSION_2024_L_2.pdf') }}" id="pdfLinkmaternityTinsukia2"
                                    style="text-decoration: none;">List 2 </a>
                                </td>
                            </tr>
                            <tr>
                                <td class="snodisabilitypension"></td>
                                <td class="text-primary" style="font-weight: 550;">Cachar</td>
                                <td class="col-md-2 list"><a href="{{ route('download', 'CHR_MATERNITY_2024_L1_Cachar_List1.pdf') }}" id="pdfLinkdisabilitypensionCachar1"
                                        style="text-decoration: none;">List 1 </a>
                                </td>
                            </tr>



                            <tr>
                                <td class="snodisabilitypension"></td>
                                <td class="text-primary" style="font-weight: 550;">Dhubri</td>
                                <td class="col-md-2 list"><a href="{{ route('download', 'DHB_MATERNITY_2024_L1_Dhubri_List1.pdf') }}" id="pdfLinkmaternityDhubri1"
                                        style="text-decoration: none;">List 1 </a>
                                </td>
                            </tr>

                            <tr>
                                <td class="snodisabilitypension"></td>
                                <td class="text-primary" style="font-weight: 550;">Dhemaji</td>
                                <td class="col-md-2 list"><a href="{{ route('download', 'DMJ_MATERNITY_2024_L1_Dhemaji_List1.pdf') }}" id="pdfLinkmaternityDhemaji1"
                                        style="text-decoration: none;">List 1 </a>
                                </td>
                            </tr>

                            <tr>
                                <td class="snodisabilitypension"></td>
                                <td class="text-primary" style="font-weight: 550;">Golaghat</td>
                                <td class="col-md-2 list"><a href="{{ route('download', 'GLG_MATERNITY_2024_L1_Golaghat_List1.pdf') }}" id="pdfLinkmaternityGolaghat1"
                                        style="text-decoration: none;">List 1 </a>

                                </td>
                            </tr>


                            <tr>
                                <td class="snodisabilitypension"></td>
                                <td class="text-primary" style="font-weight: 550;">Sivasagar</td>
                                <td class="col-md-2 list"> <a href="{{ route('download', 'Maternity_GLG_24_L3_30_11_24_up_Golaghat_List2.pdf') }}" id="pdfLinkmaternityGolaghat2"
                                    style="text-decoration: none;">List 1 </a>

                                </td>
                            </tr>


                            <tr>
                                <td class="snodisabilitypension"></td>
                                <td class="text-primary" style="font-weight: 550;">Darrang</td>
                                <td class="col-md-2 list"> <a href="{{ route('download', 'Maternity_DRG_24_L1_Darrang_List1.pdf') }}" id="pdfLinkmaternityDarrang1"
                                    style="text-decoration: none;">List 1 </a>

                                </td>
                            </tr>

                            <tr>
                                <td class="snodisabilitypension"></td>
                                <td class="text-primary" style="font-weight: 550;">Tinsukia</td>
                                <td class="col-md-3 list"> <a href="{{ route('download', 'Maternity_TSK_24_L1_30_11_24_Tinsukia_List1.pdf') }}" id="pdfLinkmaternityTinsukia1"
                                    style="text-decoration: none;">List 1 </a><span class="mx-2">|</span>
                                    <a href="{{ route('download', 'Maternity_TSK_24_L2_30_11_24up_Tinsukia_List_2.pdf') }}" id="pdfLinkmaternityTinsukia2"
                                    style="text-decoration: none;">List 2 </a><span class="mx-2">|</span>
                                    <a href="{{ route('download', 'Maternity_TSK_2024_L3.pdf') }}" id="pdfLinkmaternityTinsukia3"
                                    style="text-decoration: none;">List 3 </a>

                                </td>
                            </tr>

                            <tr>
                                <td class="snodisabilitypension"></td>
                                <td class="text-primary" style="font-weight: 550;">Kokrajhar</td>
                                <td class="col-md-2 list"> <a href="{{ route('download', 'Maternity_KKJ_24_L1.pdf') }}" id="pdfLinkmaternityKokrajhar1"
                                    style="text-decoration: none;">List 1 </a>

                                </td>
                            </tr>

                            <tr>
                                <td class="snodisabilitypension"></td>
                                <td class="text-primary" style="font-weight: 550;">Barpeta</td>
                                <td class="col-md-2 list"> <a href="{{ route('download', 'Maternity_BPT_24_L1.pdf') }}" id="pdfLinkmaternityBarpeta1"
                                    style="text-decoration: none;">List 1 </a>

                                </td>
                            </tr>

                        </tbody>
                    </table>
                </div>
                <div id="familypension" class="tab-content mx-5" style="margin-top: 4.5%;">
                    <div class="last-updated">Last Updated on: <span id="lastUpdatedpension"></span></div>
                    <h4>Family Pension</h4>

                    <table class="table">
                        <thead>
                            <tr>
                                <th class="text-primary " style="font-weight: 550;">Sno.</th>
                                <th class="text-primary " style="font-weight: 550;">Districts</th>
                                {{-- <th class="text-primary " style="font-weight: 550;">Size</th> --}}
                                <th class="text-primary " style="font-weight: 550;">Downloads</th>
                            </tr>
                        </thead>
                        <tbody>

                            <tr>
                                <td class="snofamilypension"></td>
                                <td class="text-primary" style="font-weight: 550;">All Districts</td>
                                <td class="col-md-2 list"><a href="{{ route('download', 'new_family_pension_2023.pdf') }}" id="pdfLinkPensionKamrupMetro1"
                                        style="text-decoration: none;">List 1 </a>
                                </td>
                            </tr>




                        </tbody>
                    </table>
                </div>
                <div id="maternity_benefit" class="tab-content mx-5" style="margin-top: 4.5%;">
                    <div class="last-updated">Last Updated on: <span id="lastUpdatedmaternity_benefit"></span></div>
                    <h4>Maternity Benefit</h4>

                    <table class="table">
                        <thead>
                            <tr class="text-primary " style="font-weight: 550;">
                                <th>Sno.</th>
                                <th>Districts</th>
                                {{-- <th>Size</th> --}}
                                <th>Downloads</th>
                            </tr>
                        </thead>
                        <tbody>

                            <tr>
                                <td class="snomaternity_benefit"></td>
                                <td class="text-primary" style="font-weight: 550;">Cachar</td>
                                <td class="col-md-2 list"><a href="{{ route('download', 'CHR_MATERNITY_2024_L1_Cachar_List1.pdf') }}" id="pdfLinkmaternityCachar1"
                                        style="text-decoration: none;">List 1 </a>
                                </td>
                            </tr>




                            <tr>
                                <td class="snomaternity_benefit"></td>
                                <td class="text-primary" style="font-weight: 550;">Dhubri</td>
                                <td class="col-md-2 list"><a href="{{ route('download', 'DHB_MATERNITY_2024_L1_Dhubri_List1.pdf') }}" id="pdfLinkmaternityDhubri1"
                                        style="text-decoration: none;">List 1 </a>
                                </td>
                            </tr>

                            <tr>
                                <td class="snomaternity_benefit"></td>
                                <td class="text-primary" style="font-weight: 550;">Dhemaji</td>
                                <td class="col-md-2 list"><a href="{{ route('download', 'DMJ_MATERNITY_2024_L1_Dhemaji_List1.pdf') }}" id="pdfLinkmaternityDhemaji1"
                                        style="text-decoration: none;">List 1 </a>
                                </td>
                            </tr>


                            <tr>
                                <td class="snomaternity_benefit"></td>
                                <td class="text-primary" style="font-weight: 550;">Golaghat</td>
                                <td class="col-md-2 list"><a href="{{ route('download', 'GLG_MATERNITY_2024_L1_Golaghat_List1.pdf') }}" id="pdfLinkmaternityGolaghat1"
                                        style="text-decoration: none;">List 1 </a>

                                </td>
                            </tr>


                            <tr>
                                <td class="snomaternity_benefit"></td>
                                <td class="text-primary" style="font-weight: 550;">Sivasagar</td>
                                <td class="col-md-2 list"> <a href="{{ route('download', 'Maternity_GLG_24_L3_30_11_24_up_Golaghat_List2.pdf') }}" id="pdfLinkmaternityGolaghat2"
                                    style="text-decoration: none;">List 1 </a>

                                </td>
                            </tr>


                            <tr>
                                <td class="snomaternity_benefit"></td>
                                <td class="text-primary" style="font-weight: 550;">Darrang</td>
                                <td class="col-md-2 list"> <a href="{{ route('download', 'Maternity_DRG_24_L1_Darrang_List1.pdf') }}" id="pdfLinkmaternityDarrang1"
                                    style="text-decoration: none;">List 1 </a>

                                </td>
                            </tr>


                            <tr>
                                <td class="snomaternity_benefit"></td>
                                <td class="text-primary" style="font-weight: 550;">Tinsukia</td>
                                <td class="col-md-3 list"> <a href="{{ route('download', 'Maternity_TSK_24_L1_30_11_24_Tinsukia_List1.pdf') }}" id="pdfLinkmaternityTinsukia1"
                                    style="text-decoration: none;">List 1 </a><span class="mx-2">|</span>
                                    <a href="{{ route('download', 'Maternity_TSK_24_L2_30_11_24up_Tinsukia_List_2.pdf') }}" id="pdfLinkmaternityTinsukia2"
                                    style="text-decoration: none;">List 2 </a><span class="mx-2">|</span>
                                    <a href="{{ route('download', 'Maternity_TSK_2024_L3.pdf') }}" id="pdfLinkmaternityTinsukia3"
                                    style="text-decoration: none;">List 3 </a>

                                </td>
                            </tr>

                            <tr>
                                <td class="snomaternity_benefit"></td>
                                <td class="text-primary" style="font-weight: 550;">Kokrajhar</td>
                                <td class="col-md-2 list"> <a href="{{ route('download', 'Maternity_KKJ_24_L1.pdf') }}" id="pdfLinkmaternityKokrajhar1"
                                    style="text-decoration: none;">List 1 </a>

                                </td>
                            </tr>

                            <tr>
                                <td class="snomaternity_benefit"></td>
                                <td class="text-primary" style="font-weight: 550;">Barpeta</td>
                                <td class="col-md-2 list"> <a href="{{ route('download', 'Maternity_BPT_24_L1.pdf') }}" id="pdfLinkmaternityBarpeta1"
                                    style="text-decoration: none;">List 1 </a>

                                </td>
                            </tr>

                        </tbody>
                    </table>
                </div>
                <div id="educational_assistance" class="tab-content mx-5" style="margin-top: 4.5%;">
                    <div class="last-updated">Last Updated on: <span id="lastUpdatededucational_assistance"></span></div>
                    <h4>Educational Assistance</h4>

                    <table class="table">
                        <thead>
                            <tr class="text-primary " style="font-weight: 550;">
                                <th>Sno.</th>
                                <th>Districts</th>
                                {{-- <th>Size</th> --}}
                                <th>Downloads</th>
                            </tr>
                        </thead>
                        <tbody>

                            <tr>
                                <td class="snoeducational_assistance"></td>
                                <td class="text-primary" style="font-weight: 550;">Dhemaji</td>
                                <td class="col-md-2 list"> <a href="{{ route('download', 'EA_DMJ_2023_Dhemaji_List1.pdf') }}" id="pdfLinkeducationalDhemaji1"
                                    style="text-decoration: none;">List 1 </a>

                                </td>
                            </tr>


                            {{-- <tr>
                                <td class="snoeducational"></td>
                                <td class="text-primary " style="font-weight: 550;">Dhemaji :: List </td>
                                <td id="fileSizeeducationalDhemaji1">Loading...</td>
                                <td><a href="{{ route('download', 'EA_DMJ_2023_Dhemaji_List1.pdf') }}"
                                        id="pdfLinkeducationalDhemaji1"><i class="fa fa-file-pdf-o text-danger"
                                            style="font-size: 24px;"></i></a></td>
                            </tr> --}}

                            <tr>
                                <td class="snoeducational_assistance"></td>
                                <td class="text-primary" style="font-weight: 550;">Golaghat</td>
                                <td class="col-md-2 list"> <a href="{{ route('download', 'EA_GLG_2023-2024_20_11_2024_Golaghat_List1.pdf') }}" id="pdfLinkeducationalGolaghat1"
                                    style="text-decoration: none;">List 1 </a>

                                </td>
                            </tr>


                            {{-- <tr>
                                <td class="snoeducational"></td>
                                <td class="text-primary " style="font-weight: 550;">Golaghat :: List </td>
                                <td id="fileSizeeducationalGolaghat1">Loading...</td>
                                <td><a href="{{ route('download', 'EA_GLG_2023-2024_20_11_2024_Golaghat_List1.pdf') }}"
                                        id="pdfLinkeducationalGolaghat1"><i class="fa fa-file-pdf-o text-danger"
                                            style="font-size: 24px;"></i></a></td>
                            </tr> --}}

                            <tr>
                                <td class="snoeducational_assistance"></td>
                                <td class="text-primary" style="font-weight: 550;">Goalpara</td>
                                <td class="col-md-2 list"> <a href="{{ route('download', 'EA_GLP_2022-23_L2_Goalpara_List1.pdf') }}" id="pdfLinkeducationalGoalpara1"
                                    style="text-decoration: none;">List 1 </a>

                                </td>
                            </tr>

                            {{-- <tr>
                                <td class="snoeducational"></td>
                                <td class="text-primary " style="font-weight: 550;">Goalpara :: List </td>
                                <td id="fileSizeeducationalGoalpara1">Loading...</td>
                                <td><a href="{{ route('download', 'EA_GLP_2022-23_L2_Goalpara_List1.pdf') }}"
                                        id="pdfLinkeducationalGoalpara1"><i class="fa fa-file-pdf-o text-danger"
                                            style="font-size: 24px;"></i></a></td>
                            </tr> --}}

                            <tr>
                                <td class="snoeducational_assistance"></td>
                                <td class="text-primary" style="font-weight: 550;">Kamrup (Metro & Rural) & Rangia</td>
                                <td class="col-md-2 list"> <a href="{{ route('download', 'EA_KAM_2022-23_L2_04_01_2025_Kamrup_M_R_List1.pdf') }}" id="pdfLinkeducationalKamrupMR1"
                                    style="text-decoration: none;">List 1 </a>

                                </td>
                            </tr>


                            {{-- <tr>
                                <td class="snoeducational"></td>
                                <td class="text-primary " style="font-weight: 550;">Kamrup (Metro & Rural) :: List </td>
                                <td id="fileSizeeducationalKamrupMR1">Loading...</td>
                                <td><a href="{{ route('download', 'EA_KAM_2022-23_L2_04_01_2025_Kamrup_M_R_List1.pdf') }}"
                                        id="pdfLinkeducationalKamrupMR1"><i class="fa fa-file-pdf-o text-danger"
                                            style="font-size: 24px;"></i></a></td>
                            </tr> --}}

                            <tr>
                                <td class="snoeducational_assistance"></td>
                                <td class="text-primary" style="font-weight: 550;">Morigaon</td>
                                <td class="col-md-2 list"> <a href="{{ route('download', 'EA_MRG_2022-2023L1_Morigaon_List1.pdf') }}" id="pdfLinkeducationalMorigaon1"
                                    style="text-decoration: none;">List 1 </a>

                                </td>
                            </tr>


                            {{-- <tr>
                                <td class="snoeducational"></td>
                                <td class="text-primary " style="font-weight: 550;">Morigaon :: List </td>
                                <td id="fileSizeeducationalMorigaon1">Loading...</td>
                                <td><a href="{{ route('download', 'EA_MRG_2022-2023L1_Morigaon_List1.pdf') }}"
                                        id="pdfLinkeducationalMorigaon1"><i class="fa fa-file-pdf-o text-danger"
                                            style="font-size: 24px;"></i></a></td>
                            </tr> --}}


                            <tr>
                                <td class="snoeducational_assistance"></td>
                                <td class="text-primary" style="font-weight: 550;">Nagaon</td>
                                <td class="col-md-2 list"> <a href="{{ route('download', 'EA_NWG_2023_L1_compressed_Nogaon_list1.pdf') }}" id="pdfLinkeducationalNagaon1"
                                    style="text-decoration: none;">List 1 </a>

                                </td>
                            </tr>

                            {{-- <tr>
                                <td class="snoeducational"></td>
                                <td class="text-primary " style="font-weight: 550;">Nagaon :: List </td>
                                <td id="fileSizeeducationalNagaon1">Loading...</td>
                                <td><a href="{{ route('download', 'EA_NWG_2023_L1_compressed_Nogaon_list1.pdf') }}"
                                        id="pdfLinkeducationalNagaon1"><i class="fa fa-file-pdf-o text-danger"
                                            style="font-size: 24px;"></i></a></td>
                            </tr> --}}


                            <tr>
                                <td class="snoeducational_assistance"></td>
                                <td class="text-primary" style="font-weight: 550;">Lakhimpur</td>
                                <td class="col-md-2 list"> <a href="{{ route('download', 'EA_sanctioned_list_Dist-Lakhimpur2021_Lakhimpur_List1.pdf') }}" id="pdfLinkeducationalLakhimpur1"
                                    style="text-decoration: none;">List 1 </a>

                                </td>
                            </tr>


                            {{-- <tr>
                                <td class="snoeducational"></td>
                                <td class="text-primary " style="font-weight: 550;">Lakhimpur :: List </td>
                                <td id="fileSizeeducationalLakhimpur1">Loading...</td>
                                <td><a href="{{ route('download', 'EA_sanctioned_list_Dist-Lakhimpur2021_Lakhimpur_List1.pdf') }}"
                                        id="pdfLinkeducationalLakhimpur1"><i class="fa fa-file-pdf-o text-danger"
                                            style="font-size: 24px;"></i></a></td>
                            </tr> --}}

                            <tr>
                                <td class="snoeducational_assistance"></td>
                                <td class="text-primary" style="font-weight: 550;">Tinsukia</td>
                                <td class="col-md-2 list"> <a href="{{ route('download', 'EA_sanctioned_list_dist-Tinsukia2024_Tinsukia_List1.pdf') }}" id="pdfLinkeducationalTinsukia1"
                                    style="text-decoration: none;">List 1 </a>

                                </td>
                            </tr>


                            {{-- <tr>
                                <td class="snoeducational"></td>
                                <td class="text-primary " style="font-weight: 550;">Tinsukia :: List </td>
                                <td id="fileSizeeducationalTinsukia1">Loading...</td>
                                <td><a href="{{ route('download', 'EA_sanctioned_list_dist-Tinsukia2024_Tinsukia_List1.pdf') }}"
                                        id="pdfLinkeducationalTinsukia1"><i class="fa fa-file-pdf-o text-danger"
                                            style="font-size: 24px;"></i></a></td>
                            </tr> --}}

                            <tr>
                                <td class="snoeducational_assistance"></td>
                                <td class="text-primary" style="font-weight: 550;">Dhubri</td>
                                <td class="col-md-2 list"> <a href="{{ route('download', 'Sanction_List_EA_DHB_List-1_A_11_12_24_Dhubri_List1_A.pdf') }}" id="pdfLinkeducationalDhubri1A"
                                    style="text-decoration: none;"> List 1 A  </a><span class="mx-2">|</span>
                                    <a href="{{ route('download', 'Sanction_List_EA_Bil_List-1_B_11_12_24_Dhubri_List1_B.pdf') }}" id="pdfLinkeducationalDhubri1B"
                                    style="text-decoration: none;"> List 1 B  </a>

                                </td>
                            </tr>
                            {{-- <tr>
                                <td class="snoeducational"></td>
                                <td class="text-primary " style="font-weight: 550;">Dhubri :: List 1 A</td>
                                <td id="fileSizeeducationalDhubri1A">Loading...</td>
                                <td><a href="{{ route('download', 'Sanction_List_EA_DHB_List-1_A_11_12_24_Dhubri_List1_A.pdf') }}"
                                        id="pdfLinkeducationalDhubri1A"><i class="fa fa-file-pdf-o text-danger"
                                            style="font-size: 24px;"></i></a></td>
                            </tr>
                            <tr>
                                <td class="snoeducational"></td>
                                <td class="text-primary " style="font-weight: 550;">Dhubri :: List 1 B</td>
                                <td id="fileSizeeducationalDhubri1B">Loading...</td>
                                <td><a href="{{ route('download', 'Sanction_List_EA_Bil_List-1_B_11_12_24_Dhubri_List1_B.pdf') }}"
                                        id="pdfLinkeducationalDhubri1B"><i class="fa fa-file-pdf-o text-danger"
                                            style="font-size: 24px;"></i></a></td>
                            </tr> --}}
                            <tr>
                                <td class="snoeducational_assistance"></td>
                                <td class="text-primary" style="font-weight: 550;">Dibrugarh</td>
                                <td class="col-md-2 list"> <a href="{{ route('download', 'sanctioned_list_EA_dibrugarh_6_9_2024_Dibrugarh_List1.pdf') }}" id="pdfLinkeducationalDibrugarh1"
                                    style="text-decoration: none;"> List 1 </a>


                                </td>
                            </tr>
                            {{-- <tr>
                                <td class="snoeducational"></td>
                                <td class="text-primary " style="font-weight: 550;">Dibrugarh :: List </td>
                                <td id="fileSizeeducationalDibrugarh1">Loading...</td>
                                <td><a href="{{ route('download', 'sanctioned_list_EA_dibrugarh_6_9_2024_Dibrugarh_List1.pdf') }}"
                                        id="pdfLinkeducationalDibrugarh1"><i class="fa fa-file-pdf-o text-danger"
                                            style="font-size: 24px;"></i></a></td>
                            </tr> --}}

                            <tr>
                                <td class="snoeducational_assistance"></td>
                                <td class="text-primary" style="font-weight: 550;">Sivasagar</td>
                                <td class="col-md-2 list"> <a href="{{ route('download', 'Sanctioned_list_EA_Sivasagar_2023-24_Sivasagar_List1.pdf') }}" id="pdfLinkeducationalSivasagar1"
                                    style="text-decoration: none;"> List 1 </a>


                                </td>
                            </tr>

                            {{-- <tr>
                                <td class="snoeducational"></td>
                                <td class="text-primary " style="font-weight: 550;">Sivasagar :: List </td>
                                <td id="fileSizeeducationalSivasagar1">Loading...</td>
                                <td><a href="{{ route('download', 'Sanctioned_list_EA_Sivasagar_2023-24_Sivasagar_List1.pdf') }}"
                                        id="pdfLinkeducationalSivasagar1"><i class="fa fa-file-pdf-o text-danger"
                                            style="font-size: 24px;"></i></a></td>
                            </tr> --}}

                            <tr>
                                <td class="snoeducational_assistance"></td>
                                <td class="text-primary" style="font-weight: 550;">Nalbari and Baksa</td>
                                <td class="col-md-2 list"> <a href="{{ route('download', 'sanctioned_list_EA-Nalabri_Baksa2024_Nalbari_Baksa_List1.pdf') }}" id="pdfLinkeducationalNalbariBaksha1"
                                    style="text-decoration: none;"> List 1 </a>


                                </td>
                            </tr>


{{--
                            <tr>
                                <td class="snoeducational"></td>
                                <td class="text-primary " style="font-weight: 550;">Nalbari and Baksa :: List </td>
                                <td id="fileSizeeducationalNalbariBaksha1">Loading...</td>
                                <td><a href="{{ route('download', 'sanctioned_list_EA-Nalabri_Baksa2024_Nalbari_Baksa_List1.pdf') }}"
                                        id="pdfLinkeducationalNalbariBaksha1"><i class="fa fa-file-pdf-o text-danger"
                                            style="font-size: 24px;"></i></a></td>
                            </tr> --}}

                        </tbody>
                    </table>
                </div>
                <div id="medical_assistance" class="tab-content mx-5"style="margin-top: 4.5%;">
                    <div class="last-updated">Last Updated on: <span id="lastUpdatedmedicalassistance"></span></div>
                    <h4>Medical Assistance</h4>

                    <table class="table">
                        <thead>
                            <tr class="text-primary" style="font-weight: 550;">
                                <th>Sno.</th>
                                <th>Districts</th>
                                {{-- <th>Size</th> --}}
                                <th>Downloads</th>
                            </tr>
                        </thead>
                        <tbody>

                            <tr>
                                <td class="snomedical_assistance"></td>
                                <td class="text-primary" style="font-weight: 550;">Bongaigaon</td>
                                <td class="col-md-3 list"><a href="{{ route('download', 'Bongaigaon2024_L1_Bongaigaon_List1.pdf') }}"
                                    id="pdfLinkmedicalassistanceBongaigaon1">List 1 </a><span class="mx-2">|</span>
                                    <a href="{{ route('download', 'MA_BNG_CHR_2023-24_Bongaigaon_List_2.pdf') }}"
                                    id="pdfLinkmedicalassistanceBongaigaon2">List 2</a><span class="mx-2">|</span>
                                    <a href="{{ route('download', 'MA_BNG_2024_L1_up_Bongaigaon_List_3.pdf') }}"
                                        id="pdfLinkmedicalassistanceBongaigaon3">List 3</a>
                                </td>
                            </tr>


                            {{-- <tr>
                                <td class="snomedicalassistance"></td>
                                <td class="text-primary" style="font-weight: 550;">Bongaigaon :: List 1</td>
                                <td id="fileSizemedicalassistanceBongaigaon1">Loading...</td>
                                <td><a href="{{ route('download', 'Bongaigaon2024_L1_Bongaigaon_List1.pdf') }}"
                                        id="pdfLinkmedicalassistanceBongaigaon1"><i class="fa fa-file-pdf-o text-danger"
                                            style="font-size: 24px;"></i></a></td>
                            </tr>
                            <tr>
                                <td class="snomedicalassistance"></td>
                                <td class="text-primary" style="font-weight: 550;">Bongaigaon :: List 2</td>
                                <td id="fileSizemedicalassistanceBongaigaon2">Loading...</td>
                                <td><a href="{{ route('download', 'MA_BNG_CHR_2023-24_Bongaigaon_List_2.pdf') }}"
                                        id="pdfLinkmedicalassistanceBongaigaon2"><i class="fa fa-file-pdf-o text-danger"
                                            style="font-size: 24px;"></i></a></td>
                            </tr>
                            <tr>
                                <td class="snomedicalassistance"></td>
                                <td class="text-primary" style="font-weight: 550;">Bongaigaon :: List 3</td>
                                <td id="fileSizemedicalassistanceBongaigaon3">Loading...</td>
                                <td><a href="{{ route('download', 'MA_BNG_2024_L1_up_Bongaigaon_List_3.pdf') }}"
                                        id="pdfLinkmedicalassistanceBongaigaon3"><i class="fa fa-file-pdf-o text-danger"
                                            style="font-size: 24px;"></i></a></td>
                            </tr> --}}

                            <tr>
                                <td class="snomedical_assistance"></td>
                                <td class="text-primary" style="font-weight: 550;">Cachar</td>
                                <td class="col-md-3 list"><a href="{{ route('download', 'Cachar2024_L1_Cachar_List1.pdf') }}"
                                    id="pdfLinkmedicalassistanceCachar1">List 1 </a>

                                </td>
                            </tr>
                            {{-- <tr>
                                <td class="snomedicalassistance"></td>
                                <td class="text-primary" style="font-weight: 550;">Cachar :: List </td>
                                <td id="fileSizemedicalassistanceCachar1">Loading...</td>
                                <td><a href="{{ route('download', 'Cachar2024_L1_Cachar_List1.pdf') }}"
                                        id="pdfLinkmedicalassistanceCachar1"><i class="fa fa-file-pdf-o text-danger"
                                            style="font-size: 24px;"></i></a></td>
                            </tr> --}}

                            <tr>
                                <td class="snomedical_assistance"></td>
                                <td class="text-primary" style="font-weight: 550;">Dhemaji</td>
                                <td class="col-md-3 list"><a href="{{ route('download', 'Dhemaji2024L1_Dhemaji_List1.pdf') }}"
                                    id="pdfLinkmedicalassistanceDhemaji1">List 1 </a>

                                </td>
                            </tr>


                            {{-- <tr>
                                <td class="snomedicalassistance"></td>
                                <td class="text-primary" style="font-weight: 550;">Dhemaji :: List </td>
                                <td id="fileSizemedicalassistanceDhemaji1">Loading...</td>
                                <td><a href="{{ route('download', 'Dhemaji2024L1_Dhemaji_List1.pdf') }}"
                                        id="pdfLinkmedicalassistanceDhemaji1"><i class="fa fa-file-pdf-o text-danger"
                                            style="font-size: 24px;"></i></a></td>
                            </tr> --}}
                            <tr>
                                <td class="snomedical_assistance"></td>
                                <td class="text-primary" style="font-weight: 550;">Golaghat</td>
                                <td class="col-md-3 list"><a href="{{ route('download', 'Golaghat_2024_L1_Golaghat_List_1.pdf') }}"
                                    id="pdfLinkmedicalassistanceGolaghat1">List 1 </a><span class="mx-2">|</span>
                                    <a href="{{ route('download', 'MA_GLG_2023-24_Golaghat_List_2.pdf') }}"
                                        id="pdfLinkmedicalassistanceGolaghat2"> List 2</a><span class="mx-2">|</span>
                                        <a href="{{ route('download', 'MA_GLG_2024_L1_up_Golaghat_List_3.pdf') }}"
                                        id="pdfLinkmedicalassistanceGolaghat3"> List 3</a>


                                </td>
                            </tr>
                            {{-- <tr>
                                <td class="snomedicalassistance"></td>
                                <td class="text-primary" style="font-weight: 550;">Golaghat :: List 1</td>
                                <td id="fileSizemedicalassistanceGolaghat1">Loading...</td>
                                <td><a href="{{ route('download', 'Golaghat_2024_L1_Golaghat_List_1.pdf') }}"
                                        id="pdfLinkmedicalassistanceGolaghat1"><i class="fa fa-file-pdf-o text-danger"
                                            style="font-size: 24px;"></i></a></td>
                            </tr>
                            <tr>
                                <td class="snomedicalassistance"></td>
                                <td class="text-primary" style="font-weight: 550;">Golaghat :: List 2</td>
                                <td id="fileSizemedicalassistanceGolaghat2">Loading...</td>
                                <td><a href="{{ route('download', 'MA_GLG_2023-24_Golaghat_List_2.pdf') }}"
                                        id="pdfLinkmedicalassistanceGolaghat2"><i class="fa fa-file-pdf-o text-danger"
                                            style="font-size: 24px;"></i></a></td>
                            </tr>
                            <tr>
                                <td class="snomedicalassistance"></td>
                                <td class="text-primary" style="font-weight: 550;">Golaghat :: List 3</td>
                                <td id="fileSizemedicalassistanceGolaghat3">Loading...</td>
                                <td><a href="{{ route('download', 'MA_GLG_2024_L1_up_Golaghat_List_3.pdf') }}"
                                        id="pdfLinkmedicalassistanceGolaghat3"><i class="fa fa-file-pdf-o text-danger"
                                            style="font-size: 24px;"></i></a></td>
                            </tr> --}}

                            <tr>
                                <td class="snomedical_assistance"></td>
                                <td class="text-primary" style="font-weight: 550;">Lakhimpur</td>
                                <td class="col-md-3 list"><a href="{{ route('download', 'Lakhimpur_2024_L1_Lakhimpur_List_1.pdf') }}"
                                    id="pdfLinkmedicalassistanceLakhimpur1">List 1 </a><span class="mx-2">|</span>
                                    <a href="{{ route('download', 'MA_LKP_2023-24_Lakhimpur_List_2.pdf') }}"
                                    id="pdfLinkmedicalassistanceLakhimpur2">List 2</a><span class="mx-2">|</span>
                                    <a href="{{ route('download', 'MA_LKP_2024_L3_09_12_24_Lakhimpur_List_3.pdf') }}"
                                    id="pdfLinkmedicalassistanceLakhimpur3"> List 3</a><span class="mx-2">|</span>
                                    <a href="{{ route('download', 'MA_LKP_2024_L4_30_11_24up_Lakhimpur_List_4.pdf') }}"
                                    id="pdfLinkmedicalassistanceLakhimpur4">List 4</a>


                                </td>
                            </tr>
                            {{-- <tr>
                                <td class="snomedicalassistance"></td>
                                <td class="text-primary" style="font-weight: 550;">Lakhimpur :: List 1</td>
                                <td id="fileSizemedicalassistanceLakhimpur1">Loading...</td>
                                <td><a href="{{ route('download', 'Lakhimpur_2024_L1_Lakhimpur_List_1.pdf') }}"
                                        id="pdfLinkmedicalassistanceLakhimpur1"><i class="fa fa-file-pdf-o text-danger"
                                            style="font-size: 24px;"></i></a></td>
                            </tr>
                            <tr>
                                <td class="snomedicalassistance"></td>
                                <td class="text-primary" style="font-weight: 550;">Lakhimpur :: List 2</td>
                                <td id="fileSizemedicalassistanceLakhimpur2">Loading...</td>
                                <td><a href="{{ route('download', 'MA_LKP_2023-24_Lakhimpur_List_2.pdf') }}"
                                        id="pdfLinkmedicalassistanceLakhimpur2"><i class="fa fa-file-pdf-o text-danger"
                                            style="font-size: 24px;"></i></a></td>
                            </tr>
                            <tr>
                                <td class="snomedicalassistance"></td>
                                <td class="text-primary" style="font-weight: 550;">Lakhimpur :: List 3</td>
                                <td id="fileSizemedicalassistanceLakhimpur3">Loading...</td>
                                <td><a href="{{ route('download', 'MA_LKP_2024_L3_09_12_24_Lakhimpur_List_3.pdf') }}"
                                        id="pdfLinkmedicalassistanceLakhimpur3"><i class="fa fa-file-pdf-o text-danger"
                                            style="font-size: 24px;"></i></a></td>
                            </tr>
                            <tr>
                                <td class="snomedicalassistance"></td>
                                <td class="text-primary" style="font-weight: 550;">Lakhimpur :: List 4</td>
                                <td id="fileSizemedicalassistanceLakhimpur4">Loading...</td>
                                <td><a href="{{ route('download', 'MA_LKP_2024_L4_30_11_24up_Lakhimpur_List_4.pdf') }}"
                                        id="pdfLinkmedicalassistanceLakhimpur4"><i class="fa fa-file-pdf-o text-danger"
                                            style="font-size: 24px;"></i></a></td>
                            </tr> --}}

                            <tr>
                                <td class="snomedical_assistance"></td>
                                <td class="text-primary" style="font-weight: 550;">Kamrup</td>
                                <td class="col-md-3 list"><a href="{{ route('download', 'LI_KAM_24_L2_30_11_24up_Kamrup_List_1.pdf') }}"
                                    id="pdfLinkmedicalassistanceKamrup1">List 1 </a><span class="mx-2">|</span>
                                    <a href="{{ route('download', 'MA_KAM_2023-24_Kamrup_List_1.pdf') }}"
                                        id="pdfLinkmedicalassistanceKamrup2">List 2</a>



                                </td>
                            </tr>


                            {{-- <tr>
                                <td class="snomedicalassistance"></td>
                                <td class="text-primary" style="font-weight: 550;">Kamrup :: List 1</td>
                                <td id="fileSizemedicalassistanceKamrup1">Loading...</td>
                                <td><a href="{{ route('download', 'LI_KAM_24_L2_30_11_24up_Kamrup_List_1.pdf') }}"
                                        id="pdfLinkmedicalassistanceKamrup1"><i class="fa fa-file-pdf-o text-danger"
                                            style="font-size: 24px;"></i></a></td>
                            </tr>
                            <tr>
                                <td class="snomedicalassistance"></td>
                                <td class="text-primary" style="font-weight: 550;">Kamrup :: List 2</td>
                                <td id="fileSizemedicalassistanceKamrup2">Loading...</td>
                                <td><a href="{{ route('download', 'MA_KAM_2023-24_Kamrup_List_1.pdf') }}"
                                        id="pdfLinkmedicalassistanceKamrup2"><i class="fa fa-file-pdf-o text-danger"
                                            style="font-size: 24px;"></i></a></td>
                            </tr> --}}

                            <tr>
                                <td class="snomedical_assistance"></td>
                                <td class="text-primary" style="font-weight: 550;">Barpeta</td>
                                <td class="col-md-3 list"><a href="{{ route('download', 'MA_BPT_2023-24_Barpeta_List1.pdf') }}"
                                    id="pdfLinkmedicalassistanceBarpeta1">List 1 </a><span class="mx-2">|</span>
                                    <a href="{{ route('download', 'MA_BPT_2024_L2_04_12_24_Barpeta_List_2.pdf') }}"
                                        id="pdfLinkmedicalassistanceBarpeta2">List 2</a>



                                </td>
                            </tr>


                            {{-- <tr>
                                <td class="snomedicalassistance"></td>
                                <td class="text-primary" style="font-weight: 550;">Barpeta :: List 1</td>
                                <td id="fileSizemedicalassistanceBarpeta1">Loading...</td>
                                <td><a href="{{ route('download', 'MA_BPT_2023-24_Barpeta_List1.pdf') }}"
                                        id="pdfLinkmedicalassistanceBarpeta1"><i class="fa fa-file-pdf-o text-danger"
                                            style="font-size: 24px;"></i></a></td>
                            </tr>
                            <tr>
                                <td class="snomedicalassistance"></td>
                                <td class="text-primary" style="font-weight: 550;">Barpeta :: List 2</td>
                                <td id="fileSizemedicalassistanceBarpeta2">Loading...</td>
                                <td><a href="{{ route('download', 'MA_BPT_2024_L2_04_12_24_Barpeta_List_2.pdf') }}"
                                        id="pdfLinkmedicalassistanceBarpeta2"><i class="fa fa-file-pdf-o text-danger"
                                            style="font-size: 24px;"></i></a></td>
                            </tr>--}}

                            <tr>
                                <td class="snomedical_assistance"></td>
                                <td class="text-primary" style="font-weight: 550;">Dhubri</td>
                                <td class="col-md-3 list"><a href="{{ route('download', 'MA_DHB_2023-24_Dhubri_List_1.pdf') }}"
                                    id="pdfLinkmedicalassistanceDhubri1">List 1 </a><span class="mx-2">|</span>
                                    <a href="{{ route('download', 'MA_DHB_2024_Dhubri_List_2.pdf') }}"
                                        id="pdfLinkmedicalassistanceDhubri2">List 2</a><span class="mx-2">|</span>
                                        <a href="{{ route('download', 'MA_DHB_2024_L3_04_12_24_Dhubri_List_3.pdf') }}"
                                        id="pdfLinkmedicalassistanceDhubri3">List 3</a>




                                </td>
                            </tr>
                            {{-- <tr>
                                <td class="snomedicalassistance"></td>
                                <td class="text-primary" style="font-weight: 550;">Dhubri :: List 1</td>
                                <td id="fileSizemedicalassistanceDhubri1">Loading...</td>
                                <td><a href="{{ route('download', 'MA_DHB_2023-24_Dhubri_List_1.pdf') }}"
                                        id="pdfLinkmedicalassistanceDhubri1"><i class="fa fa-file-pdf-o text-danger"
                                            style="font-size: 24px;"></i></a></td>
                            </tr>
                            <tr>
                                <td class="snomedicalassistance"></td>
                                <td class="text-primary" style="font-weight: 550;">Dhubri :: List 2</td>
                                <td id="fileSizemedicalassistanceDhubri2">Loading...</td>
                                <td><a href="{{ route('download', 'MA_DHB_2024_Dhubri_List_2.pdf') }}"
                                        id="pdfLinkmedicalassistanceDhubri2"><i class="fa fa-file-pdf-o text-danger"
                                            style="font-size: 24px;"></i></a></td>
                            </tr>
                            <tr>
                                <td class="snomedicalassistance"></td>
                                <td class="text-primary" style="font-weight: 550;">Dhubri :: List 3</td>
                                <td id="fileSizemedicalassistanceDhubri3">Loading...</td>
                                <td><a href="{{ route('download', 'MA_DHB_2024_L3_04_12_24_Dhubri_List_3.pdf') }}"
                                        id="pdfLinkmedicalassistanceDhubri3"><i class="fa fa-file-pdf-o text-danger"
                                            style="font-size: 24px;"></i></a></td>
                            </tr> --}}

                            <tr>
                                <td class="snomedical_assistance"></td>
                                <td class="text-primary" style="font-weight: 550;">Dibrugarh</td>
                                <td class="col-md-3 list"><a href="{{ route('download', 'MA_DIB_2023-24_Dibrugarh_List_1.pdf') }}"
                                    id="pdfLinkmedicalassistanceDibrugarh1">List 1 </a>





                                </td>
                            </tr>


                            {{-- <tr>
                                <td class="snomedicalassistance"></td>
                                <td class="text-primary" style="font-weight: 550;">Dibrugarh :: List </td>
                                <td id="fileSizemedicalassistanceDibrugarh1">Loading...</td>
                                <td><a href="{{ route('download', 'MA_DIB_2023-24_Dibrugarh_List_1.pdf') }}"
                                        id="pdfLinkmedicalassistanceDibrugarh1"><i class="fa fa-file-pdf-o text-danger"
                                            style="font-size: 24px;"></i></a></td>
                            </tr> --}}

                            <tr>
                                <td class="snomedical_assistance"></td>
                                <td class="text-primary" style="font-weight: 550;">Darrang</td>
                                <td class="col-md-3 list"><a href="{{ route('download', 'MA_DRG_2023-24_Darrang_List_1.pdf') }}"
                                    id="pdfLinkmedicalassistanceDarrang1">List 1 </a>


                                </td>
                            </tr>


                            {{-- <tr>
                                <td class="snomedicalassistance"></td>
                                <td class="text-primary" style="font-weight: 550;">Darrang :: List </td>
                                <td id="fileSizemedicalassistanceDarrang1">Loading...</td>
                                <td><a href="{{ route('download', 'MA_DRG_2023-24_Darrang_List_1.pdf') }}"
                                        id="pdfLinkmedicalassistanceDarrang1"><i class="fa fa-file-pdf-o text-danger"
                                            style="font-size: 24px;"></i></a></td>
                            </tr> --}}

                            <tr>
                                <td class="snomedical_assistance"></td>
                                <td class="text-primary" style="font-weight: 550;">Hailakandi</td>
                                <td class="col-md-3 list"><a href="{{ route('download', 'MA_HLK_2022-23_Hailakandi_List_1.pdf') }}"
                                    id="pdfLinkmedicalassistanceHailakandi1">List 1 </a>


                                </td>
                            </tr>


                            {{-- <tr>
                                <td class="snomedicalassistance"></td>
                                <td class="text-primary" style="font-weight: 550;">Hailakandi :: List </td>
                                <td id="fileSizemedicalassistanceHailakandi1">Loading...</td>
                                <td><a href="{{ route('download', 'MA_HLK_2022-23_Hailakandi_List_1.pdf') }}"
                                        id="pdfLinkmedicalassistanceHailakandi1"><i class="fa fa-file-pdf-o text-danger"
                                            style="font-size: 24px;"></i></a></td>
                            </tr> --}}

                            <tr>
                                <td class="snomedical_assistance"></td>
                                <td class="text-primary" style="font-weight: 550;">Jorhat</td>
                                <td class="col-md-3 list"><a href="{{ route('download', 'MA_JOR_2024_L1_04_12_24_Jorhat_List_1.pdf') }}"
                                    id="pdfLinkmedicalassistanceJorhat1">List 1 </a>


                                </td>
                            </tr>


                            {{-- <tr>
                                <td class="snomedicalassistance"></td>
                                <td class="text-primary" style="font-weight: 550;">Jorhat :: List </td>
                                <td id="fileSizemedicalassistanceJorhat1">Loading...</td>
                                <td><a href="{{ route('download', 'MA_JOR_2024_L1_04_12_24_Jorhat_List_1.pdf') }}"
                                        id="pdfLinkmedicalassistanceJorhat1"><i class="fa fa-file-pdf-o text-danger"
                                            style="font-size: 24px;"></i></a></td>
                            </tr> --}}

                            <tr>
                                <td class="snomedical_assistance"></td>
                                <td class="text-primary" style="font-weight: 550;">Kamrup(M) </td>
                                <td class="col-md-3 list"><a href="{{ route('download', 'MA_KAM_M_2023-24_Kamrup_M_List_1.pdf') }}"
                                    id="pdfLinkmedicalassistanceKamrupMetro1">List 1 </a><span class="mx-2">|</span>
                                    <a href="{{ route('download', 'MA_KAM_M_2024_Kamrup_M_List_2.pdf') }}"
                                        id="pdfLinkmedicalassistanceKamrupMetro2">List 2</a>


                                </td>
                            </tr>

                            {{-- <tr>
                                <td class="snomedicalassistance"></td>
                                <td class="text-primary" style="font-weight: 550;">Kamrup(M) :: List 1</td>
                                <td id="fileSizemedicalassistanceKamrupMetro1">Loading...</td>
                                <td><a href="{{ route('download', 'MA_KAM_M_2023-24_Kamrup_M_List_1.pdf') }}"
                                        id="pdfLinkmedicalassistanceKamrupMetro1"><i class="fa fa-file-pdf-o text-danger"
                                            style="font-size: 24px;"></i></a></td>
                            </tr>
                            <tr>
                                <td class="snomedicalassistance"></td>
                                <td class="text-primary" style="font-weight: 550;">Kamrup(M) :: List 2</td>
                                <td id="fileSizemedicalassistanceKamrupMetro2">Loading...</td>
                                <td><a href="{{ route('download', 'MA_KAM_M_2024_Kamrup_M_List_2.pdf') }}"
                                        id="pdfLinkmedicalassistanceKamrupMetro2"><i class="fa fa-file-pdf-o text-danger"
                                            style="font-size: 24px;"></i></a></td>
                            </tr> --}}
                            <tr>
                                <td class="snomedical_assistance"></td>
                                <td class="text-primary" style="font-weight: 550;">Majuli </td>
                                <td class="col-md-3 list"><a href="{{ route('download', 'MA_MJL_2023-24_Majuli_List_1.pdf') }}"
                                    id="pdfLinkmedicalassistanceMajuli1">List 1 </a>



                                </td>
                            </tr>

                            {{-- <tr>
                                <td class="snomedicalassistance"></td>
                                <td class="text-primary" style="font-weight: 550;">Majuli :: List </td>
                                <td id="fileSizemedicalassistanceMajuli1">Loading...</td>
                                <td><a href="{{ route('download', 'MA_MJL_2023-24_Majuli_List_1.pdf') }}"
                                        id="pdfLinkmedicalassistanceMajuli1"><i class="fa fa-file-pdf-o text-danger"
                                            style="font-size: 24px;"></i></a></td>
                            </tr> --}}

                            <tr>
                                <td class="snomedical_assistance"></td>
                                <td class="text-primary" style="font-weight: 550;">Morigaon </td>
                                <td class="col-md-3 list"><a href="{{ route('download', 'MA_MRG_2024_Morigaon_List_1.pdf') }}"
                                    id="pdfLinkmedicalassistanceMorigaon1">List 1 </a>



                                </td>
                            </tr>
                            {{-- <tr>
                                <td class="snomedicalassistance"></td>
                                <td class="text-primary" style="font-weight: 550;">Morigaon :: List </td>
                                <td id="fileSizemedicalassistanceMorigaon1">Loading...</td>
                                <td><a href="{{ route('download', 'MA_MRG_2024_Morigaon_List_1.pdf') }}"
                                        id="pdfLinkmedicalassistanceMorigaon1"><i class="fa fa-file-pdf-o text-danger"
                                            style="font-size: 24px;"></i></a></td>
                            </tr> --}}
                            <tr>
                                <td class="snomedical_assistance"></td>
                                <td class="text-primary" style="font-weight: 550;">Sivasagar </td>
                                <td class="col-md-3 list"><a href="{{ route('download', 'MA_SIV_2023-24_Sivasagar_List_1.pdf') }}"
                                    id="pdfLinkmedicalassistanceSivasagar1">List 1 </a><span class="mx-2">|</span>
                                    <a href="{{ route('download', 'Sivasagar_2024_L1_Sivasagar_List2.pdf') }}"
                                        id="pdfLinkmedicalassistanceSivasagar2">List 2 </a><span class="mx-2">|</span>
                                        <a href="{{ route('download', 'MA_SIV_2024_L1_30_11_24up_Sivasagar_List_4.pdf') }}"
                                        id="pdfLinkmedicalassistanceSivasagar4"> List 3 </a>



                                </td>
                            </tr>
                            {{-- <tr>
                                <td class="snomedicalassistance"></td>
                                <td class="text-primary" style="font-weight: 550;">Sivasagar :: List 1</td>
                                <td id="fileSizemedicalassistanceSivasagar1">Loading...</td>
                                <td><a href="{{ route('download', 'MA_SIV_2023-24_Sivasagar_List_1.pdf') }}"
                                        id="pdfLinkmedicalassistanceSivasagar1"><i class="fa fa-file-pdf-o text-danger"
                                            style="font-size: 24px;"></i></a></td>
                            </tr>
                            <tr>
                                <td class="snomedicalassistance"></td>
                                <td class="text-primary" style="font-weight: 550;">Sivasagar :: List 2</td>
                                <td id="fileSizemedicalassistanceSivasagar2">Loading...</td>
                                <td><a href="{{ route('download', 'Sivasagar_2024_L1_Sivasagar_List2.pdf') }}"
                                        id="pdfLinkmedicalassistanceSivasagar2"><i class="fa fa-file-pdf-o text-danger"
                                            style="font-size: 24px;"></i></a></td>
                            </tr>
                            <tr>
                                <td class="snomedicalassistance"></td>
                                <td class="text-primary" style="font-weight: 550;">Sivasagar :: List 3</td>
                                <td id="fileSizemedicalassistanceSivasagar4">Loading...</td>
                                <td><a href="{{ route('download', 'MA_SIV_2024_L1_30_11_24up_Sivasagar_List_4.pdf') }}"
                                        id="pdfLinkmedicalassistanceSivasagar4"><i class="fa fa-file-pdf-o text-danger"
                                            style="font-size: 24px;"></i></a></td>
                            </tr> --}}

                            <tr>
                                <td class="snomedical_assistance"></td>
                                <td class="text-primary" style="font-weight: 550;">Charaideo </td>
                                <td class="col-md-3 list"><a href="{{ route('download', 'MA_SNR_2023-24_9_Charaideo_List_1.pdf') }}"
                                    id="pdfLinkmedicalassistanceCharaideo1">List 1 </a><span class="mx-2">|</span>
                                    <a href="{{ route('download', 'Sonari_2024_L1_Charaideo_List_2.pdf') }}"
                                        id="pdfLinkmedicalassistanceCharaideo2">List 2 </a>



                                </td>
                            </tr>
                            {{-- <tr>
                                <td class="snomedicalassistance"></td>
                                <td class="text-primary" style="font-weight: 550;">Charaideo :: List 1</td>
                                <td id="fileSizemedicalassistanceCharaideo1">Loading...</td>
                                <td><a href="{{ route('download', 'MA_SNR_2023-24_9_Charaideo_List_1.pdf') }}"
                                        id="pdfLinkmedicalassistanceCharaideo1"><i class="fa fa-file-pdf-o text-danger"
                                            style="font-size: 24px;"></i></a></td>
                            </tr>
                            <tr>
                                <td class="snomedicalassistance"></td>
                                <td class="text-primary" style="font-weight: 550;">Charaideo :: List 2</td>
                                <td id="fileSizemedicalassistanceCharaideo2">Loading...</td>
                                <td><a href="{{ route('download', 'Sonari_2024_L1_Charaideo_List_2.pdf') }}"
                                        id="pdfLinkmedicalassistanceCharaideo2"><i class="fa fa-file-pdf-o text-danger"
                                            style="font-size: 24px;"></i></a></td>
                            </tr> --}}

                            <tr>
                                <td class="snomedical_assistance"></td>
                                <td class="text-primary" style="font-weight: 550;">Sonitpur </td>
                                <td class="col-md-3 list"><a href="{{ route('download', 'MA_STP2023-2024_L1_Sonitpur_List_1.pdf') }}"
                                    id="pdfLinkmedicalassistanceSonitpur1">List 1 </a><span class="mx-2">|</span>
                                    <a href="{{ route('download', 'MA_STP_2023-2024_Sonitpur_List_2.pdf') }}"
                                        id="pdfLinkmedicalassistanceSonitpur2">List 2 </a>



                                </td>
                            </tr>


                            {{-- <tr>
                                <td class="snomedicalassistance"></td>
                                <td class="text-primary" style="font-weight: 550;">Sonitpur :: List 1</td>
                                <td id="fileSizemedicalassistanceSonitpur1">Loading...</td>
                                <td><a href="{{ route('download', 'MA_STP2023-2024_L1_Sonitpur_List_1.pdf') }}"
                                        id="pdfLinkmedicalassistanceSonitpur1"><i class="fa fa-file-pdf-o text-danger"
                                            style="font-size: 24px;"></i></a></td>
                            </tr>
                            <tr>
                                <td class="snomedicalassistance"></td>
                                <td class="text-primary" style="font-weight: 550;">Sonitpur :: List 2</td>
                                <td id="fileSizemedicalassistanceSonitpur2">Loading...</td>
                                <td><a href="{{ route('download', 'MA_STP_2023-2024_Sonitpur_List_2.pdf') }}"
                                        id="pdfLinkmedicalassistanceSonitpur2"><i class="fa fa-file-pdf-o text-danger"
                                            style="font-size: 24px;"></i></a></td>
                            </tr> --}}

                            <tr>
                                <td class="snomedical_assistance"></td>
                                <td class="text-primary" style="font-weight: 550;">Tinsukia </td>
                                <td class="col-md-3 list"><a href="{{ route('download', 'MA_TSK_2024_Tinsukia_List_1.pdf') }}"
                                    id="pdfLinkmedicalassistanceTinsukia1">List 1 </a><span class="mx-2">|</span>
                                    <a href="{{ route('download', 'MA_TSK_2024_L1_up_Tinsukia_List_2.pdf') }}"
                                        id="pdfLinkmedicalassistanceTinsukia2">List 2 </a>



                                </td>
                            </tr>

                            {{-- <tr>
                                <td class="snomedicalassistance"></td>
                                <td class="text-primary" style="font-weight: 550;">Tinsukia :: List 1</td>
                                <td id="fileSizemedicalassistanceTinsukia1">Loading...</td>
                                <td><a href="{{ route('download', 'MA_TSK_2024_Tinsukia_List_1.pdf') }}"
                                        id="pdfLinkmedicalassistanceTinsukia1"><i class="fa fa-file-pdf-o text-danger"
                                            style="font-size: 24px;"></i></a></td>
                            </tr>
                            <tr>
                                <td class="snomedicalassistance"></td>
                                <td class="text-primary" style="font-weight: 550;">Tinsukia :: List 2</td>
                                <td id="fileSizemedicalassistanceTinsukia2">Loading...</td>
                                <td><a href="{{ route('download', 'MA_TSK_2024_L1_up_Tinsukia_List_2.pdf') }}"
                                        id="pdfLinkmedicalassistanceTinsukia2"><i class="fa fa-file-pdf-o text-danger"
                                            style="font-size: 24px;"></i></a></td>
                            </tr> --}}
                            <tr>
                                <td class="snomedical_assistance"></td>
                                <td class="text-primary" style="font-weight: 550;">Udalguri </td>
                                <td class="col-md-3 list"><a href="{{ route('download', 'MA_UDL_2023-24_Udalguri_List_1.pdf') }}"
                                    id="pdfLinkmedicalassistanceUdalguri1">List 1 </a>




                                </td>
                            </tr>

                            {{-- <tr>
                                <td class="snomedicalassistance"></td>
                                <td class="text-primary" style="font-weight: 550;">Udalguri :: List </td>
                                <td id="fileSizemedicalassistanceUdalguri1">Loading...</td>
                                <td><a href="{{ route('download', 'MA_UDL_2023-24_Udalguri_List_1.pdf') }}"
                                        id="pdfLinkmedicalassistanceUdalguri1"><i class="fa fa-file-pdf-o text-danger"
                                            style="font-size: 24px;"></i></a></td>
                            </tr> --}}
                            <tr>
                                <td class="snomedical_assistance"></td>
                                <td class="text-primary" style="font-weight: 550;">Nalbari </td>
                                <td class="col-md-3 list"><a href="{{ route('download', 'Nalbari_2024_L1_Nalbari_List_1.pdf') }}"
                                    id="pdfLinkmedicalassistanceNalbari1">List 1 </a>




                                </td>
                            </tr>
                            {{-- <tr>
                                <td class="snomedicalassistance"></td>
                                <td class="text-primary" style="font-weight: 550;">Nalbari :: List </td>
                                <td id="fileSizemedicalassistanceNalbari1">Loading...</td>
                                <td><a href="{{ route('download', 'Nalbari_2024_L1_Nalbari_List_1.pdf') }}"
                                        id="pdfLinkmedicalassistanceNalbari1"><i class="fa fa-file-pdf-o text-danger"
                                            style="font-size: 24px;"></i></a></td>
                            </tr> --}}



                        </tbody>
                    </table>
                </div>




            </div>
        </div>
    </section>



    <script>
        function showTab(tabId) {
            document.querySelectorAll('.tab-content').forEach(tab => {
                tab.classList.remove('active');
            });
            document.getElementById(tabId).classList.add('active');

            document.querySelectorAll('.nav-link').forEach(link => {
                link.classList.remove('active');
            });
            event.target.classList.add('active');
        }
        document.getElementById("lastUpdatedhome").innerText = new Date().toLocaleDateString('en-GB', {
            day: '2-digit',
            month: 'long',
            year: 'numeric'
        });

        document.getElementById("lastUpdatedDeathBenefit").innerText = new Date().toLocaleDateString('en-GB', {
            day: '2-digit',
            month: 'long',
            year: 'numeric'
        });

        document.getElementById("lastUpdatedpension").innerText = new Date().toLocaleDateString('en-GB', {
            day: '2-digit',
            month: 'long',
            year: 'numeric'
        });
        document.getElementById("lastUpdateddisabilitypension").innerText = new Date().toLocaleDateString('en-GB', {
            day: '2-digit',
            month: 'long',
            year: 'numeric'
        });

        document.getElementById("lastUpdatedmaternity_benefit").innerText = new Date().toLocaleDateString('en-GB', {
            day: '2-digit',
            month: 'long',
            year: 'numeric'
        });

        document.getElementById("lastUpdatededucational_assistance").innerText = new Date().toLocaleDateString('en-GB', {
            day: '2-digit',
            month: 'long',
            year: 'numeric'
        });

        document.getElementById("lastUpdatedmedicalassistance").innerText = new Date().toLocaleDateString('en-GB', {
            day: '2-digit',
            month: 'long',
            year: 'numeric'
        });


    </script>



    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Define all districts in an array
            const districtList = [
                "deathbenefit", "pension",
                "disabilitypension",
                "familypension",

                "maternity_benefit",
                "educational_assistance",
                "medical_assistance"
            ];

            // Loop through each district
            districtList.forEach((district) => {
                const rows = document.querySelectorAll(`.sno${district}`);
                let snoIndex = 1;

                rows.forEach((cell) => {
                    cell.textContent = snoIndex++;
                });
            });
        });
    </script>


@endsection
