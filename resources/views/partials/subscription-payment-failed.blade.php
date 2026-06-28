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
                    <a href="{{ route('my-subscription') }}" class="btn btn-primary">Try Again<i
                                class="fa fa-forward" aria-hidden="true"></i></a>
                </div>

                </div>
            </div>
        </div>
    </div>
</div>
@include('components.footer')