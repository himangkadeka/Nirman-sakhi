@extends('layouts.admin-app')

@section('title', 'Admin | Office Wise Data')
@section('breadcrumb_item_1', 'MIS Data')
@section('breadcrumb_item_2', 'Office Wise Data')
@section('content')
    <div class="container mt-1">
        <div class="card shadow-sm border-0">

            <div class="card-body">
                <table class="table table-bordered table-striped mb-0">
                    <thead class="table-light">
                    <tr>
                        <th>User</th>
                        <th>OTP</th>
                        <th>Expire At</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($data as $otpData)
                    <tr>
                        <td>{{ $otpData->user_id }}</td>
                        <td>{{ $otpData->otp }}</td>
                        <td>{{ $otpData->expire_at }}</td>
                    </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>


@endsection

@section('footer')
@endsection