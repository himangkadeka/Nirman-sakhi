@extends('layouts.user-app')

@section('title', ' Gallery')
<link href="{{ URL::asset('assets/template/css/fancybox.min.css') }}" rel="stylesheet" type="text/css" />
<!-- Video.js CSS -->
<link href="https://vjs.zencdn.net/7.21.1/video-js.css" rel="stylesheet" />
@section('style')

    <style>
        .photo-gallery {
            width: 100%;
            min-height: 100vh;
            background: linear-gradient(0deg, #f5f3f3d9, #f8f5f5d1), url(/assets/template/images/background.jpg);
            background-size: cover;
            background-attachment: fixed;
        }

        .column {
            float: left;
            width: 33.33%;
            display: none;
            transition: all 0.4s ease;
        }

        .column:hover {
            transform-style: preserve-3d;
            transform: rotateY(15deg);
        }

        /* Clear floats after rows */
        .row:after {
            content: "";
            display: table;
            clear: both;
        }

        /* Content */
        .content {
            padding: 10px;
            height: 172px;
        }

        .content a img {
            width: 100%;
            border-radius: 14px;
            box-shadow: rgba(99, 99, 99, 0.2) 0px 2px 8px 0px;
            height: 100%;
            object-fit: cover;
        }


        /* The "show" class is added to the filtered elements */
        .show {
            display: block;
        }

        .fancybox-button.fancybox-button--zoom {
            display: none
        }

        .fancybox-button.fancybox-button--share {
            display: none
        }

        .gal-heading {
            display: block;
            text-align: center;
            padding: 30px 0px 5px
        }

        #myBtnContainer {
            display: flex;
            flex-direction: column;
            gap: 5px;
            position: sticky;
            top: 50px;
        }

        #myBtnContainer button {
            border: none;
            border-radius: 4px;
            padding: 16px;
            box-shadow: rgba(99, 99, 99, 0.2) 0px 2px 8px 0px;
            background: #ec6e47;
            color: #fff;
            font-weight: 500;
            border-bottom: 3px solid #FFC107;
        }

        #myBtnContainer .mybtn.active {
            background: black
        }
    </style>
@endsection

