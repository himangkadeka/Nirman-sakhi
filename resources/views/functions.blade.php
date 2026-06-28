@extends('layouts.user-app')

@section('title', ' About Us | Functions of the Board')
@section('style')
    {{-- <link rel="stylesheet" href="{{ URL::asset('assets/template/css/functions.css') }}" /> --}}
    <style>
        /* body {
            font-family: 'Roboto', sans-serif;
            font-size: 16px;
        } */

        .cardhead1 {

            background: linear-gradient(to right, #00008b, #279ca0);
            cursor: pointer;
            position: relative;
            border-radius: 0;
            width: 330px;
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


        .card-content {
            color: white;
            padding: 6px 0;
            margin-left: 17%;
            font-size: 17px;
            font-family: 'Roboto', Sans-Serif;
            font-weight: 550;

        }




        @media (max-width: 575.98px) {
            /* CSS rules for phones */
        }

        @media (min-width: 576px) and (max-width: 767.98px) {
            /* CSS rules for tablets */
        }

        @media (min-width: 768px) and (max-width: 991.98px) {
            /* CSS rules for small laptops */
        }

        @media (min-width: 992px) and (max-width: 1199.98px) {
            /* CSS rules for laptops and desktops */
        }

        @media (min-width: 1200px) {
            /* CSS rules for large desktops */
        }
    </style>
@endsection


@section('content')
    <div class="container-fluid head1 mt-2">
        <div class="heading mt-3">
            <h2>
                {{ trans('functionsOfTheBoard.head') }}</h2>
            <div class="centerHeading"></div>
        </div>
    </div>
    <div class="cardhead1triangle"></div>

    <section class="container-fluid" id="b-homedb">

        <div class="container-fluid mt-4 pl-5">
            <p class="aimsandobjectives-body" style="font-family:'Roboto',Sans-Serif">
                <strong style="font-family:'Roboto',Sans-Serif">{{ trans('functionsOfTheBoard.abocwwb') }} </strong>
                {{ trans('functionsOfTheBoard.abocwwb2') }}
            </p>
        </div>
    </section>

    <div class="container-fluid mt-4 ">
        <div class="row no-gutters ml-5">
            <div class="col-sm-12 mb-3 aimsandobjectives">
                <div style="font-weight: bold; font-size:17px;font-family:'Roboto',Sans-Serif">
                    {{ trans('functionsOfTheBoard.pointhead') }}</div>
                <div class="mb-2 mt-2" style="font-family:'Roboto',Sans-Serif; font-size:16px;"><i
                        class="fas fa-caret-right" style="color: teal;"></i>
                    {{ trans('functionsOfTheBoard.point1') }}
                </div>
                <div class="mb-2" style="font-family:'Roboto',Sans-Serif;font-size:16px;"><i class="fas fa-caret-right"
                        style="color: teal;"></i>
                    {{ trans('functionsOfTheBoard.point2') }}
                </div>
                <div class="mb-2" style="font-family:'Roboto',Sans-Serif;font-size:16px;"><i class="fas fa-caret-right"
                        style="color: teal;"></i>
                    {{ trans('functionsOfTheBoard.point3') }}
                </div>
                <div class="mb-2" style="font-family:'Roboto',Sans-Serif;font-size:16px;"><i class="fas fa-caret-right"
                        style="color: teal;"></i>
                    {{ trans('functionsOfTheBoard.point4') }}
                </div>
                <div class="mb-2" style="font-family:'Roboto',Sans-Serif;font-size:16px;"><i class="fas fa-caret-right"
                        style="color: teal;"></i>
                    {{ trans('functionsOfTheBoard.point5') }}
                </div>
                <div class="mb-2" style="font-family:'Roboto',Sans-Serif;font-size:16px;"><i class="fas fa-caret-right"
                        style="color: teal;"></i>
                    {{ trans('functionsOfTheBoard.point6') }}
                </div>
            </div>
        </div>
    </div>

@endsection


@section('footer')

@endsection


<!-- About Container -->
