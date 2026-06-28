@extends('layouts.user-app')


@section('title', 'IIT')

@section('style')

    {{-- <link rel="stylesheet" href="{{ URL::asset('assets/template/css/actandrules.css') }}" /> --}}

    <style>
       .custom-link {
        font-weight: bold;
        color: red;
        text-decoration: none;
    }

    .custom-link:hover {
        color: blue;
    }
        section.downloadpage .box {
            margin: 0 auto;
            width: 60%;
            display: block;
            background: white;
            padding: 20px;
            box-sizing: border-box;
            box-shadow: rgba(149, 157, 165, 0.2) 0px 8px 24px;
        }

        .cardhead2 {
            cursor: pointer;
            position: relative;
            background: linear-gradient(to right, #00008b, #279ca0);
            width: 231px;
            height: 40px;
            ;
        }

        .download {
            background-color: #009cdb;
            !important;


        }


        .table-bordered tr {
            height: 60px;
            border-bottom: 1px solid #ccc;
        }

        .table-bordered tr:nth-child(even) {

            background: #f7f3f3;
        }

        .table-bordered {
            border-collapse: collapse;
            /* Collapse border spacing */
            /* border: 1.5px solid #abe4e6;    Set border color for the whole table */
        }


        .table-bordered td {
            padding: 8px;
            /* Add padding to cells */
            border: none;
            /* Remove border from cells */
        }

        .table-bordered td:first-child {
            border-left: none;
            /* Remove left border from first column */
        }

        .cardhead2 {

            cursor: pointer;
            position: relative;
            width: 300px;
        }

        .cardhead2triangle {
            position: absolute;
            top: 50%;
            right: -12px;
            /* Adjust the distance from the right edge of the card */
            width: 0;
            height: 0;
            border-left: 35px solid transparent;
            border-right: 35px solid transparent;
            border-bottom: 50px solid white;
            /* You can change color */
            transform: translateY(-50%) rotate(-90deg);
            /* Rotate the triangle and center vertically */
        }


        .card-content2 {
            color: white;
            padding: 10px;
            margin-left: 26%;
            font-size: 17px;
            font-weight: 550;
            font-family: 'Roboto', Sans-Serif;

        }
        .blinking-link {
        animation: blinking 1s infinite;
        color: red;
        font-weight: bold;
    }

    @keyframes blinking {
        0% { opacity: 1; }
        50% { opacity: 0; }
        100% { opacity: 1; }
    }
    </style>
@endsection

@section('content')






    <section class="downloadpage">
        <div class="pagination">

        </div>

        <div class="heading">
            <h2>{{ trans('iit.head') }}
               </h2>
            <div class="centerHeading"></div>
        </div>
        <div class="box">
            <ul>
                 @php $count = 0; @endphp
                @foreach ($iit as $iitpdf)
                    @php $count++; @endphp
                    <li class="d-flex flex-column flex-md-row align-items-center mb-3 p-3 shadow-sm rounded"
                        style="background: #f9f9f9;">
                        <div class="d-flex align-items-center col-md-11">
                            <div class="serial-number d-flex justify-content-center align-items-center me-3"
                                style="width: 40px; height: 40px; border-radius: 50%; background: #f0f4f8; font-weight: bold;">
                                {{ $count }}
                            </div>
                            <div class="caption" style="font-size: 16px;">
                                {{ $iitpdf->caption }}
                            </div>
                        </div>
                        <div class="col-md-1 d-flex justify-content-end mt-2 mt-md-0">
                            @if ($iitpdf->pdf_path)
                                <a href="{{ asset($iitpdf->pdf_path) }}" target="_blank">
                                    <i class="fa fa-file-pdf-o" style="color:red; font-size: 24px;"></i>
                                </a>
                            @endif
                        </div>
                    </li>
                @endforeach
                {{-- <li class="d-flex flex-column flex-md-row align-items-center">
                    <div class="col-md-10 mb-3 mb-md-0">
                        <td class="col-md-12 p-3" style="text-align: left;"
                            data-label="Eligibility criteria & documents required">AI/ML RESIDENTIAL TRAINING PROGRAMME
                        </td>
                    </div>
                    <div class="col d-flex">
                        <div class="col"></div>

                        <div class="col">
                            <a href="{{ route('download', 'AIMLIITG.pdf') }}">
                                <i class="fa fa-file-pdf-o" style="color:red; font-size: 24px;"></i>
                            </a>
                        </div>

                    </div>

                </li> --}}





                {{-- <li class="d-flex flex-column flex-md-row align-items-center">
                    <div class="col-md-10 mb-3 mb-md-0">
                        <td class="col-md-12 p-3" style="text-align: left;"
                            data-label="Eligibility criteria & documents required">
                            Letter to all Registering Officers
                        </td>
                    </div>
                    <div class="col d-flex">
                        <div class="col"></div>

                        <div class=" col ">
                            <a href="{{ route('download', 'LettersforRO.pdf') }}">
                                <i class="fa fa-file-pdf-o" style="color:red; font-size: 24px;"></i>
                            </a>
                        </div>

                    </div>
                </li> --}}



<div class="col-md-12 text-center mb-3 mb-md-0">
    <td class="col-md-3 p-3" data-label="Eligibility criteria & documents required">
        <a href="https://docs.google.com/forms/d/e/1FAIpQLSei68f0pUebJDdtzO80tRujM9M-ajgj7rD-BS77QUBWVGreug/viewform"
           class="custom-link blinking-link" style="text-decoration: none;">
            {{ trans('iit.clickhere') }}
        </a>
    </td>
</div>





            </ul>
        </div>
    </section>



@endsection

@section('footer')


@endsection
