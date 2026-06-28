@extends('layouts.user-app')

@section('title', 'Downloads')

@section('style')
    <style>
        .serial-number {
            font-size: 16px;
            background: radial-gradient(circle, #e0eafc, #cfdef3);
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

        @media(min-width:1600px) {
            section.downloadpage .box {
                width: 60%;
                display: block;
            }
        }

        section.downloadpage .box ul {
            padding: 0px;
            margin: 0px;
            list-style: none;
            counter-reset: list-counter;
        }

        section.downloadpage .box ul li {
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

        .box ul li a {
            text-decoration: none;
            color: #4c4f52;
            flex-grow: 1;
            font-weight: 400;
        }

        .box ul li button {
            background: #007bff;
            color: #fff;
            border: none;
            padding: 8px 12px;
            border-radius: 5px;
            cursor: pointer;
        }

        .box ul li button:hover {
            background: #0056b3;
        }

        section.downloadpage .box ul li:hover {
            background: #dddddd;
        }

        .cardhead2 {
            cursor: pointer;
            position: relative;
            background: linear-gradient(to right, #00008b, #279ca0);
            width: 231px;
            height: 40px;
        }

        .download {
            background-color: #009cdb !important;
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
        }

        .table-bordered td {
            padding: 8px;
            border: none;
        }

        .table-bordered td:first-child {
            border-left: none;
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
            width: 0;
            height: 0;
            border-left: 35px solid transparent;
            border-right: 35px solid transparent;
            border-bottom: 50px solid white;
            transform: translateY(-50%) rotate(-90deg);
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
    <section class="downloadpage">
        <div class="pagination">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">E-Services</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Downloads</li>
                </ol>
            </nav>
        </div>

        
        <div class="heading">
            <h2>{{ trans('ActsAndRules.head2') }}</h2>
            <div class="centerHeading"></div>
        </div>

        <div class="box">
            <ul>
                @php $count = 0; @endphp
                @foreach ($download as $downloadpdf)
                    @php $count++; @endphp
                    <li class="d-flex flex-column flex-md-row align-items-center mb-3 p-3 shadow-sm rounded"
                        style="background: #f9f9f9;">
                        <div class="d-flex align-items-center col-md-11">
                            <div class="serial-number d-flex justify-content-center align-items-center me-3"
                                style="width: 40px; height: 40px; border-radius: 50%; background: #f0f4f8; font-weight: bold;">
                                {{ $count }}
                            </div>
                            <div class="caption" style="font-size: 16px;">
                                {{ $downloadpdf->caption }}
                            </div>
                        </div>
                        <div class="col-md-1 d-flex justify-content-end mt-2 mt-md-0">
                            @if ($downloadpdf->pdf_path)
                                <a href="{{ asset($downloadpdf->pdf_path) }}" target="_blank">
                                    <i class="fa fa-file-pdf-o" style="color:red; font-size: 24px;"></i>
                                </a>
                            @endif
                        </div>
                    </li>
                @endforeach

                {{-- Static Item 1 --}}
                <li class="d-flex flex-column flex-md-row align-items-center mb-3 p-3 shadow-sm rounded"
                    style="background: #f9f9f9;">
                    <div class="d-flex align-items-center col-md-10">
                        <div class="serial-number d-flex justify-content-center align-items-center me-3"
                            style="width: 40px; height: 40px; border-radius: 50%; background: #f0f4f8; font-weight: bold;">
                            {{ ++$count }}
                        </div>
                        <div class="caption" style="font-size: 16px;">
                            {{ trans('downloads.workingrecord') }}
                        </div>
                    </div>
                    <div class="col-md-2 d-flex justify-content-end mt-2 mt-md-0">
                        <a href="{{ route('download', 'Working_record_book.docx') }}" class="me-3">
                            <i class="fa fa-file-word-o" style="color:blue; font-size: 24px;"></i>
                        </a>
                        <a href="{{ route('download', 'Working_record_book.pdf') }}">
                            <i class="fa fa-file-pdf-o" style="color:red; font-size: 24px;"></i>
                        </a>
                    </div>
                </li>

                {{-- Static Item 2 --}}
                <li class="d-flex flex-column flex-md-row align-items-center mb-3 p-3 shadow-sm rounded"
                    style="background: #f9f9f9;">
                    <div class="d-flex align-items-center col-md-10">
                        <div class="serial-number d-flex justify-content-center align-items-center me-3"
                            style="width: 40px; height: 40px; border-radius: 50%; background: #f0f4f8; font-weight: bold;">
                            {{ ++$count }}
                        </div>
                        <div class="caption" style="font-size: 16px;">
                            {{ trans('ActsAndRules.text11') }}
                        </div>
                    </div>
                    <div class="col-md-2 d-flex justify-content-end mt-2 mt-md-0">
                        <a href="{{ route('download', '90_day_BOC_WorkCertificate.docx') }}" class="me-3">
                            <i class="fa fa-file-word-o" style="color:blue; font-size: 24px;"></i>
                        </a>
                        <a href="{{ route('download', '90_day_BOC_WorkCertificate.pdf') }}">
                            <i class="fa fa-file-pdf-o" style="color:red; font-size: 24px;"></i>
                        </a>
                    </div>
                </li>
            </ul>
        </div>
    </section>
@endsection

@section('footer')
@endsection
