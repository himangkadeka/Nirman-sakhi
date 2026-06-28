@extends('layouts.user-app')

@section('title', ' SOP & GUIDELINES(Reviewing the Applications)')
@section('style')

<style>
    body {
        font-family: 'Roboto', Sans-Serif;
    }
    .download {
        background-color: #009cdb;
        !important;


    }
</style>

@endsection


@section('content')
    <div class="container mt-5" id="b-homedb">


        <div class="d-flex justify-content-center">
            <a href="{{ route('download', 'Instructions_for_Helpdesk.pdf') }}">
              <button class="btn download btn-sm">
                <i class="fa fa-download" style="color:white" aria-hidden="true"></i>
                <span style="color:white;">Download</span>
              </button>
            </a>
          </div>
        <div class=" mt-4 " style="text-align: justify;">

            <p class="" style="text-align: center;">
                <strong>{{ trans('sop7.head') }}</strong>
            </p>
            <ol class="">
                <li>{{ trans('sop7.point1') }}</li>
                <li>{{ trans('sop7.point2') }}</li>
                <li>{{ trans('sop7.point3') }}</li>
                <li>{{ trans('sop7.point4') }}</li>
                <li>{{ trans('sop7.point5') }}</li>
                <li>{{ trans('sop7.point6') }}</li>
                <li>{{ trans('sop7.point7') }}</li>
                <li>{{ trans('sop7.point8') }}</li>
                <li>{{ trans('sop7.point9') }}</li>
                <li>{{ trans('sop7.point10') }}</li>
                <li>{{ trans('sop7.point11') }}</li>
                <li>{{ trans('sop7.point121') }}
                    <a href="https://www.abocwwb.assam.gov.in" class="text-primary">(www.abocwwb.assm.gov.in)</a> {{ trans('sop7.point122') }}</li>
            </ol>




        </div>

    </div>



@endsection


@section('footer')

@endsection


<!-- About Container -->
