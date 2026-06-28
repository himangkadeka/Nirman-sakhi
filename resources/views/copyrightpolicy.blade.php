@extends('layouts.user-app')

@section('title', ' Copyright Policy')
@section('style')



@endsection


@section('content')
<section class="copyrightpolicy">
    <div class="container" id="b-homedb">
        <div class="row">
            <div class="box">
            <h3><sup>&copy; </sup>{{ trans('copyrightpolicy.copyrightpolicy') }}  </h3>
            <div class="copyrith-text">
                <p>{{ trans('copyrightpolicy.copyrightpolicybody') }}
                </p>
            </div>
            </div>
        </div>
    </div>
</section>
    
@endsection


@section('footer')

@endsection


<!-- About Container -->
