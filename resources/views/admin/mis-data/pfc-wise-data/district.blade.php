@extends('layouts.admin-app')

@section('title', 'District Wise CSC Data')
@section('breadcrumb_item_1', 'MIS Data')
@section('breadcrumb_item_2', 'CSC OFFICE Wise Data')

@section('content')
    <div class="container-fluid">
        <div class="mb-3">
            <a href="{{ route('admin.pfcwise.export', ['csv']) }}" class="btn btn-secondary btn-sm">CSV</a>
            <a href="{{ route('admin.pfcwise.export', ['xlsx']) }}" class="btn btn-secondary btn-sm">Excel</a>
            <a href="{{ route('admin.pfcwise.export', ['pdf']) }}" class="btn btn-secondary btn-sm">PDF</a>
        </div>

        <table class="table table-bordered">
            <thead class="thead-dark">
            <tr>
                <th>Sno</th>
                <th>District</th>
                <th>Total Transactions</th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody>
            @foreach($districts as $district)
                <tr>
                    <td>{{ $districts->firstItem() + $loop->index }}</td>
                    <td>{{ $district->district_name }}</td>
                    <td>{{ $district->total_transactions }}</td>
                    <td>
                        <a href="{{ route('admin.pfcwise.office', $district->district_code) }}"
                           class="btn btn-primary btn-sm">
                            View Offices
                        </a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>

        {{ $districts->links() }}
    </div>
@endsection
