@extends('layouts.admin-app')

@section('title', 'Admin | Profession Wise Data')
@section('breadcrumb_item_1', 'MIS Reports')
@section('breadcrumb_item_2', 'Profession-wise Office Count')

@section('style')

@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Profession Wise Worker Count by Office</h4>
                    </div>
                    <div class="card-body">
                        @if(empty($reportData))
                            <div class="alert alert-info text-center">
                                No data available to generate the report.
                            </div>
                        @else
                            <div class="table-responsive">
                                <table id="abaocTable" class="table table-bordered table-striped table-hover">
                                    <thead class="thead-dark">
                                        <tr>
                                            <th style="width: 50px;">S.No.</th>
                                            <th>Profession</th>
                                            @foreach($offices as $office)
                                                <th>{{ $office->office_name }}</th>
                                            @endforeach
                                            <th>Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($reportData as $professionName => $counts)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $professionName }}</td>
                                                @foreach($offices as $office)
                                                    <td>{{ $counts[$office->office_id] ?? 0 }}</td>
                                                @endforeach
                                                <td><strong>{{ $counts['total'] }}</strong></td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot class="bg-light">
                                        <tr>
                                            <th colspan="2" class="text-right">Grand Total</th>
                                            @foreach($offices as $office)
                                                <th>{{ $columnTotals[$office->office_id] ?? 0 }}</th>
                                            @endforeach
                                            <th><strong>{{ $columnTotals['grand_total'] ?? 0 }}</strong></th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('footer')
@endsection
