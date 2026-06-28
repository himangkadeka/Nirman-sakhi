@extends('layouts.user-app')

@section('title', ' About Us | Aims & Objectives')



@section('style')
    <link rel="stylesheet" href="{{ URL::asset('assets/template/css/aimsandobjectives.css') }}" />

@endsection


@section('content')
    <div class="container">
        <div class="heading mt-3">
            <h2>
                {{ trans('aimsandobjectives.head') }}</h2>
            <div class="centerHeading"></div>


        </div>
    </div>

    </div>
    </div>
    </div>
    </div>
    <section class="container" id="b-homedb">

        <div class="container mt-4 ">
            <p class="aimsandobjectives-body" style="font-family:'Roboto',Sans-Serif; font-size:16px;">
                {{ trans('aimsandobjectives.the') }} <strong>{{ trans('aimsandobjectives.BOCWActs') }}</strong>
                {{ trans('aimsandobjectives.pxtsp') }}:
                " {{ trans('aimsandobjectives.act..') }}"
                <strong>ABOCWW {{ trans('aimsandobjectives.Board') }}</strong> {{ trans('aimsandobjectives.afterabocww') }}
                <strong>
                    {{ trans('aimsandobjectives.section22') }} </strong> {{ trans('aimsandobjectives.ofthe') }}
                <strong>{{ trans('aimsandobjectives.bocwact') }}</strong>{{ trans('aimsandobjectives.awtd') }}
            </p>
        </div>
    </section>

    <div class="container mt-5">
        <div class="row no-gutters">
            {{-- <div class="col-md-1 ml-0"></div> --}}

            <div class="col-sm-7 ml-5 aimsandobjectives">
                <div style="font-weight: bold;">{{ trans('aimsandobjectives.objectives') }}:</div>
                <div class="mb-2 mt-2" style="font-family:'Roboto',Sans-Serif; font-size:16px;"><i
                        class="fas fa-caret-right" style="color: teal;"></i>
                    {{ trans('aimsandobjectives.objectives1') }}
                </div>

                <div class="mb-2" style="font-family:'Roboto',Sans-Serif; font-size:16px;"><i class="fas fa-caret-right"
                        style="color: teal;"></i>
                    {{ trans('aimsandobjectives.objectives2') }}
                </div>

                <div class="mb-2" style="font-family:'Roboto',Sans-Serif; font-size:16px;"><i class="fas fa-caret-right"
                        style="color: teal;"></i>
                    {{ trans('aimsandobjectives.objectives3') }}
                </div>

                <div class="mb-2" style="font-family:'Roboto',Sans-Serif; font-size:16px;"><i class="fas fa-caret-right"
                        style="color: teal;"></i>
                    {{ trans('aimsandobjectives.objectives4.1') }}<br>
                    <div style="margin-left:10px;">{{ trans('aimsandobjectives.objectives4.2') }}</div>
                </div>

                <div class="mb-2" style="font-family:'Roboto',Sans-Serif; font-size:16px;"><i class="fas fa-caret-right"
                        style="color: teal;"></i>
                    {{ trans('aimsandobjectives.objectives5') }}
                </div>

                <div class="mb-2" style="font-family:'Roboto',Sans-Serif; font-size:16px;"><i class="fas fa-caret-right"
                        style="color: teal;"></i>
                    {{ trans('aimsandobjectives.objectives6') }}
                </div>

                <div class="mb-2" style="font-family:'Roboto',Sans-Serif; font-size:16px;"><i class="fas fa-caret-right"
                        style="color: teal;"></i>
                    {{ trans('aimsandobjectives.objectives7.1') }}<br>
                    <div style="margin-left:10px;">{{ trans('aimsandobjectives.objectives7.2') }}</div>
                </div>
                <div style="font-family:'Roboto',Sans-Serif; font-size:16px;"><i class="fas fa-caret-right"
                        style="color: teal;"></i>
                    {{ trans('aimsandobjectives.objectives8') }}
                </div>
            </div>

            <div class="col-sm-4 model ">
                <img style="height: 450px" src="{{ asset('assets/template/images/aimsandobjectives/model_1.png') }}"
                    alt="Model Image">

            </div>


        </div>
    </div>
@endsection


@section('footer')

@endsection


<!-- About Container -->
