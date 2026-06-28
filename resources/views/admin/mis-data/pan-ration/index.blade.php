@extends('layouts.admin-app')

@section('title', 'Admin | Pan & Ration')
@section('breadcrumb_item_1', 'MIS Data')
@section('breadcrumb_item_2', 'Pan & Ration Wise Data')
@section('style')

    @endsection
@section('content')


    <div class="container-fluid">
        <div class="row justify-content-center py-4" id="sortable-cards">

            <!-- PAN Card -->
            <div class="col-md-3">
                <div class="card  shadow" style="background-color: #3dc6cb;">
                    <div class="card-body text-center">
                        <h5 class="card-title">Workers with PAN</h5>
                        <h2>{{ $data['pan'] }}</h2>
                    </div>
                </div>
            </div>

            <!-- Ration Card -->
            <div class="col-md-3">
                <div class="card shadow" style="background-color: #5a9bd6;">
                    <div class="card-body text-center">
                        <h5 class="card-title">Workers with Ration Card</h5>
                        <h2>{{ $data['ration'] }}</h2>
                    </div>
                </div>
            </div>

        </div>
    </div>



@endsection