@section('content')
    <section class="photo-gallery">

        <div class="container">
            <div class="row gal-heading">
                <div class="heading">
                    <h2>{{ trans('gallery.gallery') }}</h2>
                    <div class="centerHeading"></div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-3">
                    <div id="myBtnContainer">
                        <button class="mybtn" onclick="filterSelection('all')"> {{ trans('gallery.showall') }} </button>
                        <button class="mybtn" onclick="filterSelection('Ballamguri')">
                            {{ trans('gallery.BalamguriCSTC') }}</button>
                        <button class="mybtn" onclick="filterSelection('Ceremonial')"> {{ trans('gallery.cdsm') }}</button>
                        <button class="mybtn" onclick="filterSelection('Gogamukh')">
                            {{ trans('gallery.gogamukh') }}</button>
                        <button class="mybtn active" onclick="filterSelection('Shramik')">
                            {{ trans('gallery.shramikkalyandivas') }}</button>
                        <button class="mybtn" onclick="filterSelection('Transit')"> {{ trans('gallery.transit') }}</button>
                        <button class="mybtn" onclick="filterSelection('Rollout_CSC')"> ROLL OUT of CSC for Nirman Sakhi
                            Portal</button>
                        {{-- <button class="mybtn" onclick="filterSelection('CSC_Eng')"> ROLL OUT of CSC for Nirman Sakhi Portal(English)</button> --}}
                    </div>
                </div>

                <div class="col-md-9 pl-md-4">
                    <!-- Ballamguri Photos -->
                    <div class="column Ballamguri">
                        <div class="content">
                            <a href="{{ URL::asset('assets/template/images/gallery/balamguri_cstc/img1.jpg') }}"
                                data-fancybox="gallery" data-caption=" ">
                                <img src="{{ URL::asset('assets/template/images/gallery/balamguri_cstc/img1.jpg') }}"
                                    alt="" width="100%" />
                            </a>
                        </div>
                    </div>
                    <div class="column Ballamguri">
                        <div class="content">
                            <a href="{{ URL::asset('assets/template/images/gallery/balamguri_cstc/img2.jpg') }}"
                                data-fancybox="gallery" data-caption=" ">
                                <img src="{{ URL::asset('assets/template/images/gallery/balamguri_cstc/img2.jpg') }}"
                                    alt="" width="100%" />
                            </a>
                        </div>
                    </div>
                    <div class="column Ballamguri">
                        <div class="content">
                            <a href="{{ URL::asset('assets/template/images/gallery/balamguri_cstc/img3.jpg') }}"
                                data-fancybox="gallery" data-caption=" ">
                                <img src="{{ URL::asset('assets/template/images/gallery/balamguri_cstc/img3.jpg') }}"
                                    alt="" width="100%" />
                            </a>
                        </div>
                    </div>
                    <div class="column Ballamguri">
                        <div class="content">
                            <a href="{{ URL::asset('assets/template/images/gallery/balamguri_cstc/img4.jpg') }}"
                                data-fancybox="gallery" data-caption=" ">
                                <img src="{{ URL::asset('assets/template/images/gallery/balamguri_cstc/img4.jpg') }}"
                                    alt="" width="100%" />
                            </a>
                        </div>
                    </div>
                    <div class="column Ballamguri">
                        <div class="content">
                            <a href="{{ URL::asset('assets/template/images/gallery/balamguri_cstc/img5.jpg') }}"
                                data-fancybox="gallery" data-caption=" ">
                                <img src="{{ URL::asset('assets/template/images/gallery/balamguri_cstc/img5.jpg') }}"
                                    alt="" width="100%" />
                            </a>
                        </div>
                    </div>
                    <div class="column Ballamguri">
                        <div class="content">
                            <a href="{{ URL::asset('assets/template/images/gallery/balamguri_cstc/img6.jpg') }}"
                                data-fancybox="gallery" data-caption=" ">
                                <img src="{{ URL::asset('assets/template/images/gallery/balamguri_cstc/img6.jpg') }}"
                                    alt="" width="100%" />
                            </a>
                        </div>
                    </div>
                    <div class="column Ballamguri">
                        <div class="content">
                            <a href="{{ URL::asset('assets/template/images/gallery/balamguri_cstc/img7.jpg') }}"
                                data-fancybox="gallery" data-caption=" ">
                                <img src="{{ URL::asset('assets/template/images/gallery/balamguri_cstc/img7.jpg') }}"
                                    alt="" width="100%" />
                            </a>
                        </div>
                    </div>
                    <div class="column Ballamguri">
                        <div class="content">
                            <a href="{{ URL::asset('assets/template/images/gallery/balamguri_cstc/img8.jpg') }}"
                                data-fancybox="gallery" data-caption=" ">
                                <img src="{{ URL::asset('assets/template/images/gallery/balamguri_cstc/img8.jpg') }}"
                                    alt="" width="100%" />
                            </a>
                        </div>
                    </div>
                    <div class="column Ballamguri">
                        <div class="content">
                            <a href="{{ URL::asset('assets/template/images/gallery/balamguri_cstc/img9.jpg') }}"
                                data-fancybox="gallery" data-caption=" ">
                                <img src="{{ URL::asset('assets/template/images/gallery/balamguri_cstc/img9.jpg') }}"
                                    alt="" width="100%" />
                            </a>
                        </div>
                    </div>
                    <div class="column Ballamguri">
                        <div class="content">
                            <a href="{{ URL::asset('assets/template/images/gallery/balamguri_cstc/img10.jpg') }}"
                                data-fancybox="gallery" data-caption=" ">
                                <img src="{{ URL::asset('assets/template/images/gallery/balamguri_cstc/img10.jpg') }}"
                                    alt="" width="100%" />
                            </a>
                        </div>
                    </div>
                    <div class="column Ballamguri">
                        <div class="content">
                            <a href="{{ URL::asset('assets/template/images/gallery/balamguri_cstc/img11.jpg') }}"
                                data-fancybox="gallery" data-caption=" ">
                                <img src="{{ URL::asset('assets/template/images/gallery/balamguri_cstc/img11.jpg') }}"
                                    alt="" width="100%" />
                            </a>
                        </div>
                    </div>

                    <!-- Ceremonial Photos -->
                    <div class="column Ceremonial">
                        <div class="content">
                            <a href="{{ URL::asset('assets/template/images/gallery/ceremonial_distribution/img1.jpeg') }}"
                                data-fancybox="gallery" data-caption=" ">
                                <img src="{{ URL::asset('assets/template/images/gallery/ceremonial_distribution/img1.jpeg') }}"
                                    alt="" />
                            </a>
                        </div>
                    </div>
                    <div class="column Ceremonial">
                        <div class="content">
                            <a href="{{ URL::asset('assets/template/images/gallery/ceremonial_distribution/img2.jpeg') }}"
                                data-fancybox="gallery" data-caption=" ">
                                <img src="{{ URL::asset('assets/template/images/gallery/ceremonial_distribution/img2.jpeg') }}"
                                    alt="" />
                            </a>
                        </div>
                    </div>
                    <div class="column Ceremonial">
                        <div class="content">
                            <a href="{{ URL::asset('assets/template/images/gallery/ceremonial_distribution/img3.jpeg') }}"
                                data-fancybox="gallery" data-caption=" ">
                                <img src="{{ URL::asset('assets/template/images/gallery/ceremonial_distribution/img3.jpeg') }}"
                                    alt="" />
                            </a>
                        </div>
                    </div>
                    <div class="column Ceremonial">
                        <div class="content">
                            <a href="{{ URL::asset('assets/template/images/gallery/ceremonial_distribution/img4.jpeg') }}"
                                data-fancybox="gallery" data-caption=" ">
                                <img src="{{ URL::asset('assets/template/images/gallery/ceremonial_distribution/img4.jpeg') }}"
                                    alt="" />
                            </a>
                        </div>
                    </div>
                    <div class="column Ceremonial">
                        <div class="content">
                            <a href="{{ URL::asset('assets/template/images/gallery/ceremonial_distribution/img5.jpeg') }}"
                                data-fancybox="gallery" data-caption=" ">
                                <img src="{{ URL::asset('assets/template/images/gallery/ceremonial_distribution/img5.jpeg') }}"
                                    alt="" />
                            </a>
                        </div>
                    </div>
                    <div class="column Ceremonial">
                        <div class="content">
                            <a href="{{ URL::asset('assets/template/images/gallery/ceremonial_distribution/img6.jpeg') }}"
                                data-fancybox="gallery" data-caption=" ">
                                <img src="{{ URL::asset('assets/template/images/gallery/ceremonial_distribution/img6.jpeg') }}"
                                    alt="" />
                            </a>
                        </div>
                    </div>
                    <div class="column Ceremonial">
                        <div class="content">
                            <a href="{{ URL::asset('assets/template/images/gallery/ceremonial_distribution/img7.jpeg') }}"
                                data-fancybox="gallery" data-caption=" ">
                                <img src="{{ URL::asset('assets/template/images/gallery/ceremonial_distribution/img7.jpeg') }}"
                                    alt="" />
                            </a>
                        </div>
                    </div>
                    <div class="column Ceremonial">
                        <div class="content">
                            <a href="{{ URL::asset('assets/template/images/gallery/ceremonial_distribution/img8.jpeg') }}"
                                data-fancybox="gallery" data-caption=" ">
                                <img src="{{ URL::asset('assets/template/images/gallery/ceremonial_distribution/img8.jpeg') }}"
                                    alt="" />
                            </a>
                        </div>
                    </div>
                    <div class="column Ceremonial">
                        <div class="content">
                            <a href="{{ URL::asset('assets/template/images/gallery/ceremonial_distribution/img9.jpeg') }}"
                                data-fancybox="gallery" data-caption=" ">
                                <img src="{{ URL::asset('assets/template/images/gallery/ceremonial_distribution/img9.jpeg') }}"
                                    alt="" />
                            </a>
                        </div>
                    </div>
                    <div class="column Ceremonial">
                        <div class="content">
                            <a href="{{ URL::asset('assets/template/images/gallery/ceremonial_distribution/img10.jpg') }}"
                                data-fancybox="gallery" data-caption=" ">
                                <img src="{{ URL::asset('assets/template/images/gallery/ceremonial_distribution/img10.jpg') }}"
                                    alt="" />
                            </a>
                        </div>
                    </div>
                    <div class="column Ceremonial">
                        <div class="content">
                            <a href="{{ URL::asset('assets/template/images/gallery/ceremonial_distribution/img11.jpg') }}"
                                data-fancybox="gallery" data-caption=" ">
                                <img src="{{ URL::asset('assets/template/images/gallery/ceremonial_distribution/img11.jpg') }}"
                                    alt="" />
                            </a>
                        </div>
                    </div>
                    <div class="column Ceremonial">
                        <div class="content">
                            <a href="{{ URL::asset('assets/template/images/gallery/ceremonial_distribution/img12.jpg') }}"
                                data-fancybox="gallery" data-caption=" ">
                                <img src="{{ URL::asset('assets/template/images/gallery/ceremonial_distribution/img12.jpg') }}"
                                    alt="" />
                            </a>
                        </div>
                    </div>
                    <div class="column Ceremonial">
                        <div class="content">
                            <a href="{{ URL::asset('assets/template/images/gallery/ceremonial_distribution/img13.jpg') }}"
                                data-fancybox="gallery" data-caption=" ">
                                <img src="{{ URL::asset('assets/template/images/gallery/ceremonial_distribution/img13.jpg') }}"
                                    alt="" />
                            </a>
                        </div>
                    </div>
                    <div class="column Ceremonial">
                        <div class="content">
                            <a href="{{ URL::asset('assets/template/images/gallery/ceremonial_distribution/img14.jpg') }}"
                                data-fancybox="gallery" data-caption=" ">
                                <img src="{{ URL::asset('assets/template/images/gallery/ceremonial_distribution/img14.jpg') }}"
                                    alt="" />
                            </a>
                        </div>
                    </div>
                    <div class="column Ceremonial">
                        <div class="content">
                            <a href="{{ URL::asset('assets/template/images/gallery/ceremonial_distribution/img15.jpg') }}"
                                data-fancybox="gallery" data-caption=" ">
                                <img src="{{ URL::asset('assets/template/images/gallery/ceremonial_distribution/img15.jpg') }}"
                                    alt="" />
                            </a>
                        </div>
                    </div>
                    <div class="column Ceremonial">
                        <div class="content">
                            <a href="{{ URL::asset('assets/template/images/gallery/ceremonial_distribution/img16.jpg') }}"
                                data-fancybox="gallery" data-caption=" ">
                                <img src="{{ URL::asset('assets/template/images/gallery/ceremonial_distribution/img16.jpg') }}"
                                    alt="" />
                            </a>
                        </div>
                    </div>
                    <div class="column Ceremonial">
                        <div class="content">
                            <a href="{{ URL::asset('assets/template/images/gallery/ceremonial_distribution/img17.jpg') }}"
                                data-fancybox="gallery" data-caption=" ">
                                <img src="{{ URL::asset('assets/template/images/gallery/ceremonial_distribution/img17.jpg') }}"
                                    alt="" />
                            </a>
                        </div>
                    </div>
                    <div class="column Ceremonial">
                        <div class="content">
                            <a href="{{ URL::asset('assets/template/images/gallery/ceremonial_distribution/img19.jpg') }}"
                                data-fancybox="gallery" data-caption=" ">
                                <img src="{{ URL::asset('assets/template/images/gallery/ceremonial_distribution/img19.jpg') }}"
                                    alt="" />
                            </a>
                        </div>
                    </div>
                    <div class="column Ceremonial">
                        <div class="content">
                            <a href="{{ URL::asset('assets/template/images/gallery/ceremonial_distribution/img20.jpg') }}"
                                data-fancybox="gallery" data-caption=" ">
                                <img src="{{ URL::asset('assets/template/images/gallery/ceremonial_distribution/img20.jpg') }}"
                                    alt="" />
                            </a>
                        </div>
                    </div>
                    <div class="column Ceremonial">
                        <div class="content">
                            <a href="{{ URL::asset('assets/template/images/gallery/ceremonial_distribution/img21.jpg') }}"
                                data-fancybox="gallery" data-caption=" ">
                                <img src="{{ URL::asset('assets/template/images/gallery/ceremonial_distribution/img21.jpg') }}"
                                    alt="" />
                            </a>
                        </div>
                    </div>
                    <div class="column Ceremonial">
                        <div class="content">
                            <a href="{{ URL::asset('assets/template/images/gallery/ceremonial_distribution/img22.jpg') }}"
                                data-fancybox="gallery" data-caption=" ">
                                <img src="{{ URL::asset('assets/template/images/gallery/ceremonial_distribution/img22.jpg') }}"
                                    alt="" />
                            </a>
                        </div>
                    </div>
                    <div class="column Ceremonial">
                        <div class="content">
                            <a href="{{ URL::asset('assets/template/images/gallery/ceremonial_distribution/img23.jpg') }}"
                                data-fancybox="gallery" data-caption=" ">
                                <img src="{{ URL::asset('assets/template/images/gallery/ceremonial_distribution/img23.jpg') }}"
                                    alt="" />
                            </a>
                        </div>
                    </div>
                    <div class="column Ceremonial">
                        <div class="content">
                            <a href="{{ URL::asset('assets/template/images/gallery/ceremonial_distribution/img24.jpg') }}"
                                data-fancybox="gallery" data-caption=" ">
                                <img src="{{ URL::asset('assets/template/images/gallery/ceremonial_distribution/img24.jpg') }}"
                                    alt="" />
                            </a>
                        </div>
                    </div>
                    <div class="column Ceremonial">
                        <div class="content">
                            <a href="{{ URL::asset('assets/template/images/gallery/ceremonial_distribution/img25.jpg') }}"
                                data-fancybox="gallery" data-caption=" ">
                                <img src="{{ URL::asset('assets/template/images/gallery/ceremonial_distribution/img25.jpg') }}"
                                    alt="" />
                            </a>
                        </div>
                    </div>


                    <!-- Gogamukh Photos -->
                    <div class="column Gogamukh">
                        <div class="content">
                            <a href="{{ URL::asset('assets/template/images/gallery/gogamukh/img1.jpg') }}"
                                data-fancybox="gallery" data-caption=" ">
                                <img src="{{ URL::asset('assets/template/images/gallery/gogamukh/img1.jpg') }}"
                                    alt="" />
                            </a>
                        </div>
                    </div>
                    <div class="column Gogamukh">
                        <div class="content">
                            <a href="{{ URL::asset('assets/template/images/gallery/gogamukh/img2.jpg') }}"
                                data-fancybox="gallery" data-caption=" ">
                                <img src="{{ URL::asset('assets/template/images/gallery/gogamukh/img2.jpg') }}"
                                    alt="" />
                            </a>
                        </div>
                    </div>
                    <div class="column Gogamukh">
                        <div class="content">
                            <a href="{{ URL::asset('assets/template/images/gallery/gogamukh/img3.jpg') }}"
                                data-fancybox="gallery" data-caption=" ">
                                <img src="{{ URL::asset('assets/template/images/gallery/gogamukh/img3.jpg') }}"
                                    alt="" />
                            </a>
                        </div>
                    </div>
                    <div class="column Gogamukh">
                        <div class="content">
                            <a href="{{ URL::asset('assets/template/images/gallery/gogamukh/img4.jpg') }}"
                                data-fancybox="gallery" data-caption=" ">
                                <img src="{{ URL::asset('assets/template/images/gallery/gogamukh/img4.jpg') }}"
                                    alt="" />
                            </a>
                        </div>
                    </div>

                    <!-- Shramik Divas Photos -->
                    <div class="column Shramik">
                        <div class="content">
                            <a href="{{ URL::asset('assets/template/images/gallery/shramik_kalyan_divas/img1.jpg') }}"
                                data-fancybox="gallery" data-caption=" ">
                                <img src="{{ URL::asset('assets/template/images/gallery/shramik_kalyan_divas/img1.jpg') }}"
                                    alt="" />
                            </a>
                        </div>
                    </div>
                    <div class="column Shramik">
                        <div class="content">
                            <a href="{{ URL::asset('assets/template/images/gallery/shramik_kalyan_divas/img2.jpg') }}"
                                data-fancybox="gallery" data-caption=" ">
                                <img src="{{ URL::asset('assets/template/images/gallery/shramik_kalyan_divas/img2.jpg') }}"
                                    alt="" />
                            </a>
                        </div>
                    </div>
                    <div class="column Shramik">
                        <div class="content">
                            <a href="{{ URL::asset('assets/template/images/gallery/shramik_kalyan_divas/img3.jpg') }}"
                                data-fancybox="gallery" data-caption=" ">
                                <img src="{{ URL::asset('assets/template/images/gallery/shramik_kalyan_divas/img3.jpg') }}"
                                    alt="" />
                            </a>
                        </div>
                    </div>
                    <div class="column Shramik">
                        <div class="content">
                            <a href="{{ URL::asset('assets/template/images/gallery/shramik_kalyan_divas/img4.jpg') }}"
                                data-fancybox="gallery" data-caption=" ">
                                <img src="{{ URL::asset('assets/template/images/gallery/shramik_kalyan_divas/img4.jpg') }}"
                                    alt="" />
                            </a>
                        </div>
                    </div>
                    <div class="column Shramik">
                        <div class="content">
                            <a href="{{ URL::asset('assets/template/images/gallery/shramik_kalyan_divas/img5.jpg') }}"
                                data-fancybox="gallery" data-caption=" ">
                                <img src="{{ URL::asset('assets/template/images/gallery/shramik_kalyan_divas/img5.jpg') }}"
                                    alt="" />
                            </a>
                        </div>
                    </div>
                    <div class="column Shramik">
                        <div class="content">
                            <a href="{{ URL::asset('assets/template/images/gallery/shramik_kalyan_divas/img6.jpg') }}"
                                data-fancybox="gallery" data-caption=" ">
                                <img src="{{ URL::asset('assets/template/images/gallery/shramik_kalyan_divas/img6.jpg') }}"
                                    alt="" />
                            </a>
                        </div>
                    </div>
                    <div class="column Shramik">
                        <div class="content">
                            <a href="{{ URL::asset('assets/template/images/gallery/shramik_kalyan_divas/img7.jpg') }}"
                                data-fancybox="gallery" data-caption=" ">
                                <img src="{{ URL::asset('assets/template/images/gallery/shramik_kalyan_divas/img7.jpg') }}"
                                    alt="" />
                            </a>
                        </div>
                    </div>
                    <div class="column Shramik">
                        <div class="content">
                            <a href="{{ URL::asset('assets/template/images/gallery/shramik_kalyan_divas/img8.jpg') }}"
                                data-fancybox="gallery" data-caption=" ">
                                <img src="{{ URL::asset('assets/template/images/gallery/shramik_kalyan_divas/img8.jpg') }}"
                                    alt="" />
                            </a>
                        </div>
                    </div>
                    <div class="column Shramik">
                        <div class="content">
                            <a href="{{ URL::asset('assets/template/images/gallery/shramik_kalyan_divas/img9.jpg') }}"
                                data-fancybox="gallery" data-caption=" ">
                                <img src="{{ URL::asset('assets/template/images/gallery/shramik_kalyan_divas/img9.jpg') }}"
                                    alt="" />
                            </a>
                        </div>
                    </div>
                    <div class="column Shramik">
                        <div class="content">
                            <a href="{{ URL::asset('assets/template/images/gallery/shramik_kalyan_divas/img10.jpg') }}"
                                data-fancybox="gallery" data-caption=" ">
                                <img src="{{ URL::asset('assets/template/images/gallery/shramik_kalyan_divas/img10.jpg') }}"
                                    alt="" />
                            </a>
                        </div>
                    </div>
                    <div class="column Shramik">
                        <div class="content">
                            <a href="{{ URL::asset('assets/template/images/gallery/shramik_kalyan_divas/img11.jpg') }}"
                                data-fancybox="gallery" data-caption=" ">
                                <img src="{{ URL::asset('assets/template/images/gallery/shramik_kalyan_divas/img11.jpg') }}"
                                    alt="" />
                            </a>
                        </div>
                    </div>
                    <div class="column Shramik">
                        <div class="content">
                            <a href="{{ URL::asset('assets/template/images/gallery/shramik_kalyan_divas/img12.jpg') }}"
                                data-fancybox="gallery" data-caption=" ">
                                <img src="{{ URL::asset('assets/template/images/gallery/shramik_kalyan_divas/img12.jpg') }}"
                                    alt="" />
                            </a>
                        </div>
                    </div>
                    <div class="column Shramik">
                        <div class="content">
                            <a href="{{ URL::asset('assets/template/images/gallery/shramik_kalyan_divas/img13.jpg') }}"
                                data-fancybox="gallery" data-caption=" ">
                                <img src="{{ URL::asset('assets/template/images/gallery/shramik_kalyan_divas/img13.jpg') }}"
                                    alt="" />
                            </a>
                        </div>
                    </div>

                    {{-- Transit Shelter photos --}}

                    <div class="column Transit">
                        <div class="content">
                            <a href="{{ URL::asset('assets/template/images/gallery/Transit/img1.jpg') }}"
                                data-fancybox="gallery" data-caption=" ">
                                <img src="{{ URL::asset('assets/template/images/gallery/Transit/img1.jpg') }}"
                                    alt="" />
                            </a>
                        </div>
                    </div>
                    <div class="column Transit">
                        <div class="content">
                            <a href="{{ URL::asset('assets/template/images/gallery/Transit/img2.jpg') }}"
                                data-fancybox="gallery" data-caption=" ">
                                <img src="{{ URL::asset('assets/template/images/gallery/Transit/img2.jpg') }}"
                                    alt="" />
                            </a>
                        </div>
                    </div>
                    <div class="column Transit">
                        <div class="content">
                            <a href="{{ URL::asset('assets/template/images/gallery/Transit/img3.jpg') }}"
                                data-fancybox="gallery" data-caption=" ">
                                <img src="{{ URL::asset('assets/template/images/gallery/Transit/img3.jpg') }}"
                                    alt="" />
                            </a>
                        </div>
                    </div>
                    <div class="column Transit">
                        <div class="content">
                            <a href="{{ URL::asset('assets/template/images/gallery/Transit/img4.jpg') }}"
                                data-fancybox="gallery" data-caption=" ">
                                <img src="{{ URL::asset('assets/template/images/gallery/Transit/img4.jpg') }}"
                                    alt="" />
                            </a>
                        </div>
                    </div>
                    <div class="column Transit">
                        <div class="content">
                            <a href="{{ URL::asset('assets/template/images/gallery/Transit/img5.jpg') }}"
                                data-fancybox="gallery" data-caption=" ">
                                <img src="{{ URL::asset('assets/template/images/gallery/Transit/img5.jpg') }}"
                                    alt="" />
                            </a>
                        </div>
                    </div>
                    <div class="column Transit">
                        <div class="content">
                            <a href="{{ URL::asset('assets/template/images/gallery/Transit/img6.jpg') }}"
                                data-fancybox="gallery" data-caption=" ">
                                <img src="{{ URL::asset('assets/template/images/gallery/Transit/img6.jpg') }}"
                                    alt="" />
                            </a>
                        </div>
                    </div>
                    <div class="column Transit">
                        <div class="content">
                            <a href="{{ URL::asset('assets/template/images/gallery/Transit/img7.jpg') }}"
                                data-fancybox="gallery" data-caption=" ">
                                <img src="{{ URL::asset('assets/template/images/gallery/Transit/img7.jpg') }}"
                                    alt="" />
                            </a>
                        </div>
                    </div>
                    <div class="column Transit">
                        <div class="content">
                            <a href="{{ URL::asset('assets/template/images/gallery/Transit/img8.jpg') }}"
                                data-fancybox="gallery" data-caption=" ">
                                <img src="{{ URL::asset('assets/template/images/gallery/Transit/img8.jpg') }}"
                                    alt="" />
                            </a>
                        </div>
                    </div>
                    <div class="column Transit">
                        <div class="content">
                            <a href="{{ URL::asset('assets/template/images/gallery/Transit/img9.jpg') }}"
                                data-fancybox="gallery" data-caption=" ">
                                <img src="{{ URL::asset('assets/template/images/gallery/Transit/img9.jpg') }}"
                                    alt="" />
                            </a>
                        </div>
                    </div>
                    <div class="column Transit">
                        <div class="content">
                            <a href="{{ URL::asset('assets/template/images/gallery/Transit/img10.jpg') }}"
                                data-fancybox="gallery" data-caption=" ">
                                <img src="{{ URL::asset('assets/template/images/gallery/Transit/img10.jpg') }}"
                                    alt="" />
                            </a>
                        </div>
                    </div>
                    <div class="column Transit">
                        <div class="content">
                            <a href="{{ URL::asset('assets/template/images/gallery/Transit/img11.jpg') }}"
                                data-fancybox="gallery" data-caption=" ">
                                <img src="{{ URL::asset('assets/template/images/gallery/Transit/img11.jpg') }}"
                                    alt="" />
                            </a>
                        </div>
                    </div>
                    <div class="column Transit">
                        <div class="content">
                            <a href="{{ URL::asset('assets/template/images/gallery/Transit/img12.jpg') }}"
                                data-fancybox="gallery" data-caption=" ">
                                <img src="{{ URL::asset('assets/template/images/gallery/Transit/img12.jpg') }}"
                                    alt="" />
                            </a>
                        </div>
                    </div>




