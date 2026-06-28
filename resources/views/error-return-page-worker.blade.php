@extends('layouts.user-app')

@section('title', 'Worker')

@section('style')
    <style>
        .btn{
            border-radius:0px ;

        }
    </style>

    @endsection


@section('content')
    <div class="container mt-4 mb-2">
        <div class="card border-danger">
            <div class="card-header bg-danger text-white">
                Error
            </div>
            <div class="card-body">
                <h5 class="card-title">Oops! Something went wrong.</h5>
                <h6 class="card-text">{{ $msg }}</h6><a href="{{route('home.index')}}" class="btn btn-sm btn-danger">Back to Homepage</a>
            </div>
        </div>
    </div>
@endsection


@section('footer')
    @endsection
