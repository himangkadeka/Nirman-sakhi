@extends('layouts.user-app')

@section('title', ' SOP & GUIDELINES 1')
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

        {{-- pdf download --}}


        <div class="d-flex justify-content-center">
            <a href="{{ route('download', 'userguidelines_onboarding.pdf') }}">
                <button class="btn download btn-sm">
                    <i class="fa fa-download" style="color:white" aria-hidden="true"></i>
                    <span style="color:white;">Download</span>
                </button>
            </a>
        </div>


        {{-- pdf download --}}
        {{-- <h3 style="text-align: center;">Eligibility for onboarding with ABOCWWB online portal (Nirman Sakhi):</h3> --}}

        <div class=" mt-4 " style="text-align: justify;">
            <p>{{ trans('index.sop1body') }} <a href="https://www.abocwwb.assam.gov.in/" target="_blank"
                    class="text-primary">(www.abocwwb.assam.gov.in)</a></p>
            <p class="">
                <strong>{{ trans('sop1.head1') }} </strong>

                </a>
            </p>
            <ul class="my-2">
                <li> {{ trans('sop1.head1point') }}</li>
            </ul>
            <p class="">
                <strong>{{ trans('sop1.head2') }}</strong>
            </p>
            <ul class="my-2">
                {!! __('sop1.head2point') !!}
                {!! __('sop1.head2point2') !!}
                {!! __('sop1.head2point3') !!}
                {!! __('sop1.head2point4') !!}
            </ul>

            <p class="">
                {!! __('sop1.head3') !!}
            </p>

            <p class="">
                <strong>{{ trans('sop1.head4') }}</strong>
            </p>

            <ul class="my-2">
                <li>{{ trans('sop1.head4point1') }}</li>
                <li>{{ trans('sop1.head4point2') }}</li>
                <li>{{ trans('sop1.head4point3') }}</li>
                <li>{{ trans('sop1.head4point4') }}</li>
                <li>{{ trans('sop1.head4point5') }}</li>
            </ul>

            <p class="">
                <strong>{{ trans('sop1.head5') }}</strong>
            </p>

            <ul class="my-2">
                <li>{{ trans('sop1.head5point1') }}</li>
                <li>
                    {{ trans('sop1.head5point2') }}
                </li>
                <li>{{ trans('sop1.head5point3') }}</li>
                <li>{{ trans('sop1.head5point4') }}</li>
            </ul>

            <p class="">
                <strong>{{ trans('sop1.head6') }}</strong>
            </p>
            <p>{{ trans('sop1.head6point') }}</p>
            <p class="">
                <strong>{{ trans('sop1.head7') }}</strong>
            </p>
            <div class="d-flex justify-content-center ">
                <table class="table table-striped table-bordered text-sm-center ">
                    <thead>
                        <tr>
                            <th scope="col">Sno.</th>
                            <th scope="col">{{ trans('sop1.head7th1') }}</th>
                            <th scope="col">{{ trans('sop1.head7th2') }}</th>

                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <th scope="row">1</th>
                            <td>{{ trans('sop1.head7td1') }}</td>
                            <td>{{ trans('sop1.head7td1') }}</td>

                        </tr>
                        <tr>
                            <th scope="row">2</th>
                            <td>{{ trans('sop1.head7td21') }}</td>
                            <td>{{ trans('sop1.head7td22') }}</td>

                        </tr>

                        <tr>
                            <th scope="row">3</th>
                            <td>{{ trans('sop1.head7td31') }}</td>
                            <td>{{ trans('sop1.head7td32') }}</td>

                        </tr>
                        <tr>
                            <th scope="row">4</th>
                            <td>{{ trans('sop1.head7td41') }}</td>
                            <td>{{ trans('sop1.head7td42') }}</td>

                        </tr>

                    </tbody>
                </table>
            </div>
            <p class="">
                <strong>{{ trans('sop1.head8') }}:</strong>
            </p>
            <ol class="my-2">
                {!! __('sop1.head8point1') !!}
                {!! __('sop1.head8point2') !!}
                {!! __('sop1.head8point3') !!}
                {!! __('sop1.head8point4') !!}
                {!! __('sop1.head8point5') !!}
                <li> {{ trans('sop1.head8point6') }}</li>
                <li>
                    {{ trans('sop1.head8point7') }}
                </li>
                <li>{{ trans('sop1.head8point8') }}</li>
                <li>{{ trans('sop1.head8point9') }}</li>
                <li>{{ trans('sop1.head8point10') }}</li>
                <li>
                    {{ trans('sop1.head8point11') }}
                </li>
                <li>{{ trans('sop1.head8point12') }}</li>
                <li>{{ trans('sop1.head8point13') }}</li>
                <li>{{ trans('sop1.head8point14') }}</li>
                <li>{{ trans('sop1.head8point15') }}</li>
                <li>{{ trans('sop1.head8point16') }}</li>
                <li>{{ trans('sop1.head8point17') }}</li>
            </ol>
            <p class="">
                <strong>{{ trans('sop1.note') }}:</strong>
            </p>
            <p>
                {{ trans('sop1.notetext1') }} (<a href=" https://www.abocwwb.assam.gov.in/" class="text-primary">
                    www.abocwwb.assam.gov.in</a>)
                {{ trans('sop1.notetext2') }}
            </p>
        </div>

    </div>



@endsection


@section('footer')

@endsection


<!-- About Container -->