<div class="row" style="margin-top: 10%;">
                     <div class="column Rollout_CSC">
                        <div class="content">
                            <p>ROLL OUT of CSC for Nirman Sakhi Portal (Assamese)</p>
                            <div class="embed-responsive embed-responsive-16by9">
                                <video class="embed-responsive-item" controls preload="auto" width="100%">
                                    <source src="/assets/template/video/csc_assamese.mp4" type="video/mp4">
                                    Your browser does not support the video tag.
                                </video>
                            </div>
                        </div>
                    </div>
                     <div class="column Rollout_CSC">
                        <div class="content">
                           <p>ROLL OUT of CSC for Nirman Sakhi Portal (English)</p>
                            <div class="embed-responsive embed-responsive-16by9">
                                <video class="embed-responsive-item" controls preload="auto" width="100%">
                                    <source src="/assets/template/video/csc_english.mp4" type="video/mp4">
                                    Your browser does not support the video tag.
                                </video>
                            </div>
                        </div>
                    </div>
                    </div>
                    {{-- <div class="row mt-5">
                        <!-- Assamese Video -->
                        <div class="col-md-5 ml-5  Rollout_CSC">
                            <p>ROLL OUT of CSC for Nirman Sakhi Portal (Assamese)</p>
                            <div class="embed-responsive embed-responsive-16by9">
                                <video class="embed-responsive-item" controls preload="auto" width="100%">
                                    <source src="/assets/template/video/csc_assamese.mp4" type="video/mp4">
                                    Your browser does not support the video tag.
                                </video>
                            </div>
                        </div>

                        <!-- English Video -->
                        <div class="col-md-5 ml-5 Rollout_CSC">
                            <p>ROLL OUT of CSC for Nirman Sakhi Portal (English)</p>
                            <div class="embed-responsive embed-responsive-16by9">
                                <video class="embed-responsive-item" controls preload="auto" width="100%">
                                    <source src="/assets/template/video/csc_english.mp4" type="video/mp4">
                                    Your browser does not support the video tag.
                                </video>
                            </div>
                        </div>
                    </div> --}}





                </div>



    </section>

