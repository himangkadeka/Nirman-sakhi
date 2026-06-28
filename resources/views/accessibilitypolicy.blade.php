@extends('layouts.user-app')

@section('title', ' Accessibility Policy')
@section('style')



@endsection


@section('content')
    <div class="container mt-3" id="b-homedb">

        <h3 style="text-align: center;">{{ trans('accessibilitypolicy.accessibilitypolicy') }}</h3>

        <div class=" mt-4 " style="text-align: justify;"> {!! __('accessibilitypolicy.accessibilitypolicybody')!!}

        </div>

    </div>



@endsection


@section('footer')

@endsection


<!-- About Container -->
