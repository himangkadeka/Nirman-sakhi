@extends('layouts.admin-app')

@section('title', 'Office | DSC-Registration')
@section('breadcrumb_item_1', 'DSC')
@section('breadcrumb_item_2', 'Registration')







@section('content')
 <div class="container text-center">
        <iframe src="{{route('office.dsc.iframe')}}" frameborder="0" width="100%" height="800"></iframe>

 </div>
@endsection

@section('footer')
@endsection
