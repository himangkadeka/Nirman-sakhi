@include('layout.workerheader')

<div class="d-flex" id="wrapper">
    {{--@include('worker.leftmenu')--}}
    <div id="page-content-wrapper">
        @include('components.worker.ui.navbar')
        <ul class="breadcrumb">
            <li>Subscription</li>
        </ul>
        <div class="box">
            <div class="card rounded-card shadow-sm">
                <div class="card-header bg-light">
                    <h5 class="mb-0">
                        <i class="fas fa-plus-circle text-primary mr-2"></i>Payment Response Details
                    </h5>
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
                    <span class="text-success fw-semibold">Thank you for your payment is Successful!</span>
                    <a href="{{ route('worker-dashboard') }}" class="btn btn-primary">
                        Return to Dashboard <i class="fa fa-arrow-right ms-1" aria-hidden="true"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@include('components.footer')