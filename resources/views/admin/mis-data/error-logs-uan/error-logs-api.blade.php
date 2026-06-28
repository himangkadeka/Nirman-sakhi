@extends('layouts.admin-app')

@section('title', 'Admin | UAN')
@section('breadcrumb_item_1', 'UAN Data')
@section('breadcrumb_item_2', 'Error Logs')

@section('content')
    <div class="container-fluid">
        <div class="row">

            {{-- Total API Logs --}}
            <div class="text-center py-4" style="width: 20%;">
                <div class="b-customize">
                    <div class="p-2 b-dbcard" style="background-color: #3dc6cb;">
                        <p class="text-center font-weight-bold" style="font-size: 14px; color: white;">
                            Total API Logs
                        </p>
                        <h3 class="text-center font-weight-bold" style="font-size: 20px; color: white;">
                            {{ $totalLogs }}
                        </h3>
                    </div>
                </div>
            </div>

            {{-- Successful Logs --}}

            {{-- Failed Logs --}}


        </div>
        <div class="row mt-4">
            <div class="table-responsive" style="max-height: 450px; overflow-y: auto; overflow-x: auto; border:1px solid #ddd;">

                <table class="table table-hover table-bordered table-sm mb-0">
                    <thead class="thead-light" style="position: sticky; top: 0; z-index: 10;">
                    <tr>
                        <th>#</th>
                        <th style="min-width: 250px;">Payload</th>
                        <th style="min-width: 250px;">Response</th>
                        <th>Status</th>
                        <th style="min-width: 150px;">Error Message</th>
                        <th>Created At</th>
                    </tr>
                    </thead>

                    <tbody>
                    @foreach($showLogs as $log)
                        <tr>
                            <!-- Serial number across pages -->
                            <td>{{ ($showLogs->currentPage() - 1) * $showLogs->perPage() + $loop->iteration }}</td>

                            <td>
                                <pre class="log-box">{{ $log->payload }}</pre>
                            </td>

                            <td>
                                <pre class="log-box">{{ $log->response }}</pre>
                            </td>

                            <td>
                                {{$log->status ?? ''}}
                            </td>

                            <td style="word-break: break-word;">{{ $log->error_message }}</td>
                            <td>{{ $log->created_at }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>

            </div>

            <!-- Pagination -->
            <div class="col-12 mt-3">
                {{ $showLogs->links() }}
            </div>
        </div>

        <style>
            .log-box {
                white-space: pre-wrap;
                font-size: 12px;
                margin: 0;
                background: #f8f9fa;
                padding: 6px;
                border-radius: 4px;
                max-height: 150px;
                overflow-y: auto;
                border: 1px solid #e1e1e1;
            }
        </style>




    </div>
@endsection
