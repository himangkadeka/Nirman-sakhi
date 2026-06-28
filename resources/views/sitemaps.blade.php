@extends('layouts.user-app')

@section('title', ' Site Map')

@section('style')

    <style>
        .cardhead1 {
            background: linear-gradient(to right, #00008b, #279ca0);
            border: 1.5px solid #076f6b;
            cursor: pointer;
            position: relative;
            width: 250px;
        }

        .cardhead1triangle {
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


        .card-content {
            color: white;
            padding: 10px;
            margin-left: 25%;
            font-size: 20px;
            font-weight: 600;
            font-family: 'Roboto', Sans-Serif;

        }

        .list-group-item {
            border: none;
        }
    </style>
@endsection

@section('content')
    <div id="b-homedb">
        <div class="container-fluid">


            <div class="heading mt-3">
                <h2 style=" ">
                    {{ trans('footer.Sitemap') }}

                </h2>
                <div class="centerHeading"></div>
            </div>

        </div>
        <div class="container mt-4">
            <div class="row">
                <div class="col-6" style="">
                    <ul class="pl-4">
                        <li class="" style="font-family:'Roboto',Sans-Serif;">{{ trans('header.home') }}</li>
                        <li class="" style="font-family:'Roboto',Sans-Serif;">{{ trans('header.about_us') }}
                            <ul>
                                <li style="font-family:'Roboto',Sans-Serif;"><a
                                        href="{{ route('home.about.introduction') }}"
                                        class="ml-2 @if (Route::is('home.about.introduction')) active-new @endif">{{ trans('header.introduction') }}</a>
                                </li>
                                <li style="font-family:'Roboto',Sans-Serif;"> <a href="{{ route('home.about.whos-who') }}"
                                        class="ml-2 @if (Route::is('home.about.whos-who')) active-new @endif">{{ trans('header.who') }}</a>
                                </li>
                                <li style="font-family:'Roboto',Sans-Serif;"><a
                                        href="{{ route('home.about.mission-and-vission') }}"
                                        class="ml-2 @if (Route::is('home.about.mission-and-vission')) active-new @endif">{{ trans('header.missionandvision') }}</a>
                                </li>
                                <li style="font-family:'Roboto',Sans-Serif;"><a
                                        href="{{ route('home.about.aims-and-objectives') }}"
                                        class="ml-2 @if (Route::is('home.about.aims-and-objectives')) active-new @endif">{{ trans('header.aimsandobjectives') }}</a>
                                </li>
                                <li style="font-family:'Roboto',Sans-Serif;"><a href="{{ route('home.about.functions') }}"
                                        class="ml-2 @if (Route::is('home.about.functions')) active-new @endif">{{ trans('header.functions') }}</a>
                                </li>
                                <li style="font-family:'Roboto',Sans-Serif;"><a
                                        href="{{ route('home.about.organizations') }}"
                                        class="ml-2 @if (Route::is('home.about.organizations')) active-new @endif">{{ trans('header.organogram') }}</a>
                                </li>
                            </ul>
                        </li>
                        {{-- <li class=""><a href="{{ route('home.schemes') }}"
                                class=" @if (Route::is('home.schemes'))  @endif ">{{ trans('header.schemes') }}</a></li> --}}
                        <li class="" style="font-family:'Roboto',Sans-Serif;"><a
                                href="{{ route('home.actandrules') }}"
                                class=" @if (Route::is('home.actandrules'))  @endif ">{{ trans('header.actandrules') }}</a>
                        </li>

                        <li class="" style="font-family:'Roboto',Sans-Serif;">{{ trans('header.benefits') }}
                            <ul>
                                <li style="font-family:'Roboto',Sans-Serif">

                                    <a class=" @if (Route::is('home.schemesandbenefits.benifits'))  @endif"
                                        href="{{ route('home.schemesandbenefits.benefits') }}">Benefits provided
                                        by the Board</a>

                                </li>
                                <li style="font-family:'Roboto',Sans-Serif">

                                    <a class=" @if (Route::is('home.grivence'))  @endif" href="#" data-toggle="modal"
                                        data-target="#listofapprovedbenefits-modal">List of approved
                                        beneficiaries</a>

                                </li>

                            </ul>
                        </li>




                        <li class="" style="font-family:'Roboto',Sans-Serif;">
                            <a href="{{ route('home.gallery') }}"
                                class=" @if (Route::is('home.gallery'))  @endif ">{{ trans('header.gallery') }}</a>

                        </li>

                        <li class="" style="font-family:'Roboto',Sans-Serif;"> {{ trans('header.eservices') }}

                            @php
                                $cards = [
                                    [
                                        'image' => asset('assets/template/images/index/registration.png'),
                                        'title' => __('index.constructionworker'),
                                        'subtitle' => __('index.newregistration'),
                                        'modal' => '#register-modal',
                                        'circle-bg-color' => '#ffad16',
                                    ],
                                    [
                                        'image' => asset('assets/template/images/index/registration.png'),
                                        'title' => __('index.constructionworker'),
                                        'subtitle' => __('index.oldregistration'),
                                        'modal' => '#onboardingregister-modal',
                                        'circle-bg-color' => '#009cdb',
                                    ],
                                ];
                            @endphp
                            <ul
                                style="font-family:'Roboto',Sans-Serif">
                                <li style="font-family:'Roboto',Sans-Serif">
                                    <a class="" href="{{ $cards[0]['modal'] }}"
                                        data-toggle="modal" data-target="{{ $cards[0]['modal'] }}">
                                        {{ $cards[0]['subtitle'] }}
                                    </a>
                                </li>
                                <li style="font-family:'Roboto',Sans-Serif">
                                    <a class="" href="{{ $cards[1]['modal'] }}"
                                        data-toggle="modal" data-target="{{ $cards[1]['modal'] }}">
                                        {{ __('index.oldregistration') }}
                                    </a>
                                </li>
                                <li style="font-family:'Roboto',Sans-Serif"><a class=""
                                        href="#" data-toggle="modal" data-target="#renewal-modal">Renewal</a>
                                </li>

                                <li style="font-family:'Roboto',Sans-Serif"><a
                                        class=" @if (Route::is('home.grivence')) active @endif"
                                        href="#" data-toggle="modal"
                                        data-target="#grievance-modal">{{ trans('header.grivence') }}</a>
                                </li>
                                <li style="font-family:'Roboto',Sans-Serif"><a
                                        class=" @if (Route::is('home.helpdesk')) active @endif"
                                        href="{{ route('home.services.helpdesk') }}">Helpdesk</a>
                                </li>
                            </ul>
                        </li>

                        <li class="" style="font-family:'Roboto',Sans-Serif;"> <a
                                class="@if (Route::is('home.downloads'))  @endif"
                                href="{{ route('home.downloads') }}">{{ trans('header.downloads') }}</a>
                        </li>
                        <li class="" style="font-family:'Roboto',Sans-Serif;"><a href="#"
                                class=" @if (Route::is('home.mis'))  @endif " data-toggle="modal"
                                data-target="#mis-modal">{{ trans('header.mis') }}</a></li>
                                <li class="" style="font-family:'Roboto',Sans-Serif;"><a href="{{ route('home.contactus') }}"
                                    class=" @if (Route::is('home.contactus'))  @endif ">{{ trans('header.contact_us') }}</a>
                            </li>
                             <li class="" style="font-family:'Roboto',Sans-Serif;"> <a
                                class=" @if (Route::is('home.pfcs.pfcdetails'))  @endif"
                                href="{{ route('home.pfcs.pfcdetails') }}">{{ trans('header.pfcdetails') }}</a>
                        </li>
                        <li class="" style="font-family:'Roboto',Sans-Serif;">PFCs
                            <ul>
                                <li style="font-family:'Roboto',Sans-Serif">

                                    <a class="@if (Route::is('home.pfcs.pfcdetails'))  @endif"
                                    href="{{ route('home.pfcs.pfcdetails') }}">{{ trans('header.pfcdetails') }}</a>

                                </li>


                            </ul>
                        </li>

                    </ul>
                </div>

            </div>
        </div>




    </div>
    @include('components.cess-modal')
    @include('components.grievance-modal')
    @include('components.mis-modal')
    @include('components.listofapprovedbenefits')
@endsection
@section('footer')

@endsection


<!-- About Container -->
