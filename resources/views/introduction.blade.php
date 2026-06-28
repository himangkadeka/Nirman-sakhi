@extends('layouts.user-app')

@section('title', ' About | Introduction')

@section('style')

    <link rel="stylesheet" href="{{ URL::asset('assets/template/css/introduction.css') }}" />
    <style>
        h4 {
            display: inline-block;

            position: relative;

            z-index: 1;

            color: #504f5f;
        }
    </style>
@endsection


@section('content')


    <section class="about_section" id="b-homedb">
        <div class="container ">
            <div class="row justify-content-center align-items-center mt-4 mb-4">
                <div class="col-md-5">
                    <div class="about_img position-relative">
                        <img src="{{ asset('assets/template/images/introduction/image_1.png') }}" alt="idea-images"
                            class="about_img_1">
                        <!-- <hr class="horizontal-line1"> -->
                        <!-- <div class="vertical-line1"></div> -->
                        <!-- <div class="vertical-line3"></div> -->

                        <!-- <img src="{{ asset('assets/template/images/introduction/image_2.png') }}" alt="idea-images"
                                class="about_img_2"> -->
                        <!-- <div class="vertical-line2"></div> -->

                        <img src="{{ asset('assets/template/images/introduction/image_3.png') }}" alt="idea-images"
                            class="about_img_3" id="mymove">

                        <!-- <hr class="horizontal-line2"> -->
                    </div>
                </div>
                <div class="col-md-7">

                    <div class="heading intro">
                        <h4>
                            {{ trans('introduction.intro') }}</h4>

                        <div class="underline"></div>
                    </div>






                    <div class="row">
                        <div class="col-12">
                            <p class="mt-3 introbody" style="text-align: justify; font-size: 16px;">
                                {{ trans('introduction.bocw') }}

                            </p>
                            <div class="" id="">
                                <p class=" introbodyreadmore " style="text-align: justify; font-size: 16px;">
                                    {{ trans('introduction.readmoretext') }}

                                </p>

                                {{-- <p class="">
                                    <a  style="color: #7ea1a2; font-size: 16px;">
                                        {{ trans('introduction.readmore') }}...
                                    </a>
                                </p> --}}

                            </div>

                            {{-- <p class="">
                                <a class="read-more-toggle" data-toggle="collapse" href="#collapseExample" role="button"
                                    aria-expanded="false" aria-controls="collapseExample" style="color: #7ea1a2; font-size: 16px;">
                                    {{ trans('introduction.readmore') }}...
                                </a>
                            </p> --}}
                        </div>
                    </div>


                </div>
            </div>
        </div>
    </section>





    <!-- Fourth Row with 100% Width Image -->
    <!-- <div class="container-fluid"
                style="background-image: url('/assets/template/images/introduction/Introduction-officials.png'); background-size: cover;">
                <div class="row">
                    <div class="col-lg-12 col-md-12 " style="display: flex; justify-content:center; align-items:center; height:15vh">
                        <div class="align-middle" style="font-size: 22px;font-weight:550;">{{ trans('introduction.officials') }}</div>
                    </div>
                </div>
            </div>

            <div class="container-fluid  pb-5">
                <div class="row fifth-row justify-content-center py-5 ">

                    <div class="col-md-4  mb-5 text-center" style="display: flex; justify-content:center; align-items:center; ">
                        <div class="officer1vertical-line1"></div>
                        <hr class="officer1horizontal-line1">
                        <div class="officer1vertical-line2"></div>

                        <img src="{{ asset('assets/template/images/introduction/gdtripathi_0.jpg') }}"
                            alt="Officer 1 Image" class="img-fluid officer1img" >
                        <hr class="officer1horizontal-line2">

                        <div class="col-lg-10  officer1" style="margin-left: 10%; margin-top:27%;">
                            <div class="officer1name" style=" font-family:'Roboto',Sans-Serif">{{ trans('introduction.KalyanChakravarty') }}</div>
                            <p class="  officer1text p-1" style=" text-align:center; font-family:'Roboto',Sans-Serif">
                                {{ trans('introduction.KalyanChakravartytext') }}</p>
                        </div>


                    </div>
                    <div class="col-md-4  mb-5 text-center" style="display: flex; justify-content:center; align-items:center; ">
                        <div class="officer2vertical-line1"></div>
                        <hr class="officer2horizontal-line1">
                        <div class="officer2vertical-line2"></div>

                        <img src="{{ asset('assets/template/images/introduction/AnamikaTewari.jpg') }}" alt="Officer 2 Image"
                            class="img-fluid officer2img" >
                        <hr class="officer2horizontal-line2">

                        <div class="col-lg-10 officer1" style="margin-left: 10%; margin-top:27%;">
                            <div class="officer2name" style=" font-family:'Roboto',Sans-Serif">{{ trans('introduction.AnamikaTewari') }}</div>
                            <p class=" officer2text p-2" style=" text-align:center;font-family:'Roboto',Sans-Serif">
                                {{ trans('introduction.AnamikaTewaritext') }}</p>
                        </div>


                    </div>

                    <div class="col-md-4  text-center" style="display: flex; justify-content:center; align-items:center; ">
                        <div class="officer3vertical-line1"></div>
                        <hr class="officer3horizontal-line1">
                        <div class="officer3vertical-line2"></div>

                        <img src="{{ asset('assets/template/images/introduction/Ishanu.jpg') }}" alt="Officer 3 Image"
                            class="img-fluid officer3img " >


                        <hr class="officer3horizontal-line2">

                        <div class="col-lg-10 officer1" style="margin-left: 30px; margin-top:27%;">
                            <div class="officer3name" style="font-family:'Roboto',Sans-Serif ">{{ trans('introduction.IshanuShah') }}</div>
                            <p class=" officer3text p-2" style=" text-align:center;font-family:'Roboto',Sans-Serif ">
                                {{ trans('introduction.IshanuShahtext') }}</p>
                        </div>


                    </div>


                </div>
            </div> -->

    <div class="officerSection">
        <div class="official">
            <h2>{{ trans('introduction.officials') }}</h2>
            <div class="centerHeading"></div>
        </div>
        <div class="officersBox">
            <div class="officer">

                <img src="{{ asset('assets/template/images/index/chairman.png') }}" alt="Image 3">
                <div class="officerInfo">
                    <h3>{{ trans('introduction.csname') }}</h3>
                    <p style="font-size:14px;">{{ trans('introduction.cstext') }}</p>
                </div>
            </div>
            <div class="officer">
                <img src="{{ asset('assets/template/images/index/lc.jpg') }}" alt="Image 3">
                <div class="officerInfo">
                    <h3>{{ trans('index.lcname') }}</h3>
                    <p>{{ trans('index.lctext') }} </p>
                </div>
            </div>
            <div class="officer">
                <img src="{{ asset('assets/template/images/introduction/Ishanu.jpg') }}" alt="officer1">
                <div class="officerInfo">
                    <h3>{{ trans('introduction.IshanuShah') }}</h3>
                    <p>{{ trans('contactus.ishanushahtext') }} </p>
                </div>
            </div>
        </div>
    </div>

@endsection


@section('footer')
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const readMoreToggle = document.querySelector(".read-more-toggle");
            const collapseExample = document.querySelector("#collapseExample");
            let isCollapsed = true;

            readMoreToggle.addEventListener("click", function() {
                if (isCollapsed) {
                    collapseExample.style.display = "block";
                    readMoreToggle.textContent = "{{ trans('introduction.readless') }}...";
                } else {
                    collapseExample.style.display = "none";
                    readMoreToggle.textContent = "{{ trans('introduction.readmore') }}...";
                }
                isCollapsed = !isCollapsed;
            });
        });
    </script>
@endsection
