@extends('layouts.user-app')
@section('title', 'Payment')
@section('content')
    <div class="container mt-5">
        <div class="card">
            <div class="card-header">
                <h2>Payment Gateway Response Details</h2>
            </div>
            <div class="card-body">
                @if (!empty($parsedParameters))
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered">
                            <thead class="thead-light">
                            <tr>
                                <th>Parameter</th>
                                <th>Value</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($parsedParameters as $key => $value)
                                <tr>
                                    <td>{{ $key }}</td>
                                    <td class="text-break">{{ $value }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="alert alert-info" role="alert">
                        No parameters could be parsed from the response.
                    </div>
                @endif
            </div>
            <div class="card-footer text-danger">
                Payment cancelled By User!
                <a href="{{ route('submit-worker-payment') }}" class="btn btn-primary">Try Again<i
                            class="fa fa-forward" aria-hidden="true"></i></a>
            </div>

        </div>
        <div class="col-auto">

        </div>
    </div>

@endsection

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
