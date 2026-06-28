@extends('layouts.admin-app')

@section('title', 'Admin | District Wise Data')
@section('breadcrumb_item_1', 'MIS Data')
@section('breadcrumb_item_2', 'District Wise Data')
@section('content')

    <div class="container-fluid">
        <div class="row">
            <div class="text-center py-4" id="sortable-cards" style="width: 10%;">
                <div class="b-customize ">
                    <div class=" p-2 b-dbcard" style="background-color: #3dc6cb;">
                        <div class="">
                            <p class="text-center font-weight-bold" style="font-size: 14px; color: white;">Number of Applications Received</p>
                            <h3 class="text-center font-weight-bold" style="margin-top: -5px; font-size: 13px;color: white;">
                            </h3>
                            <div class="text-left" style="margin: 5px 0px 5px;">
                                <span class="badge badge-success"></span>
                                <span style="font-size:12px;"></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


@endsection
