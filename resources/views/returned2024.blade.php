@extends('layouts.user-app')

@section('title', 'Benefits returned 2024')

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
            padding: 10px;
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
            /* Ensures borders collapse into a single line */
        }

        .table th,
        .table td {
            border: 1px solid #ddd;
            /* Thin light border */
            padding: 8px;
            /* Adds padding inside each cell for better readability */
            text-align: left;
            /* Aligns the text to the left in the cells */
        }

        .table th {
            background-color: #f5f5f5;
            /* Light background for headers */
        }

        .last-updated {
            position: absolute;

            bottom: 80%;

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




        .returnletter {

            padding: 3px 0px;
            margin-top: 15px;
        }

        .returnletter a {
            color: red;
            font-size: 16px
        }

        .returnletter a:hover {
            color: blue;
            text-shadow: none;
            text-decoration: none;
        }

        .navbar,
        .sticky-top {
            overflow: visible;
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
                        <li class="breadcrumb-item active" aria-current="page" style="color: green;">List of Benefits returned
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Year 2024</li>
                    </ol>
                </nav>
            </div>
            <div class="sidebar">
                <nav class="nav flex-column">
                    <a class="nav-link active" onclick="showTab('home')">Home&rsaquo;</a>
                    <a class="nav-link" onclick="showTab('barpeta')">Barpeta (2024) &rsaquo;</a>
                    <a class="nav-link" onclick="showTab('biswanath')">Biswanath (2024) &rsaquo;</a>
                    <a class="nav-link" onclick="showTab('bongaigaon')">Bongaigaon (2024) &rsaquo;</a>
                    <a class="nav-link" onclick="showTab('darrang')">Darrang (2024) &rsaquo;</a>
                    <a class="nav-link" onclick="showTab('dhubri')">Dhubri (2024) &rsaquo;</a>
                    <a class="nav-link" onclick="showTab('dibrugarh')">Dibrugarh (2024) &rsaquo;</a>
                    <a class="nav-link" onclick="showTab('golaghat')">Golaghat (2024) &rsaquo;</a>
                    <a class="nav-link" onclick="showTab('jorhat')">Jorhat (2024) &rsaquo;</a>
                    <a class="nav-link" onclick="showTab('kamrup')">Kamrup (2024) &rsaquo;</a>
                    <a class="nav-link" onclick="showTab('kamrupmetro')">Kamrup Metro (2024) &rsaquo;</a>
                    <a class="nav-link" onclick="showTab('karbianglong')">Karbi Anglong (2024) &rsaquo;</a>
                    <a class="nav-link" onclick="showTab('karimganj')">Karimganj (2024) &rsaquo;</a>
                    <a class="nav-link" onclick="showTab('lakhimpur')">Lakhimpur (2024) &rsaquo;</a>
                    <a class="nav-link" onclick="showTab('morigaon')">Morigaon (2024) &rsaquo;</a>
                    <a class="nav-link" onclick="showTab('nagaon')">Nagaon (2024) &rsaquo;</a>
                    <a class="nav-link" onclick="showTab('sivasagar')">Sivasagar (2024) &rsaquo;</a>
                    <a class="nav-link" onclick="showTab('tinsukia')">Tinsukia (2024) &rsaquo;</a>
                    <a class="nav-link" onclick="showTab('udalguri')">Udalguri (2024) &rsaquo;</a>
                    <a class="nav-link" onclick="showTab('westkarbianglong')">West Karbi Anglong (2024) &rsaquo;</a>
                    <a class="nav-link" onclick="showTab('cachar')">Cachar (2024) &rsaquo;</a>
                    <a class="nav-link" onclick="showTab('sonitpur')">Sonitpur (2024) &rsaquo;</a>

                    {{-- Documents not got --}}
                    {{--
                    <a class="nav-link" onclick="showTab('hailakandi')">Hailakandi (2024) &rsaquo;</a>
                    <a class="nav-link" onclick="showTab('nalbari')">Nalbari (2024) &rsaquo;</a>



                    <a class="nav-link" onclick="showTab('kaliabor')">Kaliabor (2024) &rsaquo;</a>
                    <a class="nav-link" onclick="showTab('hojai')">Hojai (2024) &rsaquo;</a>
                    <a class="nav-link" onclick="showTab('dimahasao')">Dima Hasao	 (2024) &rsaquo;</a>



                    <a class="nav-link" onclick="showTab('goalpara')">Goalpara (2024) &rsaquo;</a>



                    <a class="nav-link" onclick="showTab('nalbari')">Rangia (2024) &rsaquo;</a>
                    <a class="nav-link" onclick="showTab('bongaigaon')">Gossaigaon	 (2024) &rsaquo;</a>
                    <a class="nav-link" onclick="showTab('hailakandi')">Sorbhog (2024) &rsaquo;</a>








                    <a class="nav-link" onclick="showTab('hailakandi')">Majuli (2024) &rsaquo;</a>


                    <a class="nav-link" onclick="showTab('hailakandi')">Dhemaji (2024) &rsaquo;</a>


                    <a class="nav-link" onclick="showTab('bongaigaon')">Charaideo (2024) &rsaquo;</a>
                    <a class="nav-link" onclick="showTab('hailakandi')">Bajali	 (2024) &rsaquo;</a>
                    <a class="nav-link" onclick="showTab('nalbari')">Kokrajhar (2024) &rsaquo;</a>

                    --}}

                </nav>
            </div>

            <!-- Main Content -->
            <div class="content">
                <div id="home" class="tab-content active">
                    <h4>BENEFITS RETURNED IN THE YEAR 2024</h4>
                    <div class="last-updated ">Last Updated on: <span id="lastUpdatedhome"></span></div>

                </div>

                <div id="barpeta" class="tab-content sticky-top bg-white p-2 ">
                    <h2>Barpeta (2024)</h2>
                    <div class="last-updated">Last Updated on: <span id="lastUpdatedBarpeta"></span></div>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Sno.</th>
                                <th>Title</th>
                                {{-- <th>Size</th> --}}
                                <th>Downloads</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="snoBarpeta"></td>
                                <td>Labour Officer return letter :: Medical Assistance</td>
                                {{-- <td id="fileSizeBongaigaon">Loading...</td> --}}
                                {{-- <td><a href="{{ route('download', 'Return_letter-Bongaigaon_dist_2024.pdf') }}"
                                        id="pdfLinkBongaigaon"><i class="fa fa-file-pdf-o text-danger"></i></a></td> --}}
                                <td class="returnletter"><a
                                        href="{{ route('download', 'LO_Barpeta_MA_return_letter_25_7_24.pdf') }}"
                                        id="pdfLinkBarpeta">Return Letter</a></td>
                            </tr>

                            <tr>
                                <td class="snoBarpeta"></td>
                                <td>Return letter :: Death Benefit</td>

                                <td class="returnletter"><a href="{{ route('download', 'Return_letter_DB_Barpeta.pdf') }}"
                                        id="pdfLinkBarpeta">Return Letter</a></td>
                            </tr>
                            <tr>
                                <td class="snoBarpeta"></td>
                                <td>Labour Officer, Barpeta | Labour Officer, Bhawanipur :: Death Benefit</td>

                                <td class="returnletter"><a
                                        href="{{ route('download', 'Return_letter_Brapeta_Dist_Death_Benefit_2024.pdf') }}"
                                        id="pdfLinkBarpeta">Return Letter</a></td>
                            </tr>
                            <tr>
                                <td class="snoBarpeta"></td>
                                <td>Labour Officer-cum-Registering Officer, Barpeta | Labour Inspector-cum-Registering
                                    Officer, Sorbhog :: General Pension</td>

                                <td class="returnletter"><a
                                        href="{{ route('download', 'reject_letter_for_General_Pension_Barpeta_2024.pdf') }}"
                                        id="pdfLinkBarpeta">Return Letter</a></td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div id="biswanath" class="tab-content sticky-top bg-white p-2 ">
                    <h2>Biswanath (2024)</h2>
                    <div class="last-updated">Last Updated on: <span id="lastUpdatedBiswanath"></span></div>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Sno.</th>
                                <th>Title</th>
                                {{-- <th>Size</th> --}}
                                <th>Downloads</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="snoBiswanath"></td>
                                <td>Labour Officer :: Death Benefit</td>
                                {{-- <td id="fileSizeHailakandi">Loading...</td> --}}
                                <td class="returnletter"><a href="{{ route('download', 'DB_LO_Biswanath_18_10_2024.pdf') }}"
                                        id="pdfLinkBiswanath">Return Letter</a></td>


                            </tr>
                            <tr>
                                <td class="snoBiswanath"></td>
                                <td>Labour Officer, Biswanath & Labour Inspector, Bihali return :: Onetime Educational
                                    Assistance</td>
                                {{-- <td id="fileSizeHailakandi">Loading...</td> --}}
                                <td class="returnletter"><a
                                        href="{{ route('download', 'EA_LO_Biswanath_LI_Bihali_return17_12_24.pdf') }}"
                                        id="pdfLinkBiswanath">Return Letter</a></td>


                            </tr>
                            <tr>
                                <td class="snoBiswanath"></td>
                                <td>Return letter (B. Chariali & Behali) :: Educational Assistance </td>
                                {{-- <td id="fileSizeHailakandi">Loading...</td> --}}
                                <td class="returnletter"><a
                                        href="{{ route('download', 'Return_letter_EA_B_Chariali_Behali.pdf') }}"
                                        id="pdfLinkBiswanath">Return Letter</a></td>


                            </tr>
                        </tbody>
                    </table>
                </div>

                <div id="bongaigaon" class="tab-content sticky-top bg-white p-2 ">
                    <h2>Bongaigaon (2024)</h2>
                    <div class="last-updated">Last Updated on: <span id="lastUpdatedBongaigaon"></span></div>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Sno.</th>
                                <th>Title</th>
                                {{-- <th>Size</th> --}}
                                <th>Downloads</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="snoBongaigaon"></td>
                                <td>Labour Officer :: Educational Assistance </td>
                                {{-- <td id="fileSizeNalbari">Loading...</td> --}}
                                <td class="returnletter"><a href="{{ route('download', 'EA_LO_BNG_merged.pdf') }}"
                                        id="pdfLinkBongaigaon">Return Letter</a></td>
                            </tr>
                        </tbody>
                    </table>
                </div>


                <div id="darrang" class="tab-content sticky-top bg-white p-2 ">
                    <h2>Darrang (2024)</h2>
                    <div class="last-updated">Last Updated on: <span id="lastUpdatedDarrang"></span></div>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Sno.</th>
                                <th>Title</th>
                                {{-- <th>Size</th> --}}
                                <th>Downloads</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="snoDarrang"></td>
                                <td>Labour Officer :: Death Benefit</td>
                                {{-- <td id="fileSizeBongaigaon">Loading...</td> --}}
                                {{-- <td><a href="{{ route('download', 'Return_letter-Bongaigaon_dist_2024.pdf') }}"
                                        id="pdfLinkBongaigaon"><i class="fa fa-file-pdf-o text-danger"></i></a></td> --}}
                                <td class="returnletter"><a
                                        href="{{ route('download', 'LO_Darrang_DB_return_letter_24_7_24.pdf') }}"
                                        id="pdfLinkDarrang">Return Letter</a></td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div id="dhubri" class="tab-content sticky-top bg-white p-2 ">
                    <h2>Dhubri (2024)</h2>
                    <div class="last-updated">Last Updated on: <span id="lastUpdatedDhubri"></span></div>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Sno.</th>
                                <th>Title</th>
                                {{-- <th>Size</th> --}}
                                <th>Downloads</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="snoDhubri"></td>
                                <td>Assistant Labour Commissioner, Dhubri & Labour Inspector, Bilasipara :: Educational
                                    Assistance</td>
                                {{-- <td id="fileSizeHailakandi">Loading...</td> --}}
                                <td class="returnletter"><a
                                        href="{{ route('download', 'ALC_Dhubri_LI_Bilasipara_EA.pdf') }}"
                                        id="pdfLinkDhubri">Return Letter</a></td>


                            </tr>
                            <tr>
                                <td class="snoDhubri"></td>
                                <td>Assistant Labour Commissioner, Dhubri :: Death Benefit</td>

                                <td class="returnletter"><a
                                        href="{{ route('download', 'Return_letter_Dhubri_dist_Death_Benefit_2024.pdf') }}"
                                        id="pdfLinkDhubri">Return Letter</a></td>


                            </tr>
                        </tbody>
                    </table>
                </div>

                <div id="dibrugarh" class="tab-content sticky-top bg-white p-2 ">
                    <h2>Dibrugarh (2024)</h2>
                    <div class="last-updated">Last Updated on: <span id="lastUpdatedDibrugarh"></span></div>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Sno.</th>
                                <th>Title</th>
                                {{-- <th>Size</th> --}}
                                <th>Downloads</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="snoDibrugarh"></td>
                                <td>Assistant Labour Commissioner-cum- Registering Officer :: Death benefit</td>
                                {{-- <td id="fileSizeNalbari">Loading...</td> --}}
                                <td class="returnletter"><a href="{{ route('download', 'ALC_DIB_DB_05_08_2024.pdf') }}"
                                        id="pdfLinkDibrugarh">Return Letter</a></td>
                            </tr>
                            <tr>
                                <td class="snoDibrugarh"></td>
                                <td>Assistant Labour Commissioner-cum- Registering Officer :: Maternity </td>
                                {{-- <td id="fileSizeNalbari">Loading...</td> --}}
                                <td class="returnletter"><a
                                        href="{{ route('download', 'ALC_DIB_Maternity_19_10_2024.pdf') }}"
                                        id="pdfLinkDibrugarh">Return Letter</a></td>
                            </tr>
                            <tr>
                                <td class="snoDibrugarh"></td>
                                <td>Labour Inspector-Cum-Registering Officer :: Death Benefit </td>
                                {{-- <td id="fileSizeNalbari">Loading...</td> --}}
                                <td class="returnletter"><a
                                        href="{{ route('download', 'LI_Naharkatia_DB_26_12_24.pdf') }}"
                                        id="pdfLinkDibrugarh">Return Letter</a></td>
                            </tr>
                            <tr>
                                <td class="snoDibrugarh"></td>
                                <td>Labour Inspector -cum- Registering Officer Joypur return :: Medical Assistance </td>
                                {{-- <td id="fileSizeNalbari">Loading...</td> --}}
                                <td class="returnletter"><a
                                        href="{{ route('download', 'MA_LI_Joypur_return_09_12_2024.pdf') }}"
                                        id="pdfLinkDibrugarh">Return Letter</a></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div id="golaghat" class="tab-content sticky-top bg-white p-2 ">
                    <h2>Golaghat (2024)</h2>
                    <div class="last-updated pb-5 pl-5">Last Updated on: <span id="lastUpdatedGolaghat" ></span></div>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Sno.</th>
                                <th>Title</th>
                                {{-- <th>Size</th> --}}
                                <th>Downloads</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="snoGolaghat"></td>
                                <td>Assistant Labour Commissioner, Golaghat | Labour Officer, Bokakhat | Labour Inspector,
                                    Sarupather</td>
                                {{-- <td id="fileSizeBongaigaon">Loading...</td> --}}
                                {{-- <td><a href="{{ route('download', 'Return_letter-Bongaigaon_dist_2024.pdf') }}"
                                        id="pdfLinkBongaigaon"><i class="fa fa-file-pdf-o text-danger"></i></a></td> --}}
                                <td class="returnletter"><a
                                        href="{{ route('download', 'ALC_GLG_LO_BKT_LI_SPR_DB_return_letter_24_7_24.pdf') }}"
                                        id="pdfLinkGolaghat">Return Letter</a></td>
                            </tr>
                            <tr>
                                <td class="snoGolaghat"></td>
                                <td>Assistant Labour Commissioner, Golaghat</td>

                                <td class="returnletter"><a href="{{ route('download', 'Letter_to_ALC_GLG_1.pdf') }}"
                                        id="pdfLinkGolaghat">Return Letter</a></td>
                            </tr>
                            <tr>
                                <td class="snoGolaghat"></td>
                                <td>Labour Inspector, Sarupathar :: Medical Assistance & Maternity Benefit </td>

                                <td class="returnletter"><a
                                        href="{{ route('download', 'LI_Sarupathar_MA_Maternity.pdf') }}"
                                        id="pdfLinkGolaghat">Return Letter</a></td>
                            </tr>
                            <tr>
                                <td class="snoGolaghat"></td>
                                <td>Labour Inspector, Sarupathar :: Maternity benefit</td>

                                <td class="returnletter"><a
                                        href="{{ route('download', 'LI_Sarupathar_maternity_benefit_29_7_24.pdf') }}"
                                        id="pdfLinkGolaghat">Return Letter</a></td>
                            </tr>
                            <tr>
                                <td class="snoGolaghat"></td>
                                <td>Labour Inspector, Sarupathar :: Medical
                                    Assistance</td>

                                <td class="returnletter"><a
                                        href="{{ route('download', 'LI_Sarupathar_Medical_Assisatnce_26_7_24.pdf') }}"
                                        id="pdfLinkGolaghat">Return Letter</a></td>
                            </tr>
                            <tr>
                                <td class="snoGolaghat"></td>
                                <td>Labour Inspector, Sarupathar :: Maternity Benefit</td>

                                <td class="returnletter"><a
                                        href="{{ route('download', 'LI_SPR_Maternity_2024_rtrn_letter_29_11_24.pdf') }}"
                                        id="pdfLinkGolaghat">Return Letter</a></td>
                            </tr>
                            <tr>
                                <td class="snoGolaghat"></td>
                                <td>Assistant Labour Commissioner, Golaghat :: Medical Assistance return </td>

                                <td class="returnletter"><a
                                        href="{{ route('download', 'MA_ALC_GLG_return_31_12_24.pdf') }}"
                                        id="pdfLinkGolaghat">Return Letter</a></td>
                            </tr>
                            <tr>
                                <td class="snoGolaghat"></td>
                                <td>Assistant Labour Commissioner, Golaghat :: Medical Assistance website </td>

                                <td class="returnletter"><a
                                        href="{{ route('download', 'MA_ALC_GLG_website_21_12_24.pdf') }}"
                                        id="pdfLinkGolaghat">Return Letter</a></td>
                            </tr>
                            <tr>
                                <td class="snoGolaghat"></td>
                                <td>Labour Inspector, Sarupathar :: Medical Assistance</td>

                                <td class="returnletter"><a
                                        href="{{ route('download', 'MA_LI_Sarupathar_30_12_24.pdf') }}"
                                        id="pdfLinkGolaghat">Return Letter</a></td>
                            </tr>
                            <tr>
                                <td class="snoGolaghat"></td>
                                <td>Assistant Labour Commissioner, Golaghat :: Maternity Benefit</td>

                                <td class="returnletter"><a
                                        href="{{ route('download', 'Maternity_GLG_return_Letter_2_nos.pdf') }}"
                                        id="pdfLinkGolaghat">Return Letter</a></td>
                            </tr>

                        </tbody>
                    </table>
                </div>

                <div id="jorhat" class="tab-content sticky-top bg-white p-2 ">
                    <h2>Jorhat (2024)</h2>
                    <div class="last-updated">Last Updated on: <span id="lastUpdatedJorhat"></span></div>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Sno.</th>
                                <th>Title</th>
                                {{-- <th>Size</th> --}}
                                <th>Downloads</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="snoJorhat"></td>
                                <td>Assistant Labour Commissioner, Jorhat :: Death benefit</td>
                                {{-- <td id="fileSizeHailakandi">Loading...</td> --}}
                                <td class="returnletter"><a href="{{ route('download', 'ALC_Jorhat_DB_R_Letter.pdf') }}"
                                        id="pdfLinkJorhat">Return Letter</a></td>


                            </tr>
                            <tr>
                                <td class="snoJorhat"></td>
                                <td>Labour Inspector, Titabor :: Medical Assistance</td>
                                {{-- <td id="fileSizeHailakandi">Loading...</td> --}}
                                <td class="returnletter"><a
                                        href="{{ route('download', 'LI_Titabor_MA_21_08_2024.pdf') }}"
                                        id="pdfLinkJorhat">Return Letter</a></td>


                            </tr>
                            <tr>
                                <td class="snoJorhat"></td>
                                <td>Labour Inspector, Titabor :: Death benefit</td>
                                {{-- <td id="fileSizeHailakandi">Loading...</td> --}}
                                <td class="returnletter"><a
                                        href="{{ route('download', 'Return_letter_of_death_benefit_Titabor_04_11_2024.pdf') }}"
                                        id="pdfLinkJorhat">Return Letter</a></td>


                            </tr>
                        </tbody>
                    </table>
                </div>

                <div id="kamrup" class="tab-content sticky-top bg-white p-2 ">
                    <h2>Kamrup (2024)</h2>
                    <div class="last-updated">Last Updated on: <span id="lastUpdatedKamrup"></span></div>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Sno.</th>
                                <th>Title</th>
                                {{-- <th>Size</th> --}}
                                <th>Downloads</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="snoKamrup"></td>
                                <td>Labour Inspector, Rangia:: Death benefit</td>
                                {{-- <td id="fileSizeNalbari">Loading...</td> --}}
                                <td class="returnletter"><a href="{{ route('download', 'DB_LI_Rangia_4_12_2024.pdf') }}"
                                        id="pdfLinkKamrup">Return Letter</a></td>
                            </tr>
                            <tr>
                                <td class="snoKamrup"></td>
                                <td>Labour Inspector, Rangia and Chhaygaon :: Death benefit</td>
                                {{-- <td id="fileSizeNalbari">Loading...</td> --}}
                                <td class="returnletter"><a
                                        href="{{ route('download', 'Return_letter_DB_Chhaygaon_Rangia.pdf') }}"
                                        id="pdfLinkKamrup">Return Letter</a></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div id="kamrupmetro" class="tab-content sticky-top bg-white p-2 ">
                    <h2>Kamrup Metro (2024)</h2>
                    <div class="last-updated">Last Updated on: <span id="lastUpdatedKamrupMetro"></span></div>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Sno.</th>
                                <th>Title</th>
                                {{-- <th>Size</th> --}}
                                <th>Downloads</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="snoKamrupMetro"></td>
                                <td>Assistant Labour Commissioner, Kamrup Metro :: Death Benefit</td>
                                {{-- <td id="fileSizeBongaigaon">Loading...</td> --}}
                                {{-- <td><a href="{{ route('download', 'Return_letter-Bongaigaon_dist_2024.pdf') }}"
                                        id="pdfLinkBongaigaon"><i class="fa fa-file-pdf-o text-danger"></i></a></td> --}}
                                <td class="returnletter"><a
                                        href="{{ route('download', 'Clarification_letter_ALC_Kamrup_M_05_11_2024.pdf') }}"
                                        id="pdfLinkKamrupMetro">Return Letter</a></td>
                            </tr>
                            <tr>
                                <td class="snoKamrupMetro"></td>
                                <td>Assistant Labour Commissioner, Kamrup Metro :: Health Checkup benefit </td>

                                <td class="returnletter"><a
                                        href="{{ route('download', 'Return_letter_Kamrup_M_dist_Death_benefit_2024.pdf') }}"
                                        id="pdfLinkKamrupMetro">Return Letter</a></td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div id="karbianglong" class="tab-content sticky-top bg-white p-2 ">
                    <h2>Karbi Anglong (2024)</h2>
                    <div class="last-updated">Last Updated on: <span id="lastUpdatedKarbiAnglong"></span></div>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Sno.</th>
                                <th>Title</th>
                                {{-- <th>Size</th> --}}
                                <th>Downloads</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="snoKarbiAnglong"></td>
                                <td>Labour Officer, Diphu :: Medical assistance</td>
                                {{-- <td id="fileSizeHailakandi">Loading...</td> --}}
                                <td class="returnletter"><a
                                        href="{{ route('download', 'MA_Diphu_rtn_letter_9_1_25.pdf') }}"
                                        id="pdfLinkKarbiAnglong">Return Letter</a></td>


                            </tr>
                        </tbody>
                    </table>
                </div>

                <div id="karimganj" class="tab-content sticky-top bg-white p-2 ">
                    <h2>Karimganj (2024)</h2>
                    <div class="last-updated">Last Updated on: <span id="lastUpdatedKarimganj"></span></div>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Sno.</th>
                                <th>Title</th>
                                {{-- <th>Size</th> --}}
                                <th>Downloads</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="snoKarimganj"></td>
                                <td>Labour Officer, Karimganj :: Medical assistance</td>
                                {{-- <td id="fileSizeNalbari">Loading...</td> --}}
                                <td class="returnletter"><a
                                        href="{{ route('download', 'LO_Karimganj_MA_27_08_2024.pdf') }}"
                                        id="pdfLinkKarimganj">Return Letter</a></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div id="lakhimpur" class="tab-content sticky-top bg-white p-2 ">
                    <h2>Lakhimpur (2024)</h2>
                    <div class="last-updated">Last Updated on: <span id="lastUpdatedLakhimpur"></span></div>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Sno.</th>
                                <th>Title</th>
                                {{-- <th>Size</th> --}}
                                <th>Downloads</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="snoLakhimpur"></td>
                                <td>Labour Officer, Lakhimpur & Labour Inspector, Narayanpur :: Death Benefit</td>
                                {{-- <td id="fileSizeBongaigaon">Loading...</td> --}}
                                {{-- <td><a href="{{ route('download', 'Return_letter-Bongaigaon_dist_2024.pdf') }}"
                                        id="pdfLinkBongaigaon"><i class="fa fa-file-pdf-o text-danger"></i></a></td> --}}
                                <td class="returnletter"><a
                                        href="{{ route('download', 'DB_LKP_NPR_return_letter_22_7_24_0.pdf') }}"
                                        id="pdfLinkLakhimpur">Return Letter</a></td>
                            </tr>
                            <tr>
                                <td class="snoLakhimpur"></td>
                                <td>Labour Inspector, Narayanpur :: Medical Assistance</td>
                                {{-- <td id="fileSizeBongaigaon">Loading...</td> --}}
                                {{-- <td><a href="{{ route('download', 'Return_letter-Bongaigaon_dist_2024.pdf') }}"
                                        id="pdfLinkBongaigaon"><i class="fa fa-file-pdf-o text-danger"></i></a></td> --}}
                                <td class="returnletter"><a
                                        href="{{ route('download', 'LI_Narayanpur_MA_return_20_08_2024.pdf') }}"
                                        id="pdfLinkLakhimpur">Return Letter</a></td>
                            </tr>
                            <tr>
                                <td class="snoLakhimpur"></td>
                                <td>Labour Inspector, Nowboicha :: Medical Assistance</td>

                                <td class="returnletter"><a href="{{ route('download', 'LI_Nowboicha_MA_26_7_24.pdf') }}"
                                        id="pdfLinkLakhimpur">Return Letter</a></td>
                            </tr>
                            <tr>
                                <td class="snoLakhimpur"></td>
                                <td>Labour Inspector, Nowboicha :: Medical Assistance Reject Letter</td>
                                {{-- <td id="fileSizeBongaigaon">Loading...</td> --}}
                                {{-- <td><a href="{{ route('download', 'Return_letter-Bongaigaon_dist_2024.pdf') }}"
                                        id="pdfLinkBongaigaon"><i class="fa fa-file-pdf-o text-danger"></i></a></td> --}}
                                <td class="returnletter"><a
                                        href="{{ route('download', 'LI_Nowboicha_MA_Reject_letter.pdf') }}"
                                        id="pdfLinkLakhimpur">Return Letter</a></td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div id="morigaon" class="tab-content sticky-top bg-white p-2 ">
                    <h2>Morigaon (2024)</h2>
                    <div class="last-updated">Last Updated on: <span id="lastUpdatedMorigaon"></span></div>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Sno.</th>
                                <th>Title</th>
                                {{-- <th>Size</th> --}}
                                <th>Downloads</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="snoMorigaon"></td>
                                <td>Labour Officer, Morigaon:: Medical Assistance & Maternity Benefit</td>
                                {{-- <td id="fileSizeHailakandi">Loading...</td> --}}
                                <td class="returnletter"><a
                                        href="{{ route('download', 'MA_Maternity_MRG_return_24_12_24.pdf') }}"
                                        id="pdfLinkMorigaon">Return Letter</a></td>


                            </tr>
                            <tr>
                                <td class="snoMorigaon"></td>
                                <td>Labour Officer, Morigaon:: Educational Assistance </td>

                                <td class="returnletter"><a
                                        href="{{ route('download', 'returned_EA_LO_Morigaon_23_10_2024.pdf') }}"
                                        id="pdfLinkMorigaon">Return Letter</a></td>


                            </tr>
                            <tr>
                                <td class="snoMorigaon"></td>
                                <td>Labour Officer, Morigaon:: Educational Assistance (Resubmission of documents) </td>

                                <td class="returnletter"><a
                                        href="{{ route('download', 'Return_letter_morigaon_dist_Educational_Assistance_2024.pdf') }}"
                                        id="pdfLinkMorigaon">Return Letter</a></td>


                            </tr>
                        </tbody>
                    </table>
                </div>

                <div id="nagaon" class="tab-content sticky-top bg-white p-2 ">
                    <h2>Nagaon (2024)</h2>
                    <div class="last-updated">Last Updated on: <span id="lastUpdatedNagaon"></span></div>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Sno.</th>
                                <th>Title</th>
                                {{-- <th>Size</th> --}}
                                <th>Downloads</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="snoNagaon"></td>
                                <td>Assistant Labour Commissioner, Nagaon :: Maternity Benefit</td>
                                {{-- <td id="fileSizeNalbari">Loading...</td> --}}
                                <td class="returnletter"><a
                                        href="{{ route('download', 'ALC_Nagaon_Maternity_26_7_24.pdf') }}"
                                        id="pdfLinkNagaon">Return Letter</a></td>
                            </tr>
                            <tr>
                                <td class="snoNagaon"></td>
                                <td>Assistant Labour Commissioner, Nagaon :: Medical Assistance return</td>
                                {{-- <td id="fileSizeNalbari">Loading...</td> --}}
                                <td class="returnletter"><a
                                        href="{{ route('download', 'MA_ALC_NAGAON_return_09_12_2024.pdf') }}"
                                        id="pdfLinkNagaon">Return Letter</a></td>
                            </tr>
                            <tr>
                                <td class="snoNagaon"></td>
                                <td>Labour Inspector, Batadrava :: Medical Assistance </td>
                                {{-- <td id="fileSizeNalbari">Loading...</td> --}}
                                <td class="returnletter"><a
                                        href="{{ route('download', 'MA_return_batadrava_23_12_2024.pdf') }}"
                                        id="pdfLinkNagaon">Return Letter</a></td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div id="sivasagar" class="tab-content sticky-top bg-white p-2 ">
                    <h2>Sivasagar (2024)</h2>
                    <div class="last-updated">Last Updated on: <span id="lastUpdatedSivasagar"></span></div>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Sno.</th>
                                <th>Title</th>
                                {{-- <th>Size</th> --}}
                                <th>Downloads</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="snoSivasagar"></td>
                                <td>Assistant Labour Commissioner, Sivasagar:: Death Benefit</td>
                                {{-- <td id="fileSizeBongaigaon">Loading...</td> --}}
                                {{-- <td><a href="{{ route('download', 'Return_letter-Bongaigaon_dist_2024.pdf') }}"
                                        id="pdfLinkBongaigaon"><i class="fa fa-file-pdf-o text-danger"></i></a></td> --}}
                                <td class="returnletter"><a href="{{ route('download', 'ALC_Sivasagar_dist_DB.pdf') }}"
                                        id="pdfLinkSivasagar">Return Letter</a></td>
                            </tr>
                            <tr>
                                <td class="snoSivasagar"></td>
                                <td>Assistant Labour Commissioner , Sivasagar:: Medical Assistance return letter</td>

                                <td class="returnletter"><a
                                        href="{{ route('download', 'MA_ALC_SIV_return_letter_3_1_25.pdf') }}"
                                        id="pdfLinkSivasagar">Return Letter</a></td>
                            </tr>
                            <tr>
                                <td class="snoSivasagar"></td>
                                <td>Labour Inspector, Nazira:: Maternity Benefit</td>

                                <td class="returnletter"><a
                                        href="{{ route('download', 'Maternity_LI_Nazira_return_letter_21_12_24.pdf') }}"
                                        id="pdfLinkSivasagar">Return Letter</a></td>
                            </tr>

                            <tr>
                                <td class="snoSivasagar"></td>
                                <td>ANNEXURE-A</td>

                                <td class="returnletter"><a href="{{ route('download', 'ANNEXURE-A_6_Sivsagar.pdf') }}"
                                        id="pdfLinkSivasagar">Return Letter</a></td>
                            </tr>
                            <tr>
                                <td class="snoSivasagar"></td>
                                <td>ANNEXURE-B</td>

                                <td class="returnletter"><a href="{{ route('download', 'ANNEXURE-B_4_Sivsagar.pdf') }}"
                                        id="pdfLinkSivasagar">Return Letter</a></td>
                            </tr>
                            <tr>
                                <td class="snoSivasagar"></td>
                                <td>Resubmission of documents :: Educational Assistance</td>

                                <td class="returnletter"><a
                                        href="{{ route('download', 'FWD_Resubmission_of_documents_for_credit_of_Educational_Assistance_amount_Sivsagar.pdf') }}"
                                        id="pdfLinkSivasagar">Return Letter</a></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div id="tinsukia" class="tab-content sticky-top bg-white p-2 ">
                    <h2>Tinsukia (2024)</h2>
                    <div class="last-updated">Last Updated on: <span id="lastUpdatedTinsukia"></span></div>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Sno.</th>
                                <th>Title</th>
                                {{-- <th>Size</th> --}}
                                <th>Downloads</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="snoTinsukia"></td>
                                <td>Labour Inspector, Kakopathar:: Medical Assistance</td>
                                {{-- <td id="fileSizeBongaigaon">Loading...</td> --}}
                                {{-- <td><a href="{{ route('download', 'Return_letter-Bongaigaon_dist_2024.pdf') }}"
                                        id="pdfLinkBongaigaon"><i class="fa fa-file-pdf-o text-danger"></i></a></td> --}}
                                <td class="returnletter"><a href="{{ route('download', 'LI_KKP_MA_13_8_24.pdf') }}"
                                        id="pdfLinkTinsukia">Return Letter</a></td>
                            </tr>
                            <tr>
                                <td class="snoTinsukia"></td>
                                <td>ANNEXURE A</td>

                                <td class="returnletter"><a href="{{ route('download', 'ANNEXURE_A.pdf') }}"
                                        id="pdfLinkTinsukia">Return Letter</a></td>
                            </tr>
                            <tr>
                                <td class="snoTinsukia"></td>
                                <td>ANNEXURE B</td>

                                <td class="returnletter"><a href="{{ route('download', 'ANNEXURE_B.pdf') }}"
                                        id="pdfLinkTinsukia">Return Letter</a></td>
                            </tr>
                            <tr>
                                <td class="snoTinsukia"></td>
                                <td>Resubmission of Documents :: Educational Assistance</td>

                                <td class="returnletter"><a
                                        href="{{ route('download', 'FWD_Resubmission_of_documents_for_credit_of_Educational_Assistance_amount_Tinsukia.pdf') }}"
                                        id="pdfLinkTinsukia">Return Letter</a></td>
                            </tr>
                            <tr>
                                <td class="snoTinsukia"></td>
                                <td>Assistant Labour Commissioner :: Medical Assistance</td>

                                <td class="returnletter"><a
                                        href="{{ route('download', 'MA_TSK_return_letter_28_03_2025.pdf') }}"
                                        id="pdfLinkTinsukia">Return Letter</a></td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div id="udalguri" class="tab-content sticky-top bg-white p-2 ">
                    <h2>Udalguri (2024)</h2>
                    <div class="last-updated">Last Updated on: <span id="lastUpdatedUdalguri"></span></div>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Sno.</th>
                                <th>Title</th>
                                {{-- <th>Size</th> --}}
                                <th>Downloads</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="snoUdalguri"></td>
                                <td>Labour Inspector, Khoirabari :: Death benefit</td>
                                {{-- <td id="fileSizeHailakandi">Loading...</td> --}}
                                <td class="returnletter"><a
                                        href="{{ route('download', 'Clarification_letter_LI_khoirabari_05_11_2024.pdf') }}"
                                        id="pdfLinkUdalguri">Return Letter</a></td>


                            </tr>
                            <tr>
                                <td class="snoUdalguri"></td>
                                <td>Labour Inspector, Khoirabari | Labour Inspector, Mazbat :: Educational Assistance</td>
                                {{-- <td id="fileSizeHailakandi">Loading...</td> --}}
                                <td class="returnletter"><a
                                        href="{{ route('download', 'Return_Letter_EA_Khoirabari_Mazbat.pdf') }}"
                                        id="pdfLinkUdalguri">Return Letter</a></td>


                            </tr>
                            <tr>
                                <td class="snoUdalguri"></td>
                                <td>Labour Inspector, Khoirabari | Labour Inspector, Mazbat :: Death benefit</td>
                                {{-- <td id="fileSizeHailakandi">Loading...</td> --}}
                                <td class="returnletter"><a
                                        href="{{ route('download', 'Return_letter_Khoirabari_Mazbat_DB.pdf') }}"
                                        id="pdfLinkUdalguri">Return Letter</a></td>


                            </tr>
                        </tbody>
                    </table>
                </div>

                <div id="westkarbianglong" class="tab-content sticky-top bg-white p-2 ">

                    <h2>West Karbi Anglong (2024)</h2>
                    <div class="last-updated">Last Updated on: <span id="lastUpdatedWestKarbiAnglong"></span></div>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Sno.</th>
                                <th>Title</th>
                                {{-- <th>Size</th> --}}
                                <th>Downloads</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="snoWestKarbiAnglong"></td>
                                <td>Labour Officer, Hamren :: Educational assistance</td>
                                {{-- <td id="fileSizeNalbari">Loading...</td> --}}
                                <td class="returnletter"><a href="{{ route('download', 'EA_LO_Hamren_4_12_2024.pdf') }}"
                                        id="pdfLinkWestKarbiAnglong">Return Letter</a></td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                {{-- datas not got --}}
                <div id="cachar" class="tab-content sticky-top bg-white p-2 ">
                    <h2>Cachar (2024)</h2>
                    <div class="last-updated">Last Updated on: <span id="lastUpdatedCachar"></span></div>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Sno.</th>
                                <th>Title</th>
                                {{-- <th>Size</th> --}}
                                <th>Downloads</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="snoCachar"></td>
                                <td>Assistant Labour Commissioner :: Death Benefit</td>

                                <td class="returnletter"><a
                                        href="{{ route('download', 'Return_letter_Cachar_Dist_Death_Benefit_2024.pdf') }}"
                                        id="pdfLinkCachar">Return Letter</a></td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div id="hailakandi" class="tab-content">
                    <h2>Nalbari (2024)</h2>
                    <div class="last-updated">Last Updated on: <span id="lastUpdatedHailakandi"></span></div>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Sno.</th>
                                <th>Title</th>
                                {{-- <th>Size</th> --}}
                                <th>Downloads</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="snoHailakandi"></td>
                                <td>Labour Officer-cum- R.O, Hailakandi:: Death benefit</td>
                                {{-- <td id="fileSizeHailakandi">Loading...</td> --}}
                                <td class="returnletter"><a
                                        href="{{ route('download', 'Return_letter-Hailakandi_Dist_2024.pdf') }}"
                                        id="pdfLinkHailakandi">Return Letter</a></td>


                            </tr>
                        </tbody>
                    </table>
                </div>

                <div id="nalbari" class="tab-content">
                    <h2>Cachar (2024)</h2>
                    <div class="last-updated">Last Updated on: <span id="lastUpdatedNalbari"></span></div>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Sno.</th>
                                <th>Title</th>
                                {{-- <th>Size</th> --}}
                                <th>Downloads</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="snoNalbari"></td>
                                <td>Labour Inspector-cum- R.O., Nalbari:: Death benefit</td>
                                {{-- <td id="fileSizeNalbari">Loading...</td> --}}
                                <td class="returnletter"><a
                                        href="{{ route('download', 'Return_letter-Nalbari_dist_2024.pdf') }}"
                                        id="pdfLinkNalbari">Return Letter</a></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div id="barpeta" class="tab-content">
                    <h2>Kaliabor (2024)</h2>
                    <div class="last-updated">Last Updated on: <span id="lastUpdatedBongaigaon"></span></div>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Sno.</th>
                                <th>Title</th>
                                {{-- <th>Size</th> --}}
                                <th>Downloads</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="snoBongaigaon"></td>
                                <td>Labour Inspector-cum- R.O. , Bongaigaon:: Death Benefit</td>
                                {{-- <td id="fileSizeBongaigaon">Loading...</td> --}}
                                {{-- <td><a href="{{ route('download', 'Return_letter-Bongaigaon_dist_2024.pdf') }}"
                                        id="pdfLinkBongaigaon"><i class="fa fa-file-pdf-o text-danger"></i></a></td> --}}
                                <td class="returnletter"><a
                                        href="{{ route('download', 'Return_letter-Bongaigaon_dist_2024.pdf') }}"
                                        id="pdfLinkBongaigaon">Return Letter</a></td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div id="hailakandi" class="tab-content">
                    <h2>Hojai (2024)</h2>
                    <div class="last-updated">Last Updated on: <span id="lastUpdatedHailakandi"></span></div>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Sno.</th>
                                <th>Title</th>
                                {{-- <th>Size</th> --}}
                                <th>Downloads</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="snoHailakandi"></td>
                                <td>Labour Officer-cum- R.O, Hailakandi:: Death benefit</td>
                                {{-- <td id="fileSizeHailakandi">Loading...</td> --}}
                                <td class="returnletter"><a
                                        href="{{ route('download', 'Return_letter-Hailakandi_Dist_2024.pdf') }}"
                                        id="pdfLinkHailakandi">Return Letter</a></td>


                            </tr>
                        </tbody>
                    </table>
                </div>

                <div id="nalbari" class="tab-content">
                    <h2>Dima Hasao (2024)</h2>
                    <div class="last-updated">Last Updated on: <span id="lastUpdatedNalbari"></span></div>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Sno.</th>
                                <th>Title</th>
                                {{-- <th>Size</th> --}}
                                <th>Downloads</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="snoNalbari"></td>
                                <td>Labour Inspector-cum- R.O., Nalbari:: Death benefit</td>
                                {{-- <td id="fileSizeNalbari">Loading...</td> --}}
                                <td class="returnletter"><a
                                        href="{{ route('download', 'Return_letter-Nalbari_dist_2024.pdf') }}"
                                        id="pdfLinkNalbari">Return Letter</a></td>
                            </tr>
                        </tbody>
                    </table>
                </div>


                <div id="barpeta" class="tab-content">
                    <h2>Goalpara (2024)</h2>
                    <div class="last-updated">Last Updated on: <span id="lastUpdatedBongaigaon"></span></div>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Sno.</th>
                                <th>Title</th>
                                {{-- <th>Size</th> --}}
                                <th>Downloads</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="snoBongaigaon"></td>
                                <td>Labour Inspector-cum- R.O. , Bongaigaon:: Death Benefit</td>
                                {{-- <td id="fileSizeBongaigaon">Loading...</td> --}}
                                {{-- <td><a href="{{ route('download', 'Return_letter-Bongaigaon_dist_2024.pdf') }}"
                                        id="pdfLinkBongaigaon"><i class="fa fa-file-pdf-o text-danger"></i></a></td> --}}
                                <td class="returnletter"><a
                                        href="{{ route('download', 'Return_letter-Bongaigaon_dist_2024.pdf') }}"
                                        id="pdfLinkBongaigaon">Return Letter</a></td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div id="hailakandi" class="tab-content">
                    <h2>Rangia (2024)</h2>
                    <div class="last-updated">Last Updated on: <span id="lastUpdatedHailakandi"></span></div>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Sno.</th>
                                <th>Title</th>
                                {{-- <th>Size</th> --}}
                                <th>Downloads</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="snoHailakandi"></td>
                                <td>Labour Officer-cum- R.O, Hailakandi:: Death benefit</td>
                                {{-- <td id="fileSizeHailakandi">Loading...</td> --}}
                                <td class="returnletter"><a
                                        href="{{ route('download', 'Return_letter-Hailakandi_Dist_2024.pdf') }}"
                                        id="pdfLinkHailakandi">Return Letter</a></td>


                            </tr>
                        </tbody>
                    </table>
                </div>

                <div id="nalbari" class="tab-content">
                    <h2>Gossaigaon (2024)</h2>
                    <div class="last-updated">Last Updated on: <span id="lastUpdatedNalbari"></span></div>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Sno.</th>
                                <th>Title</th>
                                {{-- <th>Size</th> --}}
                                <th>Downloads</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="snoNalbari"></td>
                                <td>Labour Inspector-cum- R.O., Nalbari:: Death benefit</td>
                                {{-- <td id="fileSizeNalbari">Loading...</td> --}}
                                <td class="returnletter"><a
                                        href="{{ route('download', 'Return_letter-Nalbari_dist_2024.pdf') }}"
                                        id="pdfLinkNalbari">Return Letter</a></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div id="barpeta" class="tab-content">
                    <h2>Sorbhog (2024)</h2>
                    <div class="last-updated">Last Updated on: <span id="lastUpdatedBongaigaon"></span></div>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Sno.</th>
                                <th>Title</th>
                                {{-- <th>Size</th> --}}
                                <th>Downloads</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="snoBongaigaon"></td>
                                <td>Labour Inspector-cum- R.O. , Bongaigaon:: Death Benefit</td>
                                {{-- <td id="fileSizeBongaigaon">Loading...</td> --}}
                                {{-- <td><a href="{{ route('download', 'Return_letter-Bongaigaon_dist_2024.pdf') }}"
                                        id="pdfLinkBongaigaon"><i class="fa fa-file-pdf-o text-danger"></i></a></td> --}}
                                <td class="returnletter"><a
                                        href="{{ route('download', 'Return_letter-Bongaigaon_dist_2024.pdf') }}"
                                        id="pdfLinkBongaigaon">Return Letter</a></td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div id="hailakandi" class="tab-content sticky-top bg-white p-2">
                    <h2>Sonitpur (2024)</h2>
                    <div class="last-updated">Last Updated on: <span id="lastUpdatedHailakandi"></span></div>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Sno.</th>
                                <th>Title</th>
                                {{-- <th>Size</th> --}}
                                <th>Downloads</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="snoHailakandi"></td>
                                <td>Labour Officer-cum- R.O, Hailakandi:: Death benefit</td>
                                {{-- <td id="fileSizeHailakandi">Loading...</td> --}}
                                <td class="returnletter"><a
                                        href="{{ route('download', 'Return_letter-Hailakandi_Dist_2024.pdf') }}"
                                        id="pdfLinkHailakandi">Return Letter</a></td>


                            </tr>
                        </tbody>
                    </table>
                </div>

                <div id="nalbari" class="tab-content">
                    <h2>Majuli (2024)</h2>
                    <div class="last-updated">Last Updated on: <span id="lastUpdatedNalbari"></span></div>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Sno.</th>
                                <th>Title</th>
                                {{-- <th>Size</th> --}}
                                <th>Downloads</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="snoNalbari"></td>
                                <td>Labour Inspector-cum- R.O., Nalbari:: Death benefit</td>
                                {{-- <td id="fileSizeNalbari">Loading...</td> --}}
                                <td class="returnletter"><a
                                        href="{{ route('download', 'Return_letter-Nalbari_dist_2024.pdf') }}"
                                        id="pdfLinkNalbari">Return Letter</a></td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div id="nalbari" class="tab-content">
                    <h2>Dhemaji (2024)</h2>
                    <div class="last-updated">Last Updated on: <span id="lastUpdatedNalbari"></span></div>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Sno.</th>
                                <th>Title</th>
                                {{-- <th>Size</th> --}}
                                <th>Downloads</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="snoNalbari"></td>
                                <td>Labour Inspector-cum- R.O., Nalbari:: Death benefit</td>
                                {{-- <td id="fileSizeNalbari">Loading...</td> --}}
                                <td class="returnletter"><a
                                        href="{{ route('download', 'Return_letter-Nalbari_dist_2024.pdf') }}"
                                        id="pdfLinkNalbari">Return Letter</a></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div id="barpeta" class="tab-content">
                    <h2>Charaideo (2024)</h2>
                    <div class="last-updated">Last Updated on: <span id="lastUpdatedBongaigaon"></span></div>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Sno.</th>
                                <th>Title</th>
                                {{-- <th>Size</th> --}}
                                <th>Downloads</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="snoBongaigaon"></td>
                                <td>Labour Inspector-cum- R.O. , Bongaigaon:: Death Benefit</td>
                                {{-- <td id="fileSizeBongaigaon">Loading...</td> --}}
                                {{-- <td><a href="{{ route('download', 'Return_letter-Bongaigaon_dist_2024.pdf') }}"
                                        id="pdfLinkBongaigaon"><i class="fa fa-file-pdf-o text-danger"></i></a></td> --}}
                                <td class="returnletter"><a
                                        href="{{ route('download', 'Return_letter-Bongaigaon_dist_2024.pdf') }}"
                                        id="pdfLinkBongaigaon">Return Letter</a></td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div id="hailakandi" class="tab-content">
                    <h2>Bajali (2024)</h2>
                    <div class="last-updated">Last Updated on: <span id="lastUpdatedHailakandi"></span></div>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Sno.</th>
                                <th>Title</th>
                                {{-- <th>Size</th> --}}
                                <th>Downloads</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="snoHailakandi"></td>
                                <td>Labour Officer-cum- R.O, Hailakandi:: Death benefit</td>
                                {{-- <td id="fileSizeHailakandi">Loading...</td> --}}
                                <td class="returnletter"><a
                                        href="{{ route('download', 'Return_letter-Hailakandi_Dist_2024.pdf') }}"
                                        id="pdfLinkHailakandi">Return Letter</a></td>


                            </tr>
                        </tbody>
                    </table>
                </div>

                <div id="nalbari" class="tab-content">
                    <h2>Kokrajhar (2024)</h2>
                    <div class="last-updated">Last Updated on: <span id="lastUpdatedNalbari"></span></div>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Sno.</th>
                                <th>Title</th>
                                {{-- <th>Size</th> --}}
                                <th>Downloads</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="snoNalbari"></td>
                                <td>Labour Inspector-cum- R.O., Nalbari:: Death benefit</td>
                                {{-- <td id="fileSizeNalbari">Loading...</td> --}}
                                <td class="returnletter"><a
                                        href="{{ route('download', 'Return_letter-Nalbari_dist_2024.pdf') }}"
                                        id="pdfLinkNalbari">Return Letter</a></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div id="sonitpur" class="tab-content sticky-top bg-white p-2">
                    <h2>Sonitpur (2024)</h2>
                    <div class="last-updated">Last Updated on: <span id="lastUpdatedSonitpur"></span></div>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Sno.</th>
                                <th>Title</th>
                                {{-- <th>Size</th> --}}
                                <th>Downloads</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="snoSonitpur"></td>
                                <td>Resubmission of documents :: Educational Assistance </td>
                                {{-- <td id="fileSizeNalbari">Loading...</td> --}}
                                <td class="returnletter"><a
                                        href="{{ route('download', 'forwarding_and_attachments.pdf') }}"
                                        id="pdfLinkNalbari">Return Letter</a></td>
                            </tr>
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

        document.getElementById("lastUpdatedBongaigaon").innerText = new Date().toLocaleDateString('en-GB', {
            day: '2-digit',
            month: 'long',
            year: 'numeric'
        });

        document.getElementById("lastUpdatedHailakandi").innerText = new Date().toLocaleDateString('en-GB', {
            day: '2-digit',
            month: 'long',
            year: 'numeric'
        });

        document.getElementById("lastUpdatedNalbari").innerText = new Date().toLocaleDateString('en-GB', {
            day: '2-digit',
            month: 'long',
            year: 'numeric'
        });




        document.getElementById("lastUpdatedBarpeta").innerText = new Date().toLocaleDateString('en-GB', {
            day: '2-digit',
            month: 'long',
            year: 'numeric'
        });

        document.getElementById("lastUpdatedBiswanath").innerText = new Date().toLocaleDateString('en-GB', {
            day: '2-digit',
            month: 'long',
            year: 'numeric'
        });

        document.getElementById("lastUpdatedDarrang").innerText = new Date().toLocaleDateString('en-GB', {
            day: '2-digit',
            month: 'long',
            year: 'numeric'
        });

        document.getElementById("lastUpdatedDhubri").innerText = new Date().toLocaleDateString('en-GB', {
            day: '2-digit',
            month: 'long',
            year: 'numeric'
        });

        document.getElementById("lastUpdatedDibrugarh").innerText = new Date().toLocaleDateString('en-GB', {
            day: '2-digit',
            month: 'long',
            year: 'numeric'
        });

        document.getElementById("lastUpdatedGolaghat").innerText = new Date().toLocaleDateString('en-GB', {
            day: '2-digit',
            month: 'long',
            year: 'numeric'
        });

        document.getElementById("lastUpdatedJorhat").innerText = new Date().toLocaleDateString('en-GB', {
            day: '2-digit',
            month: 'long',
            year: 'numeric'
        });

        document.getElementById("lastUpdatedKamrup").innerText = new Date().toLocaleDateString('en-GB', {
            day: '2-digit',
            month: 'long',
            year: 'numeric'
        });

        document.getElementById("lastUpdatedKamrupMetro").innerText = new Date().toLocaleDateString('en-GB', {
            day: '2-digit',
            month: 'long',
            year: 'numeric'
        });

        document.getElementById("lastUpdatedKarbiAnglong").innerText = new Date().toLocaleDateString('en-GB', {
            day: '2-digit',
            month: 'long',
            year: 'numeric'
        });

        document.getElementById("lastUpdatedKarimganj").innerText = new Date().toLocaleDateString('en-GB', {
            day: '2-digit',
            month: 'long',
            year: 'numeric'
        });

        document.getElementById("lastUpdatedLakhimpur").innerText = new Date().toLocaleDateString('en-GB', {
            day: '2-digit',
            month: 'long',
            year: 'numeric'
        });

        document.getElementById("lastUpdatedMorigaon").innerText = new Date().toLocaleDateString('en-GB', {
            day: '2-digit',
            month: 'long',
            year: 'numeric'
        });


        document.getElementById("lastUpdatedNagaon").innerText = new Date().toLocaleDateString('en-GB', {
            day: '2-digit',
            month: 'long',
            year: 'numeric'
        });

        document.getElementById("lastUpdatedSivasagar").innerText = new Date().toLocaleDateString('en-GB', {
            day: '2-digit',
            month: 'long',
            year: 'numeric'
        });

        document.getElementById("lastUpdatedTinsukia").innerText = new Date().toLocaleDateString('en-GB', {
            day: '2-digit',
            month: 'long',
            year: 'numeric'
        });
        document.getElementById("lastUpdatedUdalguri").innerText = new Date().toLocaleDateString('en-GB', {
            day: '2-digit',
            month: 'long',
            year: 'numeric'
        });


        document.getElementById("lastUpdatedWestKarbiAnglong").innerText = new Date().toLocaleDateString('en-GB', {
            day: '2-digit',
            month: 'long',
            year: 'numeric'
        });

        document.getElementById("lastUpdatedCachar").innerText = new Date().toLocaleDateString('en-GB', {
            day: '2-digit',
            month: 'long',
            year: 'numeric'
        });
        document.getElementById("lastUpdatedSonitpur").innerText = new Date().toLocaleDateString('en-GB', {
            day: '2-digit',
            month: 'long',
            year: 'numeric'
        });



        function getFileSize(url, elementId) {
            fetch(url)
                .then(response => {
                    if (response.ok) {
                        const fileSize = response.headers.get('Content-Length'); // Get the file size in bytes
                        if (fileSize) {
                            const fileSizeInKB = (fileSize / 1024).toFixed(2); // Convert size to KB
                            document.getElementById(elementId).innerText = fileSizeInKB + " KB"; // Display size
                        } else {
                            document.getElementById(elementId).innerText = "File size not available";
                        }
                    } else {
                        document.getElementById(elementId).innerText = "Error retrieving size";
                    }
                })
                .catch(error => {
                    document.getElementById(elementId).innerText = "Error retrieving size";
                    console.error("Error fetching file size:", error);
                });
        }

        // Call function to fetch the file size for each PDF link
        window.onload = function() {
            const pdfUrlBongaigaon = document.getElementById("pdfLinkBongaigaon").getAttribute('href');
            getFileSize(pdfUrlBongaigaon, "fileSizeBongaigaon");

            const pdfUrlHailakandi = document.getElementById("pdfLinkHailakandi").getAttribute('href');
            getFileSize(pdfUrlHailakandi, "fileSizeHailakandi");

            const pdfUrlNalbari = document.getElementById("pdfLinkNalbari").getAttribute('href');
            getFileSize(pdfUrlNalbari, "fileSizeNalbari");
        };
    </script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Define all districts in an array
            const districtList = [
                "Barpeta",
                "Biswanath",
                "Bongaigaon",
                "Darrang", "Dhubri", "Dibrugarh", "Golaghat", "Jorhat", "Kamrup", "KamrupMetro", "KarbiAnglong",
                "Karimganj", "Lakhimpur", "Morigaon", "Nagaon", "Sivasagar", "Tinsukia", "Udalguri",
                "WestKarbiAnglong", "Cachar", "Sonitpur"
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
