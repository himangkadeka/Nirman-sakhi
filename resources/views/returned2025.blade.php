@extends('layouts.user-app')

@section('title', 'Benefits returned 2025')

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
                        <li class="breadcrumb-item active" aria-current="page">Year 2025</li>
                    </ol>
                </nav>
            </div>
            <div class="sidebar">
                <nav class="nav flex-column">
                    <a class="nav-link active" onclick="showTab('home')">Home&rsaquo;</a>
                    <a class="nav-link" onclick="showTab('bongaigaon')">Bongaigaon (2025) &rsaquo;</a>
                    <a class="nav-link" onclick="showTab('hailakandi')">Hailakandi (2025) &rsaquo;</a>
                    <a class="nav-link" onclick="showTab('nalbari')">Nalbari (2025) &rsaquo;</a>
                    <a class="nav-link" onclick="showTab('morigaon')">Morigaon (2025) &rsaquo;</a>
                    <a class="nav-link" onclick="showTab('barpeta')">Barpeta (2025) &rsaquo;</a>
                    <a class="nav-link" onclick="showTab('biswanath')">Biswanath (2025) &rsaquo;</a>
                    <a class="nav-link" onclick="showTab('dhubri')">Dhubri (2025) &rsaquo;</a>
                    <a class="nav-link" onclick="showTab('nagaon')">Nagaon (2025) &rsaquo;</a>
                    <a class="nav-link" onclick="showTab('tinsukia')">Tinsukia (2025) &rsaquo;</a>
                    <a class="nav-link" onclick="showTab('chirang')">Chirang (2025) &rsaquo;</a>
                    <a class="nav-link" onclick="showTab('darrang')">Darrang (2025) &rsaquo;</a>
                    <a class="nav-link" onclick="showTab('karimganj')">Karimganj (2025) &rsaquo;</a>
                    <a class="nav-link" onclick="showTab('charaideo')">Charaideo (2025) &rsaquo;</a>

                    {{-- Documents not got --}}
                    {{--




                    <a class="nav-link" onclick="showTab('bongaigaon')">Dima Hasao	 (2025) &rsaquo;</a>
                    <a class="nav-link" onclick="showTab('hailakandi')">Karbi Anglong (2025) &rsaquo;</a>

                    <a class="nav-link" onclick="showTab('bongaigaon')">Kamrup (2025) &rsaquo;</a>
                    <a class="nav-link" onclick="showTab('hailakandi')">Goalpara (2025) &rsaquo;</a>

                    <a class="nav-link" onclick="showTab('bongaigaon')">Dhubri (2025) &rsaquo;</a>
                    <a class="nav-link" onclick="showTab('hailakandi')">Kamrup Metro (2025) &rsaquo;</a>
                    <a class="nav-link" onclick="showTab('nalbari')">Rangia (2025) &rsaquo;</a>
                    <a class="nav-link" onclick="showTab('bongaigaon')">Gossaigaon	 (2025) &rsaquo;</a>
                    <a class="nav-link" onclick="showTab('hailakandi')">Sorbhog (2025) &rsaquo;</a>
                    <a class="nav-link" onclick="showTab('nalbari')">Sonitpur (2025) &rsaquo;</a>
                    <a class="nav-link" onclick="showTab('bongaigaon')">Darrang (2025) &rsaquo;</a>
                    <a class="nav-link" onclick="showTab('hailakandi')">Udalguri (2025) &rsaquo;</a>
                    <a class="nav-link" onclick="showTab('nalbari')">Lakhimpur (2025) &rsaquo;</a>
                    <a class="nav-link" onclick="showTab('bongaigaon')">Biswanath Chariali (2025) &rsaquo;</a>

                    <a class="nav-link" onclick="showTab('nalbari')">Dibrugarh (2025) &rsaquo;</a>
                    <a class="nav-link" onclick="showTab('bongaigaon')">Jorhat	 (2025) &rsaquo;</a>
                    <a class="nav-link" onclick="showTab('hailakandi')">Majuli (2025) &rsaquo;</a>
                    <a class="nav-link" onclick="showTab('nalbari')">Tinsukia (2025) &rsaquo;</a>
                    <a class="nav-link" onclick="showTab('bongaigaon')">Sivasagar (2025) &rsaquo;</a>
                    <a class="nav-link" onclick="showTab('hailakandi')">Dhemaji (2025) &rsaquo;</a>
                    <a class="nav-link" onclick="showTab('nalbari')">Golaghat (2025) &rsaquo;</a>


                    <a class="nav-link" onclick="showTab('hailakandi')">Bajali	 (2025) &rsaquo;</a>
                    <a class="nav-link" onclick="showTab('nalbari')">Kokrajhar (2025) &rsaquo;</a>

                   --}}

                </nav>
            </div>

            <!-- Main Content -->
            <div class="content">
                <div id="home" class="tab-content active">
                    <h4>BENEFITS RETURNED IN THE YEAR 2025</h4>
                    <div class="last-updated ">Last Updated on: <span id="lastUpdatedhome"></span></div>

                </div>

                <div id="bongaigaon" class="tab-content sticky-top bg-white p-2">
                    <h2>Bongaigaon (2025)</h2>
                    <div class="last-updated " >Last Updated on: <span id="lastUpdatedBongaigaon"></span></div>
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
                                {{-- <td><a href="{{ route('download', 'Return_letter-Bongaigaon_dist_2025.pdf') }}"
                                        id="pdfLinkBongaigaon"><i class="fa fa-file-pdf-o text-danger"></i></a></td> --}}
                                <td class="returnletter"><a
                                        href="{{ route('download', 'Return_letter-Bongaigaon_dist_2025.pdf') }}"
                                        id="pdfLinkBongaigaon">Return Letter</a></td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div id="hailakandi" class="tab-content sticky-top bg-white p-2">
                    <h2>Hailakandi (2025)</h2>
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
                                <td class="returnletter"><a href="{{ route('download', 'Return_letter-Hailakandi_Dist_2025.pdf') }}"
                                        id="pdfLinkHailakandi">Return Letter</a></td>


                            </tr>
                            <tr>
                                <td class="snoHailakandi"></td>
                                <td>Labour Officer-cum- R.O, Hailakandi :: Educational Assistance</td>
                                {{-- <td id="fileSizeHailakandi">Loading...</td> --}}
                                <td class="returnletter"><a href="{{ route('download', 'Return_letter_Hailakandi_dist_EA.pdf') }}"
                                        id="pdfLinkHailakandi">Return Letter</a></td>


                            </tr>
                        </tbody>
                    </table>
                </div>

                <div id="nalbari" class="tab-content sticky-top bg-white p-2">
                    <h2>Nalbari (2025)</h2>
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
                                <td class="returnletter"><a href="{{ route('download', 'Return_letter-Nalbari_dist_2025.pdf') }}"
                                        id="pdfLinkNalbari">Return Letter</a></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div id="morigaon" class="tab-content sticky-top bg-white p-2">
                    <h2>Morigaon (2025)</h2>
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
                                <td>Labour Officer, Morigaon:: Maternity benefit</td>

                                <td class="returnletter"><a href="{{ route('download', 'LO_MRG_MA_return_03_03_2025_organized.pdf') }}"
                                        id="pdfLinkMorigaon">Return Letter</a></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div id="barpeta" class="tab-content sticky-top bg-white p-2">
                    <h2>Barpeta (2025)</h2>
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
                                <td>Labour Officer, Barpeta | Labour Officer, Bhawanipur :: Death Benefit</td>

                                <td class="returnletter"><a href="{{ route('download', 'Return_letter_Barpeta_dist_DB_2.pdf') }}"
                                        id="pdfLinkBarpeta">Return Letter</a></td>
                            </tr>
                            <tr>
                                <td class="snoBarpeta"></td>
                                <td>Labour Officer -cum- Registering Officer, Barpeta. :: Death Benefit</td>

                                <td class="returnletter"><a href="{{ route('download', 'Return_letter_Barpeta_dist_DB.pdf') }}"
                                        id="pdfLinkBarpeta">Return Letter</a></td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div id="biswanath" class="tab-content sticky-top bg-white p-2">
                    <h2>Biswanath (2025)</h2>
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
                                <td>Labour Officer, Biswanath :: Death Benefit</td>

                                <td class="returnletter"><a href="{{ route('download', 'Return_letter_Biswanath_dist_DB.pdf') }}"
                                        id="pdfLinkBiswanath">Return Letter</a></td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div id="dhubri" class="tab-content sticky-top bg-white p-2">
                    <h2>Dhubri (2025)</h2>
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
                                <td>Assistant Labour Commissioner -cum- RO, Dhubri :: Resubmission of bank account for Death Benefit</td>

                                <td class="returnletter"><a href="{{ route('download', 'Return_letter_Dhubri_dist_DB.pdf') }}"
                                        id="pdfLinkDhubri">Return Letter</a></td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div id="nagaon" class="tab-content sticky-top bg-white p-2">
                    <h2>Nagaon (2025)</h2>
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
                                <td>Labour inspector -cum- Registering Officer, Batadraba :: Death Benefit</td>

                                <td class="returnletter"><a href="{{ route('download', 'Return_letter_LI_Batadraba_DB.pdf') }}"
                                        id="pdfLinkNagaon">Return Letter</a></td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div id="tinsukia" class="tab-content sticky-top bg-white p-2">
                    <h2>Tinsukia (2025)</h2>
                    <div class="last-updated">Last Updated on: <span id="lastUpdatedTinsukia"></span></div>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Sno.</th>
                                <th>Title</th>

                                <th>Downloads</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="snoTinsukia"></td>
                                <td>Assistant Labour Commissioner -cum- Registering Officer :: Death Benefit</td>

                                <td class="returnletter"><a href="{{ route('download', 'Return_letter_Tinsukia_dist_DB.pdf') }}"
                                        id="pdfLinkTinsukia">Return Letter</a></td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div id="chirang" class="tab-content sticky-top bg-white p-2">
                    <h2>Chirang (2025)</h2>
                    <div class="last-updated">Last Updated on: <span id="lastUpdatedChirang"></span></div>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Sno.</th>
                                <th>Title</th>

                                <th>Downloads</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="snoChirang"></td>
                                <td>Labour Officer -cum- Registering Officer ::  Educational Assistance</td>

                                <td class="returnletter"><a href="{{ route('download', 'Return_letter_Chirang_dist_EA.pdf') }}"
                                        id="pdfLinkChirang">Return Letter</a></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div id="darrang" class="tab-content sticky-top bg-white p-2">
                    <h2>Darrang (2025)</h2>
                    <div class="last-updated">Last Updated on: <span id="lastUpdatedDarrang"></span></div>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Sno.</th>
                                <th>Title</th>

                                <th>Downloads</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="snoDarrang"></td>
                                <td>Labour Officer -cum- Registering Officer, Darrang :: Death Benefit</td>

                                <td class="returnletter"><a href="{{ route('download', 'Return_letter_Darrang_dist_DB.pdf') }}"
                                        id="pdfLinkDarrang">Return Letter</a></td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div id="karimganj" class="tab-content sticky-top bg-white p-2">
                    <h2>Karimganj (2025)</h2>
                    <div class="last-updated">Last Updated on: <span id="lastUpdatedKarimganj"></span></div>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Sno.</th>
                                <th>Title</th>

                                <th>Downloads</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="snoKarimganj"></td>
                                <td>Labour Officer -cum- Registering Officer, Karimganj :: Maternity Benefit</td>

                                <td class="returnletter"><a href="{{ route('download', 'LO_karimganj_Maternity_benefit_return_letter_3nos.pdf') }}"
                                        id="pdfLinkKarimganj">Return Letter</a></td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div id="charaideo" class="tab-content sticky-top bg-white p-2">
                    <h2>Charaideo (2025)</h2>
                    <div class="last-updated">Last Updated on: <span id="lastUpdatedCharaideo"></span></div>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Sno.</th>
                                <th>Title</th>

                                <th>Downloads</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="snoCharaideo"></td>
                                <td>Labour Officer -cum- Registering Officer, Sonari :: Educational Assistance</td>

                                <td class="returnletter"><a href="{{ route('download', 'Return_letter_educational_assistance_Charaideo_Dist_Sonari.pdf') }}"
                                        id="pdfLinkCharaideo">Return Letter</a></td>
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
        document.getElementById("lastUpdatedMorigaon").innerText = new Date().toLocaleDateString('en-GB', {
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
        document.getElementById("lastUpdatedDhubri").innerText = new Date().toLocaleDateString('en-GB', {
            day: '2-digit',
            month: 'long',
            year: 'numeric'
        });
        document.getElementById("lastUpdatedNagaon").innerText = new Date().toLocaleDateString('en-GB', {
            day: '2-digit',
            month: 'long',
            year: 'numeric'
        });
        document.getElementById("lastUpdatedTinsukia").innerText = new Date().toLocaleDateString('en-GB', {
            day: '2-digit',
            month: 'long',
            year: 'numeric'
        });
        document.getElementById("lastUpdatedChirang").innerText = new Date().toLocaleDateString('en-GB', {
            day: '2-digit',
            month: 'long',
            year: 'numeric'
        });
        document.getElementById("lastUpdatedDarrang").innerText = new Date().toLocaleDateString('en-GB', {
            day: '2-digit',
            month: 'long',
            year: 'numeric'
        });
        document.getElementById("lastUpdatedKarimganj").innerText = new Date().toLocaleDateString('en-GB', {
            day: '2-digit',
            month: 'long',
            year: 'numeric'
        });
        document.getElementById("lastUpdatedCharaideo").innerText = new Date().toLocaleDateString('en-GB', {
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
            const pdfUrlMorigaon = document.getElementById("pdfLinkMorigaon").getAttribute('href');
            getFileSize(pdfUrlMorigaon, "fileSizeMorigaon");
        };
    </script>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Get all table rows
        const rows = document.querySelectorAll('tbody tr');

        // Initialize separate counters for sno, snopension, and snomaternity
        let snoBongaigaonIndex = 1;
        let snoHailakandiIndex = 1;
        let snoNalbariIndex = 1;
        let snoMorigaonIndex=1;
        let snoBarpetaIndex = 1;
        let snoBiswanathIndex = 1;
        let snoDhubriIndex = 1;
        let snoNagaonIndex=1;
        let snoTinsukiaIndex=1;
        let snoDarrangIndex=1;
        let snoChirangIndex=1;
        let snoKarimganjIndex=1;
        let snoCharaideoIndex=1;



        rows.forEach((row) => {
            // Find and set serial number for "sno" class
            const snoBongaigaonCell = row.querySelector('.snoBongaigaon');
            if (snoBongaigaonCell) {
                snoBongaigaonCell.textContent = snoBongaigaonIndex++;
            }


            const snoHailakandiCell = row.querySelector('.snoHailakandi');
            if (snoHailakandiCell) {
                snoHailakandiCell.textContent = snoHailakandiIndex++;
            }

            // Find and set serial number for "snomaternity" class
            const snoNalbariCell = row.querySelector('.snoNalbari');
            if (snoNalbariCell) {
                snoNalbariCell.textContent = snoNalbariIndex++;
            }

            const snoMorigaonCell = row.querySelector('.snoMorigaon');
            if (snoMorigaonCell) {
                snoMorigaonCell.textContent = snoMorigaonIndex++;
            }

            const snoBarpetaCell = row.querySelector('.snoBarpeta');
            if (snoBarpetaCell) {
                snoBarpetaCell.textContent = snoBarpetaIndex++;
            }
            const snoBiswanathCell = row.querySelector('.snoBiswanath');
            if (snoBiswanathCell) {
                snoBiswanathCell.textContent = snoBiswanathIndex++;
            }
            const snoDhubriCell = row.querySelector('.snoDhubri');
            if (snoDhubriCell) {
                snoDhubriCell.textContent = snoDhubriIndex++;
            }
            const snoNagaonCell = row.querySelector('.snoNagaon');
            if (snoNagaonCell) {
                snoNagaonCell.textContent = snoNagaonIndex++;
            }
            const snoTinsukiaCell = row.querySelector('.snoTinsukia');
            if (snoTinsukiaCell) {
                snoTinsukiaCell.textContent = snoTinsukiaIndex++;
            }
            const snoDarrangCell = row.querySelector('.snoDarrang');
            if (snoDarrangCell) {
                snoDarrangCell.textContent = snoDarrangIndex++;
            }
            const snoChirangCell = row.querySelector('.snoChirang');
            if (snoChirangCell) {
                snoChirangCell.textContent = snoChirangIndex++;
            }
            const snoKarimganjCell = row.querySelector('.snoKarimganj');
            if (snoKarimganjCell) {
                snoKarimganjCell.textContent = snoKarimganjIndex++;
            }
            const snoCharaideoCell = row.querySelector('.snoCharaideo');
            if (snoCharaideoCell) {
                snoCharaideoCell.textContent = snoCharaideoIndex++;
            }


        });
    });
</script>
@endsection
