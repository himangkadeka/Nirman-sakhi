@extends('layouts.user-app')
@section('title', 'Payment')
@section('content')

    <div class="container my-5">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-primary text-white">
                <h3 class="mb-0">Payment Gateway Response Details</h3>
            </div>
            <div class="card-body">
                @if (!empty($parsedParameters))
                    <div class="table-responsive">
                        <table class="table table-hover table-bordered align-middle">
                            <thead class="table-light">
                            <tr>
                                <th scope="col">Parameter</th>
                                <th scope="col">Value</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($parsedParameters as $key => $value)
                                <tr>
                                    <td class="fw-bold">{{ $key }}</td>
                                    <td class="text-break">{{ $value }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="alert alert-info text-center" role="alert">
                        No parameters could be parsed from the response.
                    </div>
                @endif
            </div>
            <div class="card-footer bg-light d-flex justify-content-between align-items-center">
                <span class="text-success fw-semibold">Thank you for your payment!</span>
                <a href="{{ route('print-ack') }}" class="btn btn-primary">
                    Acknowledgement Page <i class="fa fa-arrow-right ms-1" aria-hidden="true"></i>
                </a>
            </div>
        </div>
    </div>

    <!-- Bootstrap 5 JS (uses bundle with Popper included) -->
    <script src="{{URL::asset('assets/template/js/bootstrap.bundle.min.js')}}"></script>
@endsection
