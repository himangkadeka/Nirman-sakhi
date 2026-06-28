@extends('layouts.user-app')


@section('title', 'Downloads')

@section('style')

    {{-- <link rel="stylesheet" href="{{ URL::asset('assets/template/css/actandrules.css') }}" /> --}}

    <style>
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
    </style>
@endsection

@section('content')






    <section class="downloadpage" style="background:white">
        <div class="pagination">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">E-Services</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Helpdesk</li>
                </ol>
            </nav>
        </div>

        <div class="heading">
            <h2>{{ trans('helpdesk.Helpdesk') }}</h2>
            <div class="centerHeading"></div>
        </div>
        <img src="{{ asset('assets/template/images/helpdesk.gif') }}" id="helpimg">
        <div class="box helpdesk">
            <ul>
                <span class="d-flex flex-column flex-md-row align-items-center">
                    <div class="col-md-12 mb-3 mb-md-0">
                        <h5 class="col-md-12" style="text-align: left;"
                            data-label="Eligibility criteria & documents required">{{ trans('helpdesk.ourhelpdesk') }}
                        </h5> {!! __('helpdesk.helpdeskpara') !!}

                       <p>{{ trans('helpdesk.helpdeskpara2') }}  <a href="#" data-toggle="modal"
                                data-target="#grievance-modal" class="text-primary">{{ trans('helpdesk.here') }}</a> {{ trans('helpdesk.helpdeskpara22') }}</p>
                        <div class="container" style="font-weight:600; ">
                            <div class="row align-items-center">
                                <div class="col-12 col-md-auto">
                                    Email to:
                                </div>
                                <div class="col-12 col-md-auto ml-1">
                                    <span class="text-break"> abocww.board@assam.gov.in </span>
                                </div>
                            </div>
                        </div>

                    </div>


                </span>




                {{-- <li>
                    <td class="col-md-12 p-3 align-middle " data-label="">REGISTERING OFICER MANUAL</td>
                    <a href="{{ route('download', 'RO_Manual.pdf') }}" target="_blank"><div class="d-flex justify-content-end"><button class="btn-download btn-sm"><i class="fa fa-download" style="color:white" aria-hidden="true"></i>
                    <span style="color:white;">Download</span></button></div></a>

                </li>
                <li>
                    <td class="col-md-12 p-3 align-middle " data-label="">DEALING ASSISTANT MANUAL</td>
                    <a href="{{ route('download', 'DA_Manual.pdf') }}" target="_blank"><div class="d-flex justify-content-end"><button class="btn-download btn-sm"><i class="fa fa-download" style="color:white" aria-hidden="true"></i>
                    <span style="color:white;">Download</span></button></div></a>

                </li> --}}
            </ul>
        </div>
    </section>



@endsection

@section('footer')


@endsection
