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
            <a href="{{ route('download', 'User_guidelines_for_Registration_of_construction_workers.pdf') }}">
                <button class="btn download btn-sm">
                    <i class="fa fa-download" style="color:white" aria-hidden="true"></i>
                    <span style="color:white;">Download</span>
                </button>
            </a>
        </div>
        {{-- <h3 style="text-align: center;">Eligibility for onboarding with ABOCWWB online portal (Nirman Sakhi):</h3> --}}

        <div class=" mt-4 " style="text-align: justify;">

            <p class="">
                <strong>{{ trans('sop3.head1') }}</strong>
            </p>
            <p class="">
                <strong>{{ trans('sop3.head2') }}</strong>
            </p>
            <ul class="my-2">
                <li> {{ trans('sop3.head2point1') }}</li>
                <li>{{ trans('sop3.head2point2') }}</li>
                <li>{{ trans('sop3.head2point3') }}</li>
                <li>{{ trans('sop3.head2point4') }}</li>

            </ul>
            <p class="">
                <strong>{{ trans('sop3.head3') }}</strong>
            </p>
            <ul class="my-2">
                <li>{{ trans('sop3.head3point1') }}</li>
                <li>{{ trans('sop3.head3point2') }}</li>
            </ul>
            <p>
                <strong>{{ trans('sop3.head4') }}</strong>
            </p>
            <p>
                <strong>{{ trans('sop3.head5') }}</strong>
            </p>
            <ul class="my-2">
                <li>{{ trans('sop3.head5point1') }}</li>
                <li>{{ trans('sop3.head5point2') }}</li>
                <li>{{ trans('sop3.head5point3') }}</li>
                <li>{{ trans('sop3.head5point4') }}</li>
            </ul>


            <p>
                <strong>{{ trans('sop3.head6') }}</strong>
            </p>
            <ul class="my-2">
                <li>{{ trans('sop3.head6point1') }}</li>
                <li>{{ trans('sop3.head6point2') }}</li>
                <li>{{ trans('sop3.head6point3') }}</li>
                <li>{{ trans('sop3.head6point4') }}</li>
                <li>{{ trans('sop3.head6point5') }}</li>
            </ul>

            <p>
                <strong>{{ trans('sop3.head7') }}</strong>
            </p>
            {!! __('sop3.head7text') !!}
            <p><strong>{{ trans('sop3.head8') }}</strong></p>
            <ul class="my-2">
                <li>{{ trans('sop3.head8point') }}</li>

            </ul>

            <p><strong>{{ trans('sop3.head9') }}</strong></p>
            <ul class="my-2">
                <li>{{ trans('sop3.head9point1') }}</li>
                <li>{{ trans('sop3.head9point2') }}</li>

            </ul>
            <p><strong>{{ trans('sop3.head10') }}</strong></p>
            <p>{{ trans('sop3.head10text') }} <a href="https://www.csdcindia.org/qualification-packs/)."
                    class="text-primary">www.csdcindia.org/qualification-packs</a>.
            </p>
           <strong> <p>{{ trans('sop3.supportdoc') }}</p></strong>

            <div class="d-flex justify-content-center ">

                <table class="table table-striped table-bordered text-sm-center ">
                    <thead>
                        <tr>
                            <th scope="col">Sno.</th>
                            <th scope="col">Document to be uploaded</th>
                            <th scope="col">Valid document</th>

                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <th scope="row">1</th>
                            <td>{{ trans('sop3.head10td11') }}</td>
                            <td>{{ trans('sop3.head10td12') }}</td>

                        </tr>
                        <tr>
                            <th scope="row">2</th>
                            <td>{{ trans('sop3.head10td21') }}</td>
                            <td>{{ trans('sop3.head10td22') }}</td>

                        </tr>

                        <tr>
                            <th scope="row">3</th>
                            <td>{{ trans('sop3.head10td31') }}</td>
                            <td>{{ trans('sop3.head10td321') }}<a href="http://www.abocwwb.assam.gov.in"
                                    class="text-primary">(www.abocwwb.assam.gov.in)</a>.{{ trans('sop3.head10td322') }}
                            </td>

                        </tr>
                        <tr>
                            <th scope="row">4</th>
                            <td>{{ trans('sop3.head10td41') }}</td>
                            <td>{{ trans('sop3.head10td42') }}</td>

                        </tr>

                    </tbody>
                </table>
            </div>
            <p class="">
                <strong>{{ trans('sop3.head11') }}</strong>
            </p>

            <ol class="my-2">
                <li>{{ trans('sop3.head11point1-1') }} <a href="https://www.abocwwb.assam.gov.in/"
                        class="text-primary">www.abocwwb.assam.gov.in</a>{{ trans('sop3.head11point1-2') }}</li>
                <li>{{ trans('sop3.head11point2') }}</li>
                <li>{{ trans('sop3.head11point3') }}</li>
                <li>{{ trans('sop3.head11point4') }}</li>
                <li>{{ trans('sop3.head11point5') }}</li>
                <li>{{ trans('sop3.head11point6') }}</li>
                <li>{{ trans('sop3.head11point7') }}</li>
                <li>{{ trans('sop3.head11point8') }}</li>
                <li>{{ trans('sop3.head11point9') }}</li>
                <li>{{ trans('sop3.head11point10') }}</li>
                <li>{{ trans('sop3.head11point11') }}</li>
                <li>{{ trans('sop3.head11point12') }}</li>
                <li>{{ trans('sop3.head11point13') }}</li>
                <li>{{ trans('sop3.head11point14') }}</li>
                <li>{{ trans('sop3.head11point15') }}</li>
                <li>{{ trans('sop3.head11point16') }}</li>
                <li>{{ trans('sop3.head11point17') }}</li>

            </ol>
            <p><strong>{{ trans('sop3.note') }}</strong></p>
            <p>{{ trans('sop3.notetext1') }} <a href="https://www.abocwwb.assam.gov.in/"
                    class="text-primary">(www.abocwwb.assam.gov.in)</a>
                {{ trans('sop3.notetext2') }}</p>

        </div>

    </div>



@endsection


@section('footer')

@endsection


<!-- About Container -->
