@extends('layouts.user-app')

@section('title', ' SOP & GUIDELINES 2')
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
    <div class="container mt-3" id="b-homedb">
        <div class="d-flex justify-content-center">
            <a href="{{ route('download', 'User_guidelines_for_Renewal_of_construction_workers.pdf') }}">
              <button class="btn download btn-sm">
                <i class="fa fa-download" style="color:white" aria-hidden="true"></i>
                <span style="color:white;">Download</span>
              </button>
            </a>
          </div>

        {{-- <h3 style="text-align: center;">Eligibility for onboarding with ABOCWWB online portal (Nirman Sakhi):</h3> --}}

        <div class=" mt-4 " style="text-align: justify;">
            <span>{{ trans('index.sop2body1') }}<a href="https://www.abocwwb.assam.gov.in/" target="_blank" class="text-primary"> (www.abocwwb.assam.gov.in). </a>{{ trans('index.sop2body2') }}</span>
            <p class="">
                <strong>{{ trans('sop2.head1') }}</strong>
            </p>
            <ul class="my-2">
                <li> {{ trans('sop2.head1point1') }}</li>
                <li>{{ trans('sop2.head1point2') }}</li>
                <li>{{ trans('sop2.head1point3') }}</li>
                <li>
                    {{ trans('sop2.head1point4') }}
                </li>
            </ul>


            <p class="">
                <strong>{{ trans('sop2.head2') }}</strong>
            </p>
            <ul class="my-2">
                {!! __('sop2.head2point1') !!}
                {{-- {!! __('sop2.head2point2') !!}

                {!! __('sop2.head2point3') !!} --}}
            </ul>

            <p class="">
                <strong>{{ trans('sop2.head3') }}</strong>
            </p>
            <p class="mx-5">{{ trans('sop2.head3text') }}</p>
            <p class="">
                <strong>{{ trans('sop2.head4') }}</strong>
            </p>

            <div class="d-flex justify-content-center ">
                <table class="table table-striped table-bordered text-sm-center ">
                    <thead>
                        <tr>
                            <th scope="col">Sno.</th>
                            <th scope="col">{{ trans('sop2.documents') }}</th>
                            <th scope="col">{{ trans('sop2.valid') }}</th>

                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <th scope="row">1</th>
                            <td>{{ trans('sop2.head4td1') }}</td>
                            <td>{{ trans('sop2.head4td2') }}</td>

                        </tr>



                    </tbody>
                </table>
            </div>
            <p class="">
                <strong>{{ trans('sop2.head5') }}</strong>
            </p>
            <ol class="my-2">
                {!! __('sop2.head5point1') !!}
                <li>{{ trans('sop2.head5point2') }}</li>
                <li>{{ trans('sop2.head5point3') }}</li>
                <li>{{ trans('sop2.head5point4') }}</li>
                <li>{{ trans('sop2.head5point5') }}</li>
                <li>{{ trans('sop2.head5point6') }}</li>
                <li>{{ trans('sop2.head5point7') }}</li>
                <li>{{ trans('sop2.head5point8') }}</li>
                <li>{{ trans('sop2.head5point9') }}</li>
                <li>{{ trans('sop2.head5point10') }}</li>
                <li>{{ trans('sop2.head5point11') }}</li>
                <li>{{ trans('sop2.head5point12') }}</li>
                <li>{{ trans('sop2.head5point13') }}</li>
                <li>{{ trans('sop2.head5point14') }}</li>
                <li>{{ trans('sop2.head5point15') }}</li>
                <li>{{ trans('sop2.head5point16') }}</li>
            </ol>
            <p class="">
                <strong>{{ trans('sop2.note') }}</strong>
            </p>
            <p>
                {{ trans('sop2.notetext1') }}(<a href=" https://www.abocwwb.assam.gov.in/"
                    class="text-primary">www.abocwwb.assam.gov.in</a>)
                {{ trans('sop2.notetext2') }}
            </p>

        </div>

    </div>



@endsection


@section('footer')

@endsection


<!-- About Container -->
