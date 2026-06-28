@extends('layouts.user-app')

@section('title', ' About Us | Mission & Vission')
@section('style')
    {{-- <link rel="stylesheet" href="{{ URL::asset('assets/template/css/missionandvission.css') }}" /> --}}


@endsection


@section('content')

    <!-- Increase the height of the background image container -->
    <div id="b-homedb" class="mission-vission">

        <div class="container">
<div class="heading mt-5">
    <h2>{{ trans('missionandvission.missionandvision') }}</h2>
    <div class="centerHeading"></div>
</div>
            <div class="row">


                <div class="col-md-7">

                    <div class="row">
                        <div class="col-md-12">

                            <h3 style="color: darkslategray; margin-top: 5%; font-family:'Roboto',Sans-Serif; font-size: 22px;">
                                {{ trans('missionandvission.vision') }}</h3>
                            <div style="background-color: #f2cc5f;  height: 2px; width: 20%;"></div>
                            <p class="font-weight-normal text-justify" style="margin-top: 18px; font-family:'Roboto',Sans-Serif; font-size: 16px;">
                                {{ trans('missionandvission.visionbody') }}</p>
                        </div>
                    </div>



                    <div class="row">
                        <div class="col-md-12" >
                            <h3 style="color: darkslategray; margin-top: 3%;font-family:'Roboto',Sans-Serif; font-size: 22px; ">
                                {{ trans('missionandvission.mission') }}</h3>
                            <div style="background-color: #f2cc5f;    height: 2px; width: 20%;"></div>
                            <p class="font-weight-normal text-justify" style="margin-top: 18px; font-family:'Roboto',Sans-Serif; font-size: 16px;">

                                {{ trans('missionandvission.missionbody') }}</p>
                        </div>
                    </div>

                </div>
                <div class="col-md-5 pl-md-5">
                    <img width="100%" src="{{ asset('assets/template/images/missionandvission/image.png') }}">
                </div>


            </div>

        </div>
    </div>

@endsection


@section('footer')

@endsection
