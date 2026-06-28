@extends('layouts.user-app')

@section('title', ' About Us | Organizations')

@section('style')

    <link rel="stylesheet" href="{{ URL::asset('assets/template/css/organizations.css') }}" />

@endsection


@section('content')

<!--start orgnisation-->
<section class="organogram">

    <div class="organogramImage">
        <img src="{{ URL::asset('assets/template/images/organogram.png') }}" alt="Organogram">
    </div>
<div class="pagination">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">About Us</a></li>
            <li class="breadcrumb-item active" aria-current="page">Organogram</li>
        </ol>
    </nav>
</div>

  <div class="organogramBox">
    <div class="heading" style="margin-right: 350px;">
        <h2>{{ trans('organizations.head') }}</h2>
        <div class="centerHeading"></div>
    </div>
    <div class="orgnisationStructure">
        <div class="firstTire">
            <div class="child">
                <span>{{ trans('organizations.person1') }}</span>
            </div>
            <div class="child">
                <span style="line-height: 18px;">{{ trans('organizations.person2') }}</span>
            </div>
            <!-- <div class="child">
                <span>Principal Secretary</span>
            </div> -->
            <div class="child">
                <span>{{ trans('organizations.person3') }}</span>
            </div>
            <div class="liner"></div>
        </div>
        <div class="secondTire">
            <div class="child">
                <span>{{ trans('organizations.person4') }}</span>
            </div>
            <div class="child">
                <span>{{ trans('organizations.person5') }}</span>
            </div>
        </div>
        <div class="thirdTire">
            <div class="child">
                <span>{{ trans('organizations.person6') }}</span>
            </div>
            <div class="liner"></div>
            <div class="child">
                <span>{{ trans('organizations.person7') }}</span>
            </div>
            <div class="child" id="Project-Manager-Finance">
                <span>{{ trans('organizations.person8') }}</span>
            </div>
        </div>
        <div class="forthTire">
            <div class="child">
                <span>{{ trans('organizations.person9') }}</span>
            </div>
            <div class="child">
                <span>{{ trans('organizations.person10') }}</span>
            </div>
        </div>
        <div class="horizontal-line"></div>
        <div class="fiftTire">
            <div class="child">
                <span>{{ trans('organizations.person11') }}</span>
            </div>
            <div class="child">
                <span>{{ trans('organizations.person12') }}</span>
            </div>
        </div>
        <div class="freeBox1"></div>
        <div class="freeBox2"></div>
        <div class="freeBox3"></div>

        </div>
    </div>
  </div>
    </div>
</section>
<section class="organogramMobile">
    <img src="../assets/template/images/organogramImg.png" alt="" width="100%">
</section>
<!--end orgnisation-->



@endsection


@section('footer')

@endsection
