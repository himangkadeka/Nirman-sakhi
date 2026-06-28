@extends('layouts.user-app')


@section('title', 'Home')

@section('style')
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/template/css/slick.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/template/css/slick-theme.css') }}">
    <style>
        .lctext {
            width: 250px;
        }

        .sticky-section {
            position: sticky;
            top: 10px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 20px;
            /* box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1); */
            overflow: hidden;
            margin-top: 20px;
        }

        .sidebar {
            background: transparent;
        }

        .minister {
            /* background: rgba(255, 255, 255, 0.95); */
            border-radius: 15px;
            /* box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1); */
            /* backdrop-filter: blur(10px); */
        }

        .ministerBox {
            background: linear-gradient(45deg, #f8f9ff, #e8f4fd);
            border-radius: 15px;
            padding: 20px;
            margin-bottom: 20px;
            border-left: 4px solid #667eea;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .ministerBox:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 30px rgba(102, 126, 234, 0.2);
            border-left-color: #764ba2;
        }

        .ministerBox::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(45deg, rgba(102, 126, 234, 0.05), rgba(118, 75, 162, 0.05));
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .ministerBox:hover::before {
            opacity: 1;
        }

        .ministerBox img {
            border: 3px solid #fff;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
            transition: all 0.3s ease;
        }

        .ministerBox:hover img {
            transform: scale(1.05);
            box-shadow: 0 12px 25px rgba(102, 126, 234, 0.3);
        }

        .ministerText {
            position: relative;
            z-index: 2;
        }

        .ministerText span:first-child {
            color: #2c3e50;
            font-weight: 600;
            font-size: 16px;
            margin-bottom: 5px;
            display: block;
        }

        .ministerText span:last-child {
            color: #667eea;
            font-weight: 500;
            font-size: 14px;
        }

        .sticky-section-content {
            background: rgba(255, 255, 255, 0.95);
            margin: 20px;
            border-radius: 15px;
            backdrop-filter: blur(10px);
        }

        .content-card {
            background: linear-gradient(135deg, #fff 0%, #f8f9ff 100%);
            border: 1px solid rgba(102, 126, 234, 0.1);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.08);
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .content-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 4px;
            background: linear-gradient(90deg, #667eea, #764ba2);
        }

        .content-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 35px rgba(102, 126, 234, 0.15);
        }

        .content-card h4 {
            color: #2c3e50 !important;
            font-family: 'Poppins', Sans-Serif !important;
            font-size: 18px !important;
            font-weight: 600 !important;
            margin-bottom: 20px;
            position: relative;
            padding-left: 15px;
        }

        .content-card h4::before {
            content: '';
            position: absolute;
            left: 0;
            top: 50%;
            transform: translateY(-50%);
            width: 4px;
            height: 20px;
            background: linear-gradient(135deg, #667eea, #764ba2);
            border-radius: 2px;
        }

        .content-card .form-control {
            border: 2px solid #e8f4fd;
            border-radius: 10px;
            padding: 12px 15px;
            transition: all 0.3s ease;
            background: rgba(248, 249, 255, 0.5);
        }

        .content-card .form-control:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
            background: #fff;
        }

        .content-card .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            border-radius: 10px;
            padding: 12px 25px;
            font-weight: 600;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
        }

        .content-card .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(102, 126, 234, 0.4);
        }

        .marquee-container {
            background: rgba(248, 249, 255, 0.7);
            border-radius: 10px;
            padding: 15px;
            border: 1px solid rgba(102, 126, 234, 0.1);
        }

        .marquee-content a {
            color: #667eea;
            text-decoration: none;
            font-weight: 500;
            transition: color 0.3s ease;
            display: flex;
            align-items: center;
            padding: 8px 0;
        }

        .marquee-content a:hover {
            color: #764ba2;
        }

        .marquee-content a i {
            margin-right: 8px;
            color: #667eea;
        }

        .reveal {
            opacity: 0;
            transform: translateY(50px);
            transition: opacity 1s ease, transform 1s ease;
        }

        .reveal.active {
            opacity: 1;
            transform: translateY(0);
        }

        .disabled-link {
            pointer-events: none;
            opacity: 0.6;
            cursor: not-allowed;
        }



        .card {
            min-width: 235px;
            border-radius: 60px;
            border: 1px solid #0f4547;
        }

        .card-body {
            padding: 20px 16px;
            cursor: pointer;
        }

        .circle-bg {
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 45px;
            width: 45px;
            margin-right: 8px;
        }

        .card-content {
            display: flex;
            flex-direction: row;
            align-items: center;
            width: 100%;

        }

        .card-title {
            color: #0f4547;
            font-size: 0.9rem;
            font-weight: bold;
            margin-bottom: 0.5rem;

        }

        .card-subtitle {
            color: #6c757d;
            font-size: 13px;
            font-weight: 500;
            color: #008fc8;
        }

        .card-flex {
            display: flex;
            /* min-width: 225px; */

        }

        .pad1 {
            width: 600px;
        }

        .responsive-card {
            margin-left: 40px;
            margin-right: 40px
        }

        @media (min-width: 768px) {
            .responsive-card {
                margin-left: 0px;
                margin-right: 0px
            }


        }

        @media(max-width: 767.99px) {
            .tab-content {
                padding-top: 10%;
            }
        }


        @media (min-width: 768px) and (max-width: 991.98px) {

            /* Ensure modal-dialog takes full width */
            .modal-dialog {


                display: flex;
                justify-content: center;
                align-items: center;
                width: 100vh;
                /* Full viewport height */
            }



            .modal-header {}

            .modal-body {}

            /* Modify the row and column layout for smaller screens */
            .modal-body .row {
                flex-direction: column;
            }





            .modal-body .d-md-flex {
                /* Stack the columns vertically on small screens */



            }

            .modal-body .form-group {}

            .modal-body .get_button {}

            .modal-body .btn {}

            /* Optional: Adjust modal header button for smaller screens */
            .modal-header .close {}
        }

        @media(min-width:320px) {
            .accordion {
                width: 100%;
            }
        }

        @media (min-width: 1440px) and (max-width: 2559.98px) {
            .content {

                margin: auto;
                /* Center horizontally and vertically */

                display: flex;
                /* Flexbox for vertical alignment */
                flex-direction: column;
                justify-content: center;
                /* Aligns vertically in the center */
                height: 100%;
                /* Full viewport height */
            }
        }

        @media (min-width: 2560px) {
            .content {

                margin: auto;
                /* Center horizontally and vertically */

                display: flex;
                /* Flexbox for vertical alignment */
                flex-direction: column;
                justify-content: center;
                /* Aligns vertically in the center */
                height: 100%;
                /* Full viewport height */
            }
        }



        label.bold {

            color: #115f62;

        }

        .card-body {
            text-decoration: none !important;
            color: inherit;
            /* Keeps text color unchanged */
        }
    </style>


@endsection