@endsection


@section('footer')

    <script>
        filterSelection("Shramik")

        function filterSelection(c) {
            var x, i;
            x = document.getElementsByClassName("column");
            if (c == "all") c = "";
            for (i = 0; i < x.length; i++) {
                w3RemoveClass(x[i], "show");
                if (x[i].className.indexOf(c) > -1) w3AddClass(x[i], "show");
            }
        }

        function w3AddClass(element, name) {
            var i, arr1, arr2;
            arr1 = element.className.split(" ");
            arr2 = name.split(" ");
            for (i = 0; i < arr2.length; i++) {
                if (arr1.indexOf(arr2[i]) == -1) {
                    element.className += " " + arr2[i];
                }
            }
        }

        function w3RemoveClass(element, name) {
            var i, arr1, arr2;
            arr1 = element.className.split(" ");
            arr2 = name.split(" ");
            for (i = 0; i < arr2.length; i++) {
                while (arr1.indexOf(arr2[i]) > -1) {
                    arr1.splice(arr1.indexOf(arr2[i]), 1);
                }
            }
            element.className = arr1.join(" ");
        }


        // Add active class to the current button (highlight it)
        // Add active class to the current button (highlight it)
        var btnContainer = document.getElementById("myBtnContainer");
        var btns = btnContainer.getElementsByClassName("mybtn");

        for (var i = 0; i < btns.length; i++) {
            btns[i].addEventListener("click", function() {
                var current = document.querySelector(".mybtn.active"); // Select current active button
                if (current) {
                    current.classList.remove("active"); // Remove 'active' class from current
                }
                this.classList.add("active"); // Add 'active' class to clicked button
            });
        }

        var share = document.querySelector('[title="Share"]');
        share.style.display = "none";
    </script>
    <!-- Video.js JS -->
    <script src="https://vjs.zencdn.net/7.21.1/video.min.js"></script>
    <!-- Optional: Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // Force full video load for forward/backward scrubbing
        function preloadVideo(playerId) {
            const player = videojs(playerId);
            player.on('loadedmetadata', function() {
                player.on('loadeddata', function() {
                    console.log(playerId + ' fully loaded.');
                });
            });
        }

        preloadVideo('videoAssamese');
        preloadVideo('videoEnglish');
    </script>


    <script src="{{ URL::asset('assets/template/vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ URL::asset('assets/template/js/fancybox.js') }}"></script>








@endsection
