@extends('layouts.admin-app')

@section('title', 'Office Wise CSC Data')
@section('breadcrumb_item_1', 'MIS Data')
@section('breadcrumb_item_2', 'CSC OFFICE Wise Data')

@section('content')
    <div class="container-fluid">

        <h5 class="mb-3">
            Office Wise CSC Transactions – {{ $district->district_name }}
        </h5>

        <div class="mb-3">
            <a href="{{ route('admin.pfcwise.district') }}" class="btn btn-secondary btn-sm">
                Back to Districts
            </a>
        </div>

        <table class="table table-bordered">
            <thead class="thead-dark">
            <tr>
                <th>Sno</th>
                <th>Office Name</th>
                <th>Total Transactions</th>
            </tr>
            </thead>
            <tbody>
            @foreach($offices as $office)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $office->office_name }}</td>
                    <td>{{ $office->total_transactions }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>

        {{ $offices->links() }}
    </div>
@endsection
