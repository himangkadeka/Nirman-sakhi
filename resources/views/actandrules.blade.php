@extends('layouts.user-app')



@section('title', 'Acts and Rules')

@section('style')

    {{-- <link rel="stylesheet" href="{{ URL::asset('assets/template/css/actandrules.css') }}" /> --}}
    <style>
        .cardhead1 {
            cursor: pointer;
            position: relative;
            background: linear-gradient(to right, #00008b, #279ca0);
            width: 341px;
            height: 40px;
        }

        .cardhead1triangle {
            position: absolute;
            top: 50%;
            right: -12px;
            width: 0;
            height: 0;
            border-left: 35px solid transparent;
            border-right: 35px solid transparent;
            border-bottom: 50px solid white;
            transform: translateY(-50%) rotate(-90deg);
        }


        .headbackground {
            background-color: #636465 !important;
        }


        .table thead th,
        .table tbody td {
            word-wrap: break-word;
            white-space: normal;
        }

        a:link {
            text-decoration: none;
        }

        .download {
            background-color: #1b949e !important;
        }

        .table-bordered tr:nth-child(even) {

            background: #f7f3f3;
        }

        @media (max-width: 767px) {
            .cardhead1 {
                width: 300px;
            }

            .table thead {
                display: none;

            }

            .table,
            .table tbody,
            .table tr {
                display: block;

                width: 100%;

            }

            .table td {
                display: block;

                position: relative;
                padding-left: 50%;


                text-align: left;
                border-bottom: 1px solid #ddd;

            }

            .table td:before {
                content: attr(data-label);

                position: absolute;
                top: 0;
                left: 0;
                width: 100%;


                padding: 0 10px;

                font-weight: bold;
                white-space: nowrap;
                background-color: #65c4ff;

                color: white;

                text-align: center;

                line-height: 1.5;

                box-sizing: border-box;

            }


            .table tr {
                margin-bottom: 1rem;

                background: #f9f9f9;

            }

            .download {

                margin-top: 8%;


            }

            .bodycolor {
                background-color: white !important;

            }

        }
    </style>

@endsection

@section('content')

    <div class="container-fluid ml-n3" id="b-homedb">
        <div class="heading mt-3">

            <h2>
                {{ trans('ActsAndRules.head1') }}

            </h2>
            <div class="centerHeading"></div>
        </div>

    </div>


    <div class="container  mt-3 mb-4">
        <table class="table table-sm table-bordered shadow" style=" font-family: 'Roboto', sans-serif;font-size:16px;">
            <thead class="headbackground">
                <tr>
                    <th scope="col" class="col-md-1 text-center align-middle  order-1 "
                        style="color: white; font-family: 'Roboto', sans-serif;font-size:16px;">
                        SNo.
                    </th>
                    <th scope="col" class="col-md-4 text-center align-middle order-2"
                        style="color: white; font-family: 'Roboto', sans-serif;font-size:16px;">
                        Acts/Rules/Guidelines
                    </th>
                    <th scope="col" class="col-md-5 text-center align-middle p-3 order-3" style="color: white;">
                        Details
                    </th>
                    <th scope="col" class=" col-md-2 text-center align-middle order-4" style="color: white;">
                        Download
                    </th>
                </tr>


            </thead>
            <tbody style="font-family: 'Roboto', sans-serif;">
                <tr class="">

                    <td class="col-md-1 p-3 text-center align-middle"
                        style=" font-family: 'Roboto', sans-serif;font-size:16px;" data-label=" SNo.">
                        <br> 1
                    </td>
                    <td class="text-start p-3" style=" font-family: 'Roboto', sans-serif;font-size:16px; font-weight: 550;"
                        data-label=" Acts/Rules/Guidelines">
                        <br>
                        {{ trans('ActsAndRules.text1bold') }}
                        <br><br>
                    </td>
                    <td class="col-md-2 p-3  align-middle eligibility" data-label="Details">
                        <br>{{ trans('ActsAndRules.text1') }}<br>
                    </td>
                    <td class="col-12 p-3 align-middle" data-label="Download">
                        <a href="{{ route('download', 'building_and_other_construction_workers_act_1996.pdf') }}">
                            <div class="d-flex  justify-content-center align-items-center"><button
                                    class="btn download btn-sm"> <i class="fa fa-download" style="color:white"
                                        aria-hidden="true"></i>
                                    <span style="color:white;">Download</span></button></div>
                        </a>
                    </td>




                </tr>

                <tr class="bodycolor">
                    <td class="col-md-1 p-3 text-center align-middle"
                        style=" font-family: 'Roboto', sans-serif;font-size:16px;font-weight: 600;" data-label=" SNo.">
                        <br> 2
                    </td>
                    <td class="text-start align-middle p-3" style=" font-family: 'Roboto', sans-serif;font-size:16px;"
                        data-label=" Acts/Rules/Guidelines">
                        <br> <span style="font-weight: 550;">{{ trans('ActsAndRules.text2bold') }}</span>
                    </td>
                    <td class="col-md-2 p-3  align-middle eligibility" data-label="Details">
                        <br><span>{{ trans('ActsAndRules.text2') }}</span><br>
                    </td>
                    <td class="col-12 p-3 align-middle" data-label="Downloads">
                        <a href="{{ route('download', 'the_building_other_construction_workers_assam_rules_2007.pdf') }}">
                            <div class="d-flex  justify-content-center align-items-center"><button
                                    class="btn download btn-sm"> <i class="fa fa-download" style="color:white"
                                        aria-hidden="true"></i>
                                    <span style="color:white; ">Download</span></button></div>
                        </a>
                    </td>


                </tr>

                <tr class="">
                    <td class="col-md-1 p-3 text-center align-middle"
                        style=" font-family: 'Roboto', sans-serif;font-size:16px;font-weight: 550;" data-label=" SNo.">
                        <br> 3
                    </td>
                    <td class="text-start align-middle p-3"
                        style=" font-family: 'Roboto', sans-serif;font-size:16px;font-weight: 550;"
                        data-label=" Acts/Rules/Guidelines">
                        <br>{{ trans('ActsAndRules.text3bold') }}
                    </td>
                    <td class="col-md-2 p-3 align-middle eligibility" data-label="Details">
                        <br>{{ trans('ActsAndRules.text3') }}
                        <br>
                    </td>
                    <td class="col-12 p-3 align-middle" data-label="Downloads">
                        <br>
                        <a
                            href="{{ route('download', 'Assam_Building_&_Other_Construction_Workers_(RE&CS)_Amendment_Rules,2017(Gazette_Notification).pdf') }}">
                            <div class="d-flex  justify-content-center align-items-center">
                                {{-- <i class="fa fa-file-pdf-o" aria-hidden="true"></i> --}}
                                <button class="btn download btn-sm"><i class="fa fa-download" style="color:white"
                                        aria-hidden="true"></i>
                                    <span style="color:white;">Download</span></button>
                            </div>
                        </a>
                    </td>
                </tr>

                <tr class="bodycolor">
                    <td class="col-md-1 p-3 text-center align-middle"
                        style=" font-family: 'Roboto', sans-serif;font-size:16px;font-weight: 550;" data-label=" SNo.">
                        <br> 4
                    </td>
                    <td class="text-start align-middle p-3"
                        style=" font-family: 'Roboto', sans-serif;font-size:16px;font-weight: 550;"
                        data-label=" Acts/Rules/Guidelines">
                        <br> {{ trans('ActsAndRules.text4new') }}
                    </td>
                    <td class="col-md-2 p-3 align-middle eligibility" data-label="Details">
                        <br>{{ trans('ActsAndRules.text4new2') }}
                        <br>

                    </td>
                    <td class="col-12 p-3 align-middle" data-label="Downloads">
                        <br>
                        <a
                            href="{{ route('download', 'THE_BUILDING_AND_OTHER_CONSTRUCTION_WORKERS’_WELFARE_CESS_ACT_1996.pdf') }}">
                            <div class="d-flex justify-content-center align-items-center">
                                {{-- <i class="fa fa-file-pdf-o" aria-hidden="true"></i> --}}
                                <button class="btn download btn-sm"><i class="fa fa-download" style="color:white"
                                        aria-hidden="true"></i>
                                    <span style="color:white;">Download</span></button>
                            </div>
                        </a>
                    </td>
                </tr>

                <tr class="">
                    <td class="col-md-1 p-3 text-center align-middle"
                        style=" font-family: 'Roboto', sans-serif;font-size:16px;font-weight: 550;" data-label=" SNo.">
                        <br> 5
                    </td>
                    <td class="text-start align-middle p-3"
                        style=" font-family: 'Roboto', sans-serif;font-size:16px;font-weight: 550;"
                        data-label=" Acts/Rules/Guidelines">
                        <br> {{ trans('ActsAndRules.text5bold') }}
                    </td>
                    <td class="col-md-1 p-3 align-middle eligibility" data-label="Details">
                        <br> {{ trans('ActsAndRules.text5') }}
                        <br>
                    </td>
                    <td class="col-12 p-3 align-middle" data-label="Downloads"><br>
                        <a
                            href="{{ route('download', "THE_BUILDING_&_OTHER_CONSTRUCTION_WORKERS'_WELFARE_CESS_RULES_1998.pdf") }}">
                            <div class="d-flex justify-content-center align-items-center">
                                {{-- <i class="fa fa-file-pdf-o" aria-hidden="true"></i> --}}
                                <button class="btn download btn-sm"><i class="fa fa-download" style="color:white"
                                        aria-hidden="true"></i>
                                    <span style="color:white;">Download</span></button>
                            </div>
                        </a>

                    </td>
                </tr>
                <tr class="">
                    <td class="col-md-1 p-3 text-center align-middle"
                        style="font-family:'Roboto',Sans-Serif;font-weight: 600;" data-label=" SNo."><br>
                        6
                    </td>
                    <td class="text-start p-3" style=" font-family: 'Roboto', sans-serif;font-size:16px;font-weight: 550;"
                        data-label=" Acts/Rules/Guidelines"><br>
                        {{ trans('ActsAndRules.text0') }}
                    </td>
                    <td class="col-md-2 px-3 align-middle eligibility" data-label="Details"><br>

                        <br>
                    </td>

                    <td class="col-12 p-3 align-middle" data-label="Downloads"><br>
                        <a href="{{ route('download', 'itbill2000.pdf') }}">
                            <div class="d-flex  justify-content-center align-items-center">
                                <button class="btn download btn-sm"> <i class="fa fa-download" style="color:white"
                                        aria-hidden="true"></i>
                                    <span style="color:white;">Download</span></button>
                            </div>
                        </a>

                    </td>

                </tr>

                <tr class="bodycolor">
                    <td class="col-md-1 p-3 text-center align-middle"
                        style=" font-family: 'Roboto', sans-serif;font-size:16px;font-weight: 550;" data-label=" SNo.">
                        <br>
                        7
                    </td>
                    <td class="text-start align-middle p-3"
                        style=" font-family: 'Roboto', sans-serif;font-size:16px;font-weight: 550;"
                        data-label=" Acts/Rules/Guidelines">
                        <br>
                        {{ trans('ActsAndRules.text6') }}
                    </td>
                    <td class="col-md-2 p-3 align-middle eligibility" data-label="Details">
                        <br>
                        <br>


                    </td>
                    <td class="col-12 p-3 align-middle" data-label="Downloads">

                        <br>
                        <a href="{{ route('download', 'it_amendment_act2008.pdf') }}" class="">
                            <div class="d-flex justify-content-center align-items-center">

                                <button class="btn download btn-sm"><i class="fa fa-download" style="color:white"
                                        aria-hidden="true"></i>
                                    <span style="color:white;">Download</span></button>
                            </div>
                        </a>

                    </td>
                </tr>
                <tr class="">
                    <td class="col-md-1 p-3 text-center align-middle"
                        style=" font-family: 'Roboto', sans-serif;font-size:16px;font-weight: 550;" data-label=" SNo.">
                        <br> 8
                    </td>
                    <td class="text-start align-middle p-3"
                        style=" font-family: 'Roboto', sans-serif;font-size:16px;font-weight: 550;"
                        data-label=" Acts/Rules/Guidelines">
                        <br> {{ trans('ActsAndRules.text7') }}
                    </td>
                    <td class="col-md-2 p-3 align-middle eligibility" data-label="Details">
                        <br>
                        {{ trans('ActsAndRules.text8') }}
                        <br>

                    </td>
                    <td class="col-12 p-3 align-middle" data-label="Downloads"><br>
                        <a href="{{ route('download', 'Aadhaar_Act_2016_as_amended.pdf') }}" class=""
                            style="text-decoration: none;">
                            <div class="d-flex justify-content-center align-items-center">

                                <button class="btn download btn-sm"><i class="fa fa-download" style="color:white"
                                        aria-hidden="true"></i>
                                    <span style="color:white;">Download</span></button>
                            </div>
                        </a>









                    </td>
                </tr>

                {{-- <tr class="bodycolor">
                    <td class="col-md-1 p-3 text-center align-middle"
                        style=" font-family: 'Roboto', sans-serif;font-size:16px;font-weight: 550;"
                        data-label=" SNo."><br>
                        8
                    </td>
                    <td class="text-start align-middle p-3"
                        style=" font-family: 'Roboto', sans-serif;font-size:16px;font-weight: 550;"
                        data-label=" Acts/Rules/Guidelines"><br>
                        {{ trans('ActsAndRules.text10') }}
                    </td>
                    <td class="col-md-2 px-3 align-middle eligibility"
                        data-label="Details"> <br>

                        <br>

                    </td>
                    <td class="col-12 p-3 align-middle" data-label="Downloads"><br>
                        <a href="{{ route('download', 'Issued_addendum_on_01_12_2023.pdf') }}" class="downloadLink">
                            <div class="d-flex  justify-content-center align-items-center">

                                <button class="btn download btn-sm"><i class="fa fa-download" style="color:white"
                                        aria-hidden="true"></i>
                                    <span style="color:white;">Download</span></button>
                            </div>
                        </a>










                    </td>
                </tr> --}}



            </tbody>
        </table>
    </div>
@endsection

@section('footer')
    <script>
        // Select all elements with the class 'downloadLink'
        const downloadLinks = document.querySelectorAll('.downloadLink');

        // Add a click event listener to each link
        downloadLinks.forEach(link => {
            link.addEventListener('click', function(event) {
                event.preventDefault(); // Prevent the default link behavior
                alert('File not found');
            });
        });
    </script>

@endsection