@section('content')
    <div class="modal fade" id="languageModal" tabindex="-1" aria-labelledby="languageModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="languageModalLabel">Select Your Language</h5>
                    <button type="button" class="close position-absolute" style="right: 15px; top: 20px;"
                        data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <p class="text-muted">Choose your preferred language for the website</p>
                    <p class="text-muted">ৱেবছাইটৰ বাবে আপোনাৰ সুবিধাৰ ভাষা বাছক </p>
                    <ul class="list-unstyled ml-4">
                        @foreach (LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
                            <li class="mb-3">
                                <label class="form-check-label d-flex align-items-center">
                                    <input type="radio" name="language" class="form-check-input me-3 styled-radio"
                                        onclick="selectLanguage('{{ LaravelLocalization::getLocalizedURL($localeCode, null, [], true) }}')"
                                        @if (app()->getLocale() === $localeCode) checked @endif>
                                    <span class="language-option fw-bold">{{ $properties['native'] }}</span>
                                </label>
                            </li>
                        @endforeach
                        <span style="color: #0073ec;">(Default translation done by google translate)</span>
                    </ul>
                </div>



                <div class="modal-footer">

                    <a href="#" class="btn btn-primary   close-language-modal" data-dismiss="modal"
                        data-toggle="modal" data-target="#attentionindex-modal">
                        Close
                    </a>



                </div>
            </div>
        </div>
    </div>
    <div id="carouselExampleControls" class="carousel slide" data-ride="carousel">

        <div class="carousel-inner" id="b-homedb">
            <div class="carousel-item active">
                <img class="d-block w-100 " src="{{ URL::asset('assets/template/images/banner/banner4new.jpg') }}"
                    alt="First slide">
            </div>
            <div class="carousel-item ">
                <img class="d-block w-100" src="{{ URL::asset('assets/template/images/banner/banner2new.jpg') }}"
                    alt="Second slide">
            </div>
            <div class="carousel-item ">
                <img class="d-block w-100 " src="{{ URL::asset('assets/template/images/banner/banner1new.jpg') }}"
                    alt="Third slide">
            </div>
            <div class="carousel-item ">
                <img class="d-block w-100" src="{{ URL::asset('assets/template/images/banner/banner3new.jpg') }}"
                    alt="Forth slide">
            </div>
        </div>
        <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
        </a>
    </div>










    <div class="container-fluid banner-card">
        <div>
            @php
                $cards = [
                    [
                        'image' => asset('assets/template/images/index/registration.png'),
                        'title' => __('index.constructionworker'),
                        'subtitle' => __('index.newregistration'),
                        'modal' => '#initiating-modal',

                        'circle-bg-color' => '#ffad16',
                    ],
                    [
                        'image' => asset('assets/template/images/index/registration.png'),
                        'title' => __('index.constructionworker'),
                        'subtitle' => __('index.oldregistration'),
                        'modal' => route('home.onboarding-criteria'),
                        'circle-bg-color' => '#009cdb',
                    ],

                    [
                        'image' => asset('assets/template/images/index/applyonline.png'),
                        'title' => __('index.constructionworker'),
                        'subtitle' => __('index.applyonlineforclaim'),
                        'modal' => '#claim-modal',
                        'circle-bg-color' => '#009cdb',
                    ],

                    [
                        'image' => asset('assets/template/images/index/CESS.png'),
                        'title' => __('index.CESSpayee/Collector'),
                        'subtitle' => __('index.LogintoProceedRegistration'),
                        'modal' => '#cess-modal',
                        'circle-bg-color' => '#ffad16',
                    ],
                ];
            @endphp

            <div class="">
                <div class="card-container reveal">
                    @foreach ($cards as $index => $card)
                        <div class="card-flex mobile">
                            <div class="card border-0 shadow-lg text-center h-10">
                                @if (filter_var($card['modal'], FILTER_VALIDATE_URL))
                                    <a href="{{ $card['modal'] }}" class="card-body">
                                    @else
                                        <div data-toggle="modal" data-target="{{ $card['modal'] ?? '' }}" class="card-body">
                                @endif
                                <div class="card-content">
                                    <div class="circle-bg"
                                        style="background-color: {{ $card['circle-bg-color'] ?? '#f5b705' }};">
                                        <img src="{{ $card['image'] }}" alt="{{ $card['subtitle'] }}">
                                    </div>
                                    <div class="text-left">
                                        <p class="card-title">{{ $card['title'] }}</p>
                                        <p class="card-subtitle">{{ $card['subtitle'] }}</p>
                                    </div>
                                </div>
                                @if (filter_var($card['modal'], FILTER_VALIDATE_URL))
                                    </a>
                                @else
                            </div>
                    @endif
                </div>
            </div>
            @endforeach
        </div>
    </div>

    </div>
    </div>


    <style>
        @keyframes blink {
            0% {
                opacity: 1;
            }

            50% {
                opacity: 0;
            }

            100% {
                opacity: 1;
            }
        }

        @keyframes sparkle {
            0% {
                background-position: 0 0;
            }

            100% {
                background-position: 100% 100%;
            }
        }

        .blink {
            color: white;
            /* Text color */
            font-weight: bold;
            animation: blink 0.5s step-start infinite, sparkle 2s ease infinite;
            border-radius: 5px;
            position: relative;
            z-index: 1;
        }

        .blink::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;

            background-size: cover;
            z-index: -1;
            animation: sparkle 5s linear infinite;
        }

        /* Starry Background */
        @keyframes starry {
            0% {
                background-position: 0 0;
            }

            100% {
                background-position: 500px 500px;
            }
        }

        .marquee {
            padding: 3px 0px;
            margin-top: 25px;
        }


        .marquee img {
            width: 60px;
            transform: rotate(0deg)
        }

        #notification {
            display: flex;
            flex-direction: column;
            gap: 10px;
            height: 230px;
            overflow: hidden;
        }

        #notification .table td,
        .table th {
            border-bottom: 1px solid #222 !important
        }

        #notification .table td,
        .table td {
            padding: 0px;
        }

        #notification a {
            width: 100%;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding-bottom: 5px;
            color: red;
            text-decoration: none;
            margin-bottom: 6px;
        }

        #notification a:hover {
            color: black;
        }

        .tender a {
            color: red;
            text-decoration: none;
        }

        #notification a span {
            width: 85%
        }

        #notification a img {
            width: 40px;
        }

        .benefit-card {
            background: linear-gradient(135deg, #f8f9ff 0%, #f9faff 100%);
            border-radius: 12px;
            display: flex;
            align-items: center;
            padding: 12px;
            gap: 5px;
            box-shadow: 0 2px 8px rgba(102, 126, 234, 0.08);
            transition: box-shadow 0.2s;
        }

        .benefits-title {
            font-weight: 700;
            letter-spacing: 1px;
        }

        .bord-benits h2 {
            font-size: 25px;
            text-transform: uppercase;
            margin-top: 0px;
        }

        .benifit-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(230px, 1fr));
            gap: 16px;
        }

        .benefits-section {
            border-radius: 18px;
            box-shadow: 0 4px 24px rgba(102, 126, 234, 0.07);
            padding: 32px 24px;
            margin-top: 32px;
            width: 97.5%;
        }
        .benefit-icon{display: flex; align-items: center; justify-content: center;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 50%; width: 44px; height: 44px; margin-right: 16px;
        }
        .modal-header.attention{background:red}
    </style>
    @if ($contents->isNotEmpty() || $index_notifications->isNotEmpty())
        <marquee class="marquee mt-5" scrollamout="6" onmouseover="this.stop()" onmouseout="this.start()"
            style="background:#f0f0f0;padding: 5px 0px;">
            <a href="http://127.0.0.1:8000/iit">
                <img src="http://127.0.0.1:8000/assets/template/images/index/new.gif" alt="New"
                    style="width: 50px;">Registration for the AI/ML training courses through IIT Guwahati.
            </a>
            @foreach ($contents as $content)
                <img src="{{ asset('assets/template/images/index/new.gif') }}" alt="New" style="width: 50px;">
                {{ $content->description }}
            @endforeach



            @foreach ($alerts_index as $alert_index)
                <a href="{{ asset($alert_index->pdf_path) }}" target="_blank">
                    <img src="{{ asset('assets/template/images/index/new.gif') }}" alt="New" style="width: 50px;">
                    {{ $alert_index->caption }}

                </a>
            @endforeach
        </marquee>
    @endif

    {{-- <marquee class="marquee" onmouseover="this.stop()" onmouseout="this.start()" style="">
        <div style="display: flex; color: white; font-size: 18px; align-items: center; ">
            <span class="text-danger marqueedata" style="height: 30px;">
                <strong>Note:</strong> Aadhaar services are currently unavailable.</span> --}}
    {{-- <span class="text-danger marqueedata" style="height: 20px;"> --}}
    {{-- <strong>Note:</strong> Copies of only original documents shall be allowed for scanning
                                    and uploading. --}}
    {{-- <span class="blink text-warning">New! </span> --}}
    {{-- <img src="{{ asset('assets/template/images/index/new.gif') }}" alt="Image 1">

                <a href="{{ route('home.iit') }}">
                    Click here for Online Registration for Artificial Intelligence(AI)/Machine Learning(ML) training through
                    IIT Guwahati.
                </a> --}}

    {{-- </span> --}}


    {{--
        </div>
    </marquee> --}}

    <div class="my-container mt-5">
        <div class="d-flex flex-md-row flex-column justify-content-center">
            <div class="row">
                <div class="col-md-8">
                    <div class="welcome">
                        <div class="welcomeImage " style="padding:20px;float:left;min-width: 200px;">

                            {{-- <img src="{{ asset('assets/template/images/index/Welcome-image.png') }}" alt="Photography"> --}}
                            <div class="content">
                                <h2 class="welcomeHeading">{{ trans('index.welcometo') }}</h2>

                                <h4 class="welcomeSubHeading">
                                    {{ trans('index.abocwwb') }} </h4>

                                <p>
                                    {{ trans('index.assam_board_info') }}</p>
                                <p>
                                    {{ trans('index.assam_board_info2') }}
                                </p>
                                <p>{{ trans('index.assam_board_info3') }}</p>
                            </div>
                        </div>

                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div>
                                @php
                                    $rules = [
                                        [
                                            'title' => 'Rule 3',
                                            'content' => trans('index.sop3head'),
                                            'color' => 'text-success',
                                            'bg_color' => '#0cb0aa',
                                            'hidden_text' => [
                                                trans('index.sop3body1') .
                                                ' <a href="https://www.abocwwb.assam.gov.in" class="text-primary">(www.abocwwb.assam.gov.in)</a>.' .
                                                trans('index.sop3body2'),
                                            ],
                                            'read_more_link' => route('home.sop3'),
                                        ],
                                        [
                                            'title' => 'Rule 1',
                                            'content' => trans('index.sop1head'),
                                            'color' => 'text-info',
                                            'bg_color' => '#20c3c9;',
                                            'hidden_text' => [
                                                // Add any hidden text content here
                                            ],
                                            'buttons' => [
                                                [
                                                    'label' => trans('index.oldregistration'), // Label of the first button
                                                    'action' => route('home.sop1'), // Action for the first button (this is a route)
                                                    'style' => 'btn-primary', // Button style (e.g., btn-primary, btn-secondary, etc.)
                                                ],
                                                [
                                                    'label' => trans('index.Renewal'), // Label of the second button
                                                    'action' => route('home.sop2'), // Action for the second button (this is a route)
                                                    'style' => 'btn-primary', // Button style (e.g., btn-primary, btn-secondary, etc.)
                                                ],
                                            ],
                                        ],
                                    ];
                                @endphp

                                <div class="row px-4">
                                    <div class="col-md-12 ">
                                        <h3 class="mt-4 mb-4 font-weight-500" id="guideline">
                                            {{ trans('index.guidelines') }}
                                            <div class="underline"></div>
                                        </h3>

                                        @foreach ($rules as $key => $rule)
                                            <div class="col-md-12 mt-2" id="accordionExample">
                                                <div class="mb-3 reveal active" id="firstreveal">
                                                    <div class="card-header d-flex align-items-center"
                                                        id="heading{{ (int) $key + 1 }}">

                                                        <div class="w-100 d-flex align-items-center"
                                                            onclick="toggleText({{ (int) $key + 1 }})"
                                                            style="cursor: pointer;" data-toggle="collapse"
                                                            data-target="#collapse{{ (int) $key + 1 }}"
                                                            aria-expanded="{{ $key == 0 ? 'true' : 'false' }}"
                                                            aria-controls="collapse{{ (int) $key + 1 }}">
                                                            <div class="flex-grow-1"
                                                                style="font-weight:400; font-family:'Roboto',Sans-Serif">
                                                                {{ $rule['content'] }}
                                                            </div>
                                                            <div
                                                                class="col-1 d-flex justify-content-end align-items-center">
                                                                <div class="rounded-circle d-flex justify-content-center align-items-center"
                                                                    style="height: 50px; width: 50px; background-color:{{ $rule['bg_color'] }}; border-radius: 50%;">
                                                                    <div id="iconCollapse{{ (int) $key + 1 }}"
                                                                        class="text-white " style="font-weight: 600;">
                                                                        {{ $key == 0 ? '↑' : '↓' }}
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                    </div>

                                                    <div id="collapse{{ (int) $key + 1 }}"
                                                        class="collapse{{ $key == 0 ? ' show' : '' }}"
                                                        aria-labelledby="heading{{ (int) $key + 1 }}"
                                                        data-parent="#accordionExample">
                                                        <div class="card-body" style="font-family:'Roboto',Sans-Serif">
                                                            @foreach ($rule['hidden_text'] as $text)
                                                                <div class="tab-content">
                                                                    {!! $text !!}
                                                                    @if (isset($rule['read_more_link']))
                                                                        <span class="tabsbtn"
                                                                            onclick="window.location='{{ $rule['read_more_link'] }}'">{{ trans('index.readmore') }}<i
                                                                                class="fa fa-angle-double-right"></i></span>
                                                                    @endif
                                                                </div>
                                                            @endforeach
                                                            @if (isset($rule['buttons']))
                                                                <div class="mt-3">
                                                                    @foreach ($rule['buttons'] as $button)
                                                                        <a href="{{ $button['action'] }}"
                                                                            class="btn {{ $button['style'] }}">
                                                                            {{ $button['label'] }}
                                                                        </a>
                                                                    @endforeach
                                                                </div>
                                                            @endif
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>


                            </div>
                        </div>
                    </div>

                    <div class="row bord-benits px-4 benefits-section">
                        <div class="col-12">
                            <h2 class="benefits-title mb-2">
                                Benefits provided by the Board
                            </h2>
                            <p style="color: #444; font-size: 1.07rem; margin-bottom: 28px;">
                                Assam BOCW Board is currently administering around 13 different welfare schemes of which 12
                                schemes are ongoing and 1 scheme has been provided one-time as mentioned in the Section 22
                                (a) to 22(h) of the BOCW (RE&amp;CS) Act.
                            </p>
                            <div class="row benifit-grid">
                                @php
                                    $benefits = [
                                        ['icon' => 'fa-heartbeat', 'text' => 'Death Benefit'],
                                        ['icon' => 'fa-leaf', 'text' => 'Funeral Assistance'],
                                        ['icon' => 'fa-universal-access', 'text' => 'General Pension'],
                                        ['icon' => 'fa-users', 'text' => 'Family Pension'],
                                        ['icon' => 'fa-wheelchair-alt', 'text' => 'Disability Pension'],
                                        ['icon' => 'fa-home', 'text' => 'Transit Shelter'],
                                        ['icon' => 'fa-trophy', 'text' => 'Cash Award'],
                                        // ['icon' => 'fa-graduation-cap', 'text' => 'One Time Educational Assistance'],
                                        ['icon' => 'fa-medkit', 'text' => 'Medical Assistance'],
                                        ['icon' => 'fa-female', 'text' => 'Maternity Assistance'],
                                        ['icon' => 'fa-cogs', 'text' => 'Skill Development Training'],
                                        ['icon' => 'fa-diamond', 'text' => 'Marriage Assistance'],
                                    ];
                                @endphp
                                @foreach ($benefits as $benefit)
                                    <div class="benefit-card">
                                        <div class="benefit-icon"
                                    >
                                            <i class="fa {{ $benefit['icon'] }} text-white"
                                                style="font-size: 1.5rem;"></i>
                                        </div>
                                        <span
                                            style="font-weight: 500; color: #115f62; font-size: 1.07rem;">{{ $benefit['text'] }}</span>
                                    </div>
                                @endforeach
                            </div>
                            <a href="about/benefits" class="btn btn-outline-primary mt-5" style="font-weight: 600;">
                                <i class="fa fa-hand-o-right" aria-hidden="true"></i> Click here to read in more details
                                about all these benefits
                            </a>
                        </div>
                    </div>


                </div>
                <div class="col-md-4 sidebar sticky-section shadow">
                    <div class="mt-0">
                        <div class="minister">
                            <div class="ministerBox">
                                <img src="{{ asset('assets/template/images/index/pic 5.png') }}" alt="Image 1">
                                <div class="ministerText">
                                    <span>{{ trans('index.cmname') }}</span>
                                    <span>{{ trans('index.cmtext') }}</span>
                                </div>
                            </div>
                            <div class="ministerBox">
                                <img src="{{ asset('assets/template/images/index/rupeshG.png') }}" alt="Image 2">
                                <div class="ministerText">
                                    <span>{{ trans('index.ministername') }}
                                    </span>
                                    <span>{{ trans('index.ministertext') }}</span>
                                </div>
                            </div>
                            <div class="ministerBox">
                                <img src="{{ asset('assets/template/images/index/lc.jpg') }}" alt="Image 3">
                                <div class="ministerText">
                                    <span>{{ trans('index.lcname') }}</span>
                                    <span>{{ trans('index.lctext') }}</span>
                                </div>
                            </div>
                            <!-- <div class="ministerBox">
                                                                                                                                                                                                                                                                <img src="../assets/template/images/AnamikaTiwari.jpg" alt="anamika-tewari">
                                                                                                                                                                                                                                                                <div class="ministerText">
                                                                                                                                                                                                                                                                    <span>{{ trans('index.lcname') }}</span>
                                                                                                                                                                                                                                                                    <span>{{ trans('index.lctext') }}</span>
                                                                                                                                                                                                                                                                </div>
                                                                                                                                                                                                                                                            </div> -->
                        </div>

                        <!-- Sticky Section -->
                        <div class="sticky-section-content mt-3">
                            <div class="content-card p-4 mb-4 rounded">
                                <h4 class="font-weight-500"
                                    style="color: black;font-family:'Poppins',Sans-Serif;font-size:18px;">
                                    {{ trans('index.TrackApplication') }}
                                </h4>
                                <p>
                                <p style="font-size: 14px;"><span
                                        style="font-weight: 600;">{{ trans('index.format') }}</span>
                                    ABOCW/123/2024/REG/00000008</p>
                                </p>

                                <form action="{{ route('home.track.application') }}" method="POST" id="track-form">
                                    @csrf
                                    <div class="form-group">
                                        <input required name="application_no" type="text" class="form-control"
                                            placeholder="{{ trans('index.TrackApplicationplaceholder') }}" />
                                    </div>
                                    <button type="submit" class="btn btn-primary mybtn">{{ trans('index.submit') }} <i
                                            class="fa fa-paper-plane"></i></button>
                                </form>
                            </div>

                            <div class="content-card p-4 mb-4 mt-4 rounded">
                                <h4 class="font-weight-500"
                                    style="color: black;font-family:'Poppins',Sans-Serif;font-size:18px;">
                                    {{ trans('index.notifications') }}
                                </h4>

                                <script>
                                    function pauseMarquee(container) {
                                        const marquee = container.querySelector('.marquee');
                                        if (marquee) {
                                            marquee.style.animationPlayState = 'paused';
                                        }
                                    }

                                    function resumeMarquee(container) {
                                        const marquee = container.querySelector('.marquee');
                                        if (marquee) {
                                            marquee.style.animationPlayState = 'running';
                                        }
                                    }
                                </script>

                                <div class="marquee-container" onmouseover="pauseMarquee(this)"
                                    onmouseout="resumeMarquee(this)">
                                    <div class="marquee-content marquee">
                                        @foreach ($index_notifications as $index_notification)
                                            <a href="{{ asset($index_notification->pdf_path) }}" target="_blank"><i
                                                    class="fa fa-circle"></i>
                                                {{ $index_notification->caption }}
                                                <img src="{{ asset('assets/template/images/index/new.gif') }}"
                                                    alt="New" style="width: 50px;">
                                            </a>
                                        @endforeach
                                    </div>
                                </div>
                            </div>


                            <div class="content-card p-4 mb-1 rounded">
                                <h4 class="font-weight-500"
                                    style="color: black;font-family:'Poppins',Sans-Serif;font-size:18px;">
                                    {{ trans('index.newsletter') }}</h4>

                                <div class="marquee-container" onmouseover="pauseMarquee(this)"
                                    onmouseout="resumeMarquee(this)">
                                    <div class="marquee-content marquee">
                                        @foreach ($index_newsletters as $index_newsletter)
                                            <a href="{{ asset($index_newsletter->pdf_path) }}" target="_blank"><i
                                                    class="fa fa-circle"></i>
                                                {{ $index_newsletter->caption }}
                                                <img src="{{ asset('assets/template/images/index/new.gif') }}"
                                                    alt="New" style="width: 50px;">
                                            </a>
                                        @endforeach
                                    </div>
                                </div>

                            </div>
                            <div class="content-card p-4 mt-4 mb-1 rounded">
                                <h4 class="font-weight-500"
                                    style="color: black;font-family:'Poppins',Sans-Serif;font-size:18px;">
                                    {{ trans('index.tender') }}</h4>

                                <div class="marquee-container" onmouseover="pauseMarquee(this)"
                                    onmouseout="resumeMarquee(this)">
                                    <div class="marquee-content marquee">
                                        @foreach ($index_tenders as $index_tender)
                                            <a href="{{ asset($index_tender->pdf_path) }}" target="_blank"><i
                                                    class="fa fa-circle"></i>
                                                {{ $index_tender->caption }}
                                                <img src="{{ asset('assets/template/images/index/new.gif') }}"
                                                    alt="New" style="width: 50px;">
                                            </a>
                                        @endforeach
                                    </div>
                                </div>

                                {{-- <marquee behavior="" direction="up" scrollamount="1" onmouseover="this.stop()"
                                    onmouseout = "this.start()">
                                    <div class="tender">
                                        <a href="https://gem.gov.in/" alt="" target="_blank">GeM
                                            Portal(click here)</a>

                                    </div>
                                    @foreach ($index_tenders as $index_tender)
                                        <table class="table">
                                            <tbody>
                                                <tr class="text-danger">
                                                    <td>
                                                        <a href="{{ asset($index_tender->pdf_path) }}" target="_blank">
                                                            {{ $index_tender->caption }}
                                                            <img src="{{ asset('assets/template/images/index/new.gif') }}"
                                                                alt="New" style="width: 50px;">
                                                        </a>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    @endforeach


                                </marquee> --}}
                            </div>





                        </div>

                        <!-- Non-Sticky Section -->
                        {{-- <div class="p-4 mb-1 rounded" style="background-color: #fce7aa;">
                            <h4 class="font-weight-500" style="color: black; font-family:'Poppins', Sans-Serif; font-size:18px;">
                                {{ trans('index.newsletter') }}
                            </h4>
                            <div class="mb-1" style="height: 2px; background-color:#219fa4"></div>
                            <marquee behavior="" direction="up" scrollamount="3" onmouseover="this.stop()" onmouseout="this.start()">
                                <ul class="pl-3">
                                    <li>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</li>
                                    <li>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</li>
                                </ul>
                            </marquee>
                        </div> --}}
                    </div>
                </div>



            </div>
        </div>
    </div>




    <section class="slick slider">
        <div>
            <img src="{{ asset('assets/template/images/carousel/data-gov.png') }}"
                onclick="window.open('https://data.gov.in/', '_blank')" />
        </div>
        <div>
            <img src="{{ asset('assets/template/images/carousel/digital-india.png') }}"
                onclick="window.open('https://digitalindia.gov.in/', '_blank')" />
        </div>
        <div>
            <img src="{{ asset('assets/template/images/carousel/eci.png') }}"
                onclick="window.open('https://eci.gov.in/', '_blank')" />
        </div>
        <div>
            <img src="{{ asset('assets/template/images/carousel/india-gov.png') }}"
                onclick="window.open('https://www.india.gov.in/', '_blank')" />
        </div>
        <div>
            <img src="{{ asset('assets/template/images/carousel/makeinindia.png') }}"
                onclick="window.open('https://www.makeinindia.com/', '_blank')" />
        </div>
        <div>
            <img src="{{ asset('assets/template/images/carousel/mygov.png') }}"
                onclick="window.open('https://www.mygov.in/', '_blank')" />
        </div>

    </section>







    @include('components.attentionindex-modal')
    <!--New Registration Modal Start-->
    @include('components.initiating')
    @include('components.registration')
    <!--New Registration modal end-->

    <!--Onboarding Registration Modal Start-->
    @include('components.registrationonboarding')

    @include('components.claim-modal')
    @include('components.cess-modal')


    <!--Onboarding Registration modal end-->

    <div class="modal fade" id="renewal-modal">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header attention">
                    <h5 class="modal-title" id="exampleModalLabel">{{ trans('index.workerrenewal') }}</h5>
                    <button type="button" class="close position-absolute" style="right: 15px; top: 8px;"
                        data-dismiss="modal">&times;</button>
                </div>
                <!-- Modal body -->
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12 col-lg-6 pr-5">
                            <div class="text-left d-block p-2">
                                <span class="" id="exampleModalLabel" style="font-color: white; font-weight:600;">
                                    {{ trans('sop2.head1') }}
                                </span>

                                <ul class="my-2">
                                    <li> {{ trans('sop2.head1point1') }}</li>
                                    <li>{{ trans('sop2.head1point2') }}</li>
                                    <li>{{ trans('sop2.head1point3') }}</li>
                                    <li>
                                        {{ trans('sop2.head1point4') }}
                                    </li>
                                </ul>

                                <span class="" id="exampleModalLabel" style="font-color: white; font-weight:600;">
                                    {{ trans('index.documents') }}</span>
                                </span>

                                <ul class="my-2">
                                    {{-- <li> {{ trans('index.documents1') }}</li> --}}
                                    <li>Updated worker's record book (as per new format) <a class="text-primary"
                                            href="{{ route('download', 'Working_record_book.pdf') }}">
                                            <button class="btn download btn-sm">
                                                <i class="fa fa-download" style="color:white" aria-hidden="true"></i>
                                                <span style="color:white;">Download</span>
                                            </button>
                                        </a></li>
                                </ul>
                                <div class="text-justify">
                                    <strong>Note:</strong> Copies of only original documents shall be allowed for scanning
                                    and uploading.
                                </div>

                            </div>

                        </div>
                        <div class="col-12 col-lg-6 d-md-flex align-items-md-center justify-content-md-center"
                            style="background-color:#eff6fb; min-height: 35vh;">



                            <!-- Tab panes -->
                            <div class="tab-content w-100">


                                <!---Worker Register ---->
                                <div class="tab-pane container active" id="workerRegister">
                                    <div id="workeruserloginmsg" class="text-danger"></div>
                                    <form id="worker-renewal-form" action="{{ route('auth.worker') }}" method="POST"
                                        style="position: relative">
                                        @csrf
                                        <div class="form-group ml-3">
                                            <div class="col-md-12">
                                                <label class="bold"
                                                    style="font-weight: 600;">{{ trans('index.idcardnum') }}</label>
                                                <div class="col-11">
                                                    <input type="text" class="form-control" id="worker_id_renew"
                                                        name="id_card" placeholder="{{ trans('index.enteridcard') }}" />
                                                    @if ($errors->has('id_card'))
                                                        <span
                                                            class="text-warning font-weight-normal">{{ $errors->first('id_card') }}</span>
                                                    @endif

                                                    <span id="otp_sent_message_renwal"></span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="d-flex justify-content-center " id="get_otp_button">
                                            <button type="submit" id="get_otp_renewal"
                                                class="get_button btn-sm btn btn-primary"><i
                                                    class="fas fa-sign-in-alt"></i>&nbspLogin through OTP</button>
                                            {{-- <button type="button">On Maintenance</button> --}}
                                            <button type="button" id="resend_otp_renewal"
                                                class="get_button btn-sm btn btn-primary" style="display: none;"><i
                                                    class="fas fa-reload"></i>&nbsp;Resend OTP</button>
                                        </div>
                                    </form>
                                    <div class="" id="otp_form_renewal" style="display: none;">
                                        <div class="form-group otp">
                                            <label for="phone_no" class="bold">Please Enter Otp</label>
                                            <div class="input-field-otp-renewal">
                                                <input type="number" id="otp_1" />
                                                <input type="number" id="otp_2" disabled />
                                                <input type="number" id="otp_3" disabled />
                                                <input type="number" id="otp_4" disabled />
                                                <input type="number" id="otp_5" disabled />
                                                <input type="number" id="otp_6" disabled />
                                            </div>

                                        </div>

                                        <div class="d-flex justify-content-center py-4">
                                            <button type="button" id="verify_otp_renewal_index"
                                                class="verify_button btn btn-primary"><i
                                                    class="fas fa-sign-in-alt"></i>&nbspVerify OTP</button>
                                        </div>
                                        <div class="d-flex justify-content-center">
                                            <p id="resend_timer_renewal"> Resend OTP in <span id="timer_renewal"
                                                    class="text-success">180 </span> Seconds</p>
                                            <button type="button" id="resend_otp"
                                                class="resend_button btn btn-outlined-primary" style="display: none;"
                                                disabled>&nbspResend OTP</button>
                                        </div>
                                        {{--                                    <div class="d-flex justify-content-center py-4"> --}}
                                        {{--                                        <button type="submit" id="renewal-btn-worker" class=" btn btn-primary"><i --}}
                                        {{--                                                class="fa fa-check" --}}
                                        {{--                                                aria-hidden="true"></i>&nbsp;{{ trans('index.finddata') }}</button> --}}
                                        {{--                                    </div> --}}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="application-modal">
            <div class="modal-dialog modal-xl modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header text-center d-block p-2 border-bottom-0">
                        <h3 class="modal-title"> {{ trans('index.TrackApplication') }} </h3>
                        <button type="button" class="close position-absolute" style="right: 15px; top: 8px;"
                            data-bs-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <div class="text-center py-4">
                            <div class="justify-content-center mt-1">
                                <div id="loader" style="display: none;">
                                    <div class="spinner-border text-primary" role="status">
                                        <span class="sr-only">Loading...</span>
                                    </div>
                                </div>
                                <div id="application-data">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>



    </div>





    <!-- Login Modal -->

    {{-- News Ticker --}}

    <!-- Bootstrap core JavaScript -->


    {{-- @if (session()->has('pfcData')) --}}
    @isset($id_cards)
        <div class="modal fade" id="id-card-list">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-body">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Id Card</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($id_cards as $id_card)
                                    <tr>
                                        <td>{{ $id_card->id_card }}</td>
                                        <td><button type="button" style="right: 15px; top: 8px;" data-bs-dismiss="modal"
                                                onclick="loginWithIdCard('{{ $id_card->id_card }}')">Login</button></td>
                                    </tr>
                                @endforeach

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    @endisset


    {{-- @endif --}}


@endsection

@section('footer')



    <!-- Bootstrap JS -->
    {{-- <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script> --}}

    @if (session()->has('pfcData'))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                var pfcdata = @json($pfcData);
                var return_url = "https://sewasetu.assam.gov.in/iservices/myapplications/list";
                if (pfcdata.service_id === '1') {
                    console.log(pfcdata.service_id);
                    var modalElement = document.getElementById('initiating-modal');
                    console.log(modalElement)
                    if (modalElement) {
                        var myModal = new bootstrap.Modal(modalElement, {
                            backdrop: 'static',
                            keyboard: false
                        });
                        myModal.show();
                    }
                    // $("#already-registered-button").addClass("disabled-link");
                    $("#phone_no").val(pfcdata.mobile);
                    $("#phone_no").attr('readonly', true);
                } else if (pfcdata.service_id === 4) {
                    // $('#onboardingregister-modal').addClass('show').show();
                    // $("#new-register-button").addClass("disabled-link");
                } else if (pfcdata.service_id === 3) {
                    @isset($id_cards)

                        $(document).ready(function() {
                            // Open the modal on page load
                            // $("#id-card-list").modal('show');
                        });
                    @endisset

                }
            });
        </script>
    @endif
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const languageModal = new bootstrap.Modal(document.getElementById('languageModal'));

            languageModal.show();

        });

        function selectLanguage(url) {

            window.location.href = url;
        }
    </script>
    <script>
        $(document).ready(function() {
            $('#track-form').submit(function(event) {
                event.preventDefault();
                var form = $(this);
                $('#loader').show();
                $('#application-data').empty();

                $.ajax({
                        type: form.attr('method'),
                        url: form.attr('action'),
                        data: form.serialize()
                    })
                    .done(function(response) {
                        $('#loader').hide();

                        if (!response.length) {
                            toastr.error(
                                'Application Not Found. Please enter Acknowledgement Number correctly'
                            );
                            return;
                        }

                        console.log(response);

                        var ackNo = $('input[name="application_no"]').val();
                        var worker_id = response[0].worker_id;
                        var already_reg_status = response[0].already_registered;

                        console.log(already_reg_status);

                        var html = `
                <table class="table table-bordered" style="width:100%; text-align:left; font-size: 15px;">
                    <tr>
                        <th style="padding: 10px; background:#f8f9fa;">Date</th>
                        <th style="padding: 8px; background:#f8f9fa;">Status</th>
                        <th style="padding: 8px; background:#f8f9fa;">Location</th>
                        <th style="padding: 8px; background:#f8f9fa;">Remarks</th>
                        <th style="padding: 8px; background:#f8f9fa;">Reason</th>
                    </tr>`;

                        response.forEach(function(application, index) {
                            var date = new Date(application.created_at);
                            var formattedDate = pad(date.getDate(), 2) + '-' + pad(date
                                .getMonth() + 1, 2) + '-' + date.getFullYear();
                            var statusBadge = getStatusBadge(application.application_status);
                            var statusText = getStatusText(application.application_status);
                            var reasonDescription = application.reasons_details?.length ?
                                `<ul style="margin: 0; padding-left: 15px;">${application.reasons_details.map(r => `<li>${r.reason}</li>`).join('')}</ul>` :
                                'No Reason Provided';

                            var remarks = (['G', 'D'].includes(application
                                    .application_status) && application.remarks) ?
                                application.remarks :
                                'NA';

                            html += `
                    <tr>
                        <td style="padding: 10px;">${formattedDate}</td>
                        <td style="padding: 10px;">${statusBadge}</td>
                        <td style="padding: 10px;">${statusText}</td>
                        <td style="padding: 10px;">${remarks}</td>
                        <td style="padding: 10px;">${reasonDescription}</td>
                    </tr>`;
                        });

                        html += '</table>';

                        // Check for latest application status
                        var latestApplication = response[response.length - 1];
                        var latestStatus = latestApplication.application_status;

                        // Check for approved application (status 'F')
                        var approvedApplication = response.find(app => app.application_status === "F");
                        var idCardNumber = approvedApplication ? approvedApplication.idCardNumber :
                            null;

                        html += `
            <div style="text-align: center; margin-top: 15px;">
                <div style="display: flex; justify-content: center; gap: 10px;">
                    <button class="btn btn-info btn-sm" onclick="downloadReceipt('${ackNo}')">
                        <i class="fa fa-download"></i> Download Acknowledgement Receipt
                    </button>
                    ${latestStatus === "G" ? `
                                                                                                                                <button class="btn btn-danger btn-sm" onclick="reApply('${worker_id}', ${already_reg_status})">
                                                                                                                                    <i class="fa fa-refresh"></i> Re-Submit
                                                                                                                                </button>
                                                                                                                            ` : latestStatus === "D" ? `
                                                                                                                                <button class="btn btn-warning btn-sm" onclick="reReg()">
                                                                                                                                    <i class="fa fa-check"></i> Re Apply
                                                                                                                                </button>
                                                                                                                            ` : ''}
                    ${idCardNumber ? `
                                                                                                                                <button class="btn btn-danger btn-sm" onclick="downloadIdCard('${idCardNumber}')">
                                                                                                                                    <i class="fa fa-file-pdf-o" aria-hidden="true"></i> Download Id Card
                                                                                                                                </button>
                                                                                                                            ` : ''}
                </div>
            </div>`;

                        Swal.fire({
                            title: 'Application Details',
                            html: html,
                            width: '80%',
                            confirmButtonText: 'Close',
                            customClass: {
                                popup: 'swal-wide'
                            }
                        });
                    })
                    .fail(function(xhr, status, error) {
                        console.error("AJAX Error:", error, xhr.responseText);
                        $('#loader').hide();

                        let errorMessage = "Something went wrong. Please try again.";

                        if (xhr.status === 404) {
                            errorMessage =
                                "Application Not Found. Please check your Acknowledgement Number.";
                        } else if (xhr.status === 500) {
                            errorMessage = "Server error! Please try again later.";
                        } else if (xhr.responseText) {
                            errorMessage = xhr.responseText; // Show backend error message
                        }

                        toastr.error(errorMessage);
                    });

            });
        });

        // Utility functions
        function pad(num, size) {
            return num.toString().padStart(size, '0');
        }

        function getStatusBadge(status) {
            const statusMap = {
                'A': {
                    text: 'Submitted',
                    class: 'success'
                },
                'O': {
                    text: 'Forwarded',
                    class: 'success'
                },
                'G': {
                    text: 'Reverted Back',
                    class: 'warning'
                },
                'B': {
                    text: 'Returned',
                    class: 'success'
                },
                'M': {
                    text: 'Re-Routed',
                    class: 'primary'
                },
                'C': {
                    text: 'Forwarded',
                    class: 'success'
                },
                'F': {
                    text: 'Approved',
                    class: 'success'
                },
                'D': {
                    text: 'Rejected',
                    class: 'danger'
                }
            };

            return `<span class="badge badge-${statusMap[status]?.class || 'secondary'}">
                ${statusMap[status]?.text || 'Unknown'}
            </span>`;
        }

        function getStatusText(status) {
            const statusTexts = {
                'A': 'Head & Registering Officer',
                'G': 'Reverted',
                'B': 'Head & Registering Officer',
                'M': 'Head Office',
                'C': 'Dealing Assistant',
                'F': 'Approved',
                'E': 'Pulled Back From Dealing Assistant',
                'H': 'Pulled Back From Registering Officer',
                'D': 'Rejected',
                'O': 'Registering Officer'
            };
            return statusTexts[status] || 'Unknown Status';
        }

        // Download functions
        function downloadReceipt(ackNo) {
            window.open("/download-acknowledgement-receipt?ack_no=" + ackNo, "_blank");
        }

        function downloadIdCard(idCardNumber) {
            Swal.close();
            $('#id_card').val(idCardNumber).attr('readonly', true);
            setTimeout(() => new bootstrap.Modal(document.getElementById("login-modal")).show(), 300);
        }

        // Re-Apply & Re-Register Functions
        function reReg() {
            Swal.close();
            $('#initiating-modal').modal('show');
        }

        function reApply(worker_id, already_reg_status) {
            Swal.fire({
                title: "Generate OTP",
                text: "Do you want to generate an OTP for re-submission?",
                icon: "question",
                showCancelButton: true,
                confirmButtonText: "Yes, Generate OTP",
                cancelButtonText: "Cancel"
            }).then((result) => {
                if (result.isConfirmed) generateOTP(worker_id, already_reg_status);
            });
        }
        // Function to generate and send OTP
        function generateOTP(worker_id, already_reg_status) {
            Swal.fire({
                title: "Generating OTP...",
                text: "Please wait...",
                allowOutsideClick: false,
                backdrop: true,
                didOpen: () => {
                    Swal.showLoading(); // Show loading animation
                }
            });

            fetch('otp/generate-worker-revert', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({
                        worker_id: worker_id
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.status) {
                        Swal.fire({
                            title: "OTP Sent!",
                            text: "Check your phone for the OTP.",
                            icon: "success",
                            input: "text",
                            inputPlaceholder: "Enter OTP",
                            inputAttributes: {
                                maxlength: "6",
                                autocapitalize: "off",
                                autocorrect: "off"
                            },
                            showCancelButton: true,
                            allowOutsideClick: false,
                            backdrop: true,
                            confirmButtonText: "Verify OTP",
                            cancelButtonText: "Cancel",
                            preConfirm: (otp) => {
                                if (!otp || otp.length !== 6) {
                                    Swal.showValidationMessage("Please enter a valid 6-digit OTP.");
                                }
                                return otp;
                            }
                        }).then((result) => {
                            if (result.isConfirmed) {
                                verifyOTP(worker_id, result.value,
                                    already_reg_status); // ✅ Pass already_reg_status
                            }
                        });
                    } else {
                        Swal.fire("Error", data.message, "error");
                    }
                })
                .catch(error => {
                    Swal.fire("Error", "Something went wrong!", "error");
                });
        }


        // Function to verify OTP
        function verifyOTP(worker_id, otp, already_reg_status) {
            console.log(already_reg_status);
            Swal.fire({
                title: "Verifying OTP...",
                text: "Please wait...",
                allowOutsideClick: false,
                backdrop: true,
                didOpen: () => {
                    Swal.showLoading();
                }
            });

            fetch('verify/otp-revert', {

                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({
                        worker_id: worker_id,
                        otp: otp
                    })

                })
                .then(response => response.json())
                .then(data => {
                    console.log(already_reg_status);
                    if (data.success) {
                        Swal.fire({
                            title: "OTP Verified!",
                            text: "Redirecting...",
                            icon: "success",
                            allowOutsideClick: false,
                            timer: 2000,
                            showConfirmButton: false

                        }).then(() => {
                            console.log(already_reg_status);
                            window.location.href = already_reg_status ?
                                "/existing-worker/existing-worker-basic-details" :
                                "/worker/worker-basic-details?worker_id=" + worker_id;
                        });
                    } else {
                        // Show the OTP input again with an error message
                        Swal.fire({
                            title: "Invalid OTP!",
                            text: "Please enter the correct OTP.",
                            icon: "error",
                            input: "text",
                            inputPlaceholder: "Enter OTP",
                            allowOutsideClick: false,
                            backdrop: true,
                            showCancelButton: true,
                            confirmButtonText: "Verify OTP",
                            cancelButtonText: "Cancel",
                            preConfirm: (newOtp) => {
                                if (!newOtp || newOtp.length !== 6) {
                                    Swal.showValidationMessage("Please enter a valid 6-digit OTP.");
                                }
                                return newOtp;
                            }
                        }).then((result) => {
                            if (result.isConfirmed) {
                                verifyOTP(worker_id, result.value, already_reg_status); // Retry verification
                            }
                        });
                    }
                })
                .catch(error => {
                    Swal.fire("Error", "Something went wrong!", "error");
                });
        }
    </script>


    <script>
        $("#menu-toggle").click(function(e) {
            e.preventDefault();
            $("#wrapper").toggleClass("toggled");
        });

        // Menu items show hide
        $(document).ready(function() {
            $(".b-navdropdown-click").click(function() {
                if ($(".b-navdropdown").hasClass("hide")) {
                    $(".b-navdropdown").addClass("show");
                    $(".b-navdropdown").removeClass("hide");
                    // $(".b-icon-up").show();
                    // $(".b-icon-down").hide();
                } else if ($(".b-navdropdown").hasClass("show")) {
                    $(".b-navdropdown").addClass("hide");
                    $(".b-navdropdown").removeClass("show");
                    // $(".b-icon-down").show();
                    // $(".b-icon-up").hide();
                }
            });
        });

        // counter
        const counters = document.querySelectorAll('.counter-item');
        const speed = 200;

        counters.forEach(counter => {
            const animate = () => {
                const value = +counter.getAttribute('akhi');
                const data = +counter.innerText;

                const time = value / speed;
                if (data < value) {
                    counter.innerText = Math.ceil(data + time);
                    setTimeout(animate, 1);
                } else {
                    counter.innerText = value + '+';
                }
            }
            animate();
        });
    </script>
    <script type="text/javascript">
        $(document).ready(function() {
            $("#pop").click(function() {
                $('#firstModal').modal('show');
            });
        });
    </script>

    <script>
        $(document).ready(function() {
            $('#myModal').modal({
                backdrop: 'static',
                keyboard: false
            }, 'show');

        });
    </script>
    @if ($errors->any())
        <script>
            $(document).ready(function() {
                $('#myModal').modal({
                    backdrop: 'static',
                    keyboard: false
                }, 'show');

            });
        </script>
    @endif

    <link rel="stylesheet" href="{{ URL::asset('assets/template/css/toastr.min.css') }}" />
    <script src="{{ URL::asset('assets/template/js/aadhaarAuth.js') }}"></script>
    <script src="{{ URL::asset('assets/template/js/toastr.min.js') }}"></script>

    <script src="{{ URL::asset('assets/template/js/carousal-footer.js') }}" type="text/javascript"></script>
    <script src="{{ URL::asset('assets/template/js/slick.js') }}" type="text/javascript" charset="utf-8"></script>
    <script type="text/javascript">
        $(document).on('ready', function() {

            $(".slick").slick({
                dots: true,
                infinite: true,
                centerMode: true,
                slidesToShow: 5,
                slidesToScroll: 1,
                autoplay: true,
                autoplaySpeed: 2000,
                cssEase: 'linear',

                responsive: [{
                        breakpoint: 1024,
                        settings: {
                            slidesToShow: 3,
                            slidesToScroll: 3,
                            infinite: true,
                            dots: true
                        }
                    },
                    {
                        breakpoint: 600,
                        settings: {
                            slidesToShow: 2,
                            slidesToScroll: 2
                        }
                    },
                    {
                        breakpoint: 480,
                        settings: {
                            slidesToShow: 1,
                            slidesToScroll: 1
                        }
                    },


                    // You can unslick at a given breakpoint now by adding:
                    // settings: "unslick"
                    // instead of a settings object
                ]
            });

        });
    </script>



    <script>
        function loginWithIdCard(idCard) {
            $("#id_card").val(idCard);
            $("#id_card").attr('readonly', true);
            $("#login-modal").modal({
                backdrop: 'static',
                keyboard: false
            }).modal('show');
        }
    </script>




    {{--    <script> --}}
    {{--        $(document).ready(function() { --}}
    {{--            // When clicking the button in the first modal to open the second modal --}}
    {{--            $('#open-already-registered').click(function() { --}}
    {{--                // Hide the first modal --}}
    {{--                $('#register-modal').removeClass('show').hide(); --}}
    {{--                // Show the backdrop --}}
    {{--                $('.modal-backdrop').remove(); --}}
    {{--                // Show the second modal --}}
    {{--                $('#already-registered-modal').addClass('show').show(); --}}
    {{--            }); --}}

    {{--            // When clicking the button in the second modal to go back to the first modal --}}
    {{--            $('#backToFirstModalBtn').click(function() { --}}
    {{--                // Hide the second modal --}}
    {{--                $('#already-registered-modal').removeClass('show').hide(); --}}
    {{--                // Show the backdrop --}}
    {{--                $('.modal-backdrop').remove(); --}}
    {{--                // Show the first modal --}}
    {{--                $('#register-modal').addClass('show').show(); --}}
    {{--            }); --}}

    {{--        }); --}}
    {{--    </script> --}}



    <script>
        $(document).ready(function() {
            $('#renewal-btn-worker').on('click', function() {
                var id_card_renewal = $('#worker_id_renew').val();
                var $button = $(this);
                if (id_card_renewal === '') {
                    alert('Please enter ID Card.');
                } else {
                    $button.prop('disabled', true).html(
                        '<i class="fa fa-spinner fa-spin"></i> Please wait');

                    $.ajax({
                        url: "{{ route('get-worker-data') }}",
                        type: 'GET',
                        data: {
                            'id_card': id_card_renewal,
                            "_token": $('meta[name="csrf-token"]').attr('content'),
                        },
                        dataType: 'json',
                        success: function(response) {
                            if (response.success) {
                                toastr.success(response.msg);
                                var workerData = response.data;
                                window.location.href = "{{ route('show-worker-data') }}";
                            } else if (response.error) {
                                toastr.error(response.error); // Display error message
                                console.log(response
                                    .error); // Log the error message to the console
                                $button.prop('disabled', false).html(
                                    '<i class="fa fa-check" aria-hidden="true"></i>&nbsp;Check  কৰক'
                                );
                            }
                        },
                        error: function(xhr, status, error) {
                            var response = JSON.parse(xhr.responseText);
                            toastr.error(response.error ||
                                'An unexpected error occurred.'); // Display error message
                            console.log(response.error ||
                                'An unexpected error occurred.'
                            ); // Log the error message to the console
                            $button.prop('disabled', false).html(
                                '<i class="fa fa-check" aria-hidden="true"></i>&nbsp;Check  কৰক'
                            );
                        }
                    });
                }
            });
        });
    </script>
    @if (session()->has('from_onboarding'))
        <script>
            $(document).ready(function() {
                $('#onboardingregister-modal').addClass('show').show();
                $("#new-register-button").addClass("disabled-link");
            });
        </script>
    @endif
    <script>
        $(document).ready(function() {
            function reveal() {
                var reveals = document.querySelectorAll(".reveal");

                for (var i = 0; i < reveals.length; i++) {
                    var windowHeight = window.innerHeight - 1;
                    var elementTop = reveals[i].getBoundingClientRect().top;
                    var elementBottom = reveals[i].getBoundingClientRect().bottom;

                    // Adjusted condition to check if the top or bottom of the element is within the viewport
                    if ((elementTop < windowHeight && elementTop > 0) || (elementBottom < windowHeight &&
                            elementBottom > 0)) {
                        reveals[i].classList.add("active");
                    } else {
                        reveals[i].classList.remove("active");
                    }
                }
            }

            window.addEventListener("scroll", reveal);

            // Call reveal() once after the document is ready to make elements initially visible
            reveal();
        });
    </script>
    <script>
        $(document).ready(function() {
            $('#submit-app').on('click', function() {
                var applicationNo = $('#application_no').val();

                // Show loading spinner
                $('#loading-spinner').removeClass('d-none');

                // Disable the button to prevent multiple submissions
                $(this).prop('disabled', true);

                // AJAX request
                $.ajax({
                    url: "{{ route('login-basic-details') }}", // URL of the route
                    type: 'POST',
                    data: {
                        application_no: applicationNo,
                        "_token": $('meta[name="csrf-token"]').attr('content'),
                    },
                    success: function(response) {
                        // Handle success response
                        console.log(response);
                        // Redirect or perform any action based on response
                    },
                    error: function(xhr, status, error) {
                        // Handle error response
                        console.error(xhr.responseText);
                        // Display error message or handle accordingly
                    },
                    complete: function() {
                        // Hide loading spinner
                        $('#loading-spinner').addClass('d-none');

                        // Enable the button
                        $('#submit-app').prop('disabled', false);
                    }
                });
            });
        });
    </script>
    <script>
        // Add event listeners to navigation buttons
    </script>
    <script>
        function toggleText(key) {
            var icon = document.getElementById('iconCollapse' + key);
            var collapseElement = document.getElementById('collapse' + key);

            if (collapseElement.classList.contains('show')) {
                icon.innerHTML = '↓';
            } else {
                icon.innerHTML = '↑';
            }
        }
    </script>
    <script>
        // document.addEventListener('DOMContentLoaded', function() {
        //     const languageModal = new bootstrap.Modal(document.getElementById('languageModal'));

        //     if (!localStorage.getItem('languageSelected')) {
        //         languageModal.show();
        //     }

        //     // Check if Assamese was selected before reload
        //     if (localStorage.getItem('showAttentionModal') === 'true') {
        //         localStorage.removeItem('showAttentionModal'); // Remove flag after opening modal
        //         setTimeout(() => {
        //             $('#attentionindex-modal').modal('show'); // Show the Attention modal
        //         }, 500); // Small delay to ensure modal transition is smooth
        //     }

        //     // Open Attention Modal when Close button is clicked
        //     document.getElementById('close-language-btn').addEventListener('click', function() {
        //         setTimeout(() => {
        //             $('#attentionindex-modal').modal('show'); // Show the modal after closing
        //         }, 500); // Small delay ensures the first modal fully closes
        //     });
        // });

        function selectLanguage(url) {
            localStorage.setItem('languageSelected', 'true');

            // If Assamese is selected, set the flag
            if (url.includes('/as')) {
                localStorage.setItem('showAttentionModal', 'true');
            }

            window.location.href = url;
        }
    </script>
@endsection
