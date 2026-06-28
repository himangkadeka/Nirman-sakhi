<style>
    .card {
        background-color: #fff;
        border-radius: 10px;
        border: none;
        position: relative;
        box-shadow: 0 0.46875rem 2.1875rem rgba(90, 97, 105, 0.1), 0 0.9375rem 1.40625rem rgba(90, 97, 105, 0.1), 0 0.25rem 0.53125rem rgba(90, 97, 105, 0.12), 0 0.125rem 0.1875rem rgba(90, 97, 105, 0.1);
    }

    .l-bg-cherry {
        background: linear-gradient(to right, #493240, #f09) !important;
        color: #fff;
    }

    .l-bg-blue-dark {
        background: linear-gradient(to right, #373b44, #4286f4) !important;
        color: #fff;
    }

    .l-bg-green-dark {
        background: linear-gradient(to right, #0a504a, #38ef7d) !important;
        color: #fff;
    }

    .l-bg-orange-dark {
        background: linear-gradient(to right, #a86008, #ffba56) !important;
        color: #fff;
    }

    .card .card-statistic-3 .card-icon-large .fas,
    .card .card-statistic-3 .card-icon-large .far,
    .card .card-statistic-3 .card-icon-large .fab,
    .card .card-statistic-3 .card-icon-large .fal {
        font-size: 16px;
    width: 45px;
    height: 45px;
    margin-right: 10px;
    background: #00000078;
    color: white;
    border-radius: 50%;
    line-height: 45px;
    }

    .card .card-statistic-3 .card-icon {
        text-align: center;
        line-height: 50px;
        margin-left: 15px;
        color: #000;
        position: absolute;
        right: -5px;
        top: 20px;
        opacity: 0.5;
    }

    .l-bg-cyan {
        background: linear-gradient(135deg, #289cf5, #84c0ec) !important;
        color: #fff;
    }

    .l-bg-green {
        background: linear-gradient(135deg, #23bdb8 0%, #43e794 100%) !important;
        color: #fff;
    }

    .l-bg-orange {
        background: linear-gradient(to right, #f9900e, #ffba56) !important;
        color: #fff;
    }

    .l-bg-cyan {
        background: linear-gradient(135deg, #289cf5, #84c0ec) !important;
        color: #fff;
    }
    .rgrid{display:grid;grid-template-columns: repeat(auto-fit, minmax(160px, 1fr));gap:12px;}
    .rgrid a.readmore{
        color: white;
        position: relative;
        top: 10px;
        background: #0000001c;
        padding: 5px 10px;
        border-radius: 5px;
        transition:0.4s linear;
        left:0;
        text-decoration: none;
    }
    .rgrid a.readmore:hover{left:10px}
</style>

<section class="mb-5">
    <div class="d-flex justify-content-between align-items-center mb-3">
        {{-- <h3 class="section-title">Available Schemes</h3> --}}
        {{-- <div class="dropdown">
                <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" id="schemeFilter"
                    data-bs-toggle="dropdown">
                    Filter Schemes
                </button>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="#">All Schemes</a></li>
                    <li><a class="dropdown-item" href="#">Eligible</a></li>
                    <li><a class="dropdown-item" href="#">Applied</a></li>
                </ul>
            </div> --}}
        {{-- <div class="card"></div> --}}
    </div>
    {{-- <div class="container"> --}}
    <div class="rgrid">
        <div class="">
            <div class="card l-bg-cherry">
                <div class="card-statistic-3 p-4">
                    <div class="card-icon card-icon-large"><i class="fas fa-book"></i></div>
                    <div class="mb-3">
                        <h5 class="card-title mb-0">Education</h5>
                    </div>
                    <div class="row align-items-center mb-2 d-flex">
                        <div class="col-8">
                            <h2 class="d-flex align-items-center mb-0">
                               {{\App\Models\Benefit::where('category_id', 1)->where('status',1)->count()}}
                            </h2>
                        </div>
                        <a href="{{ route('benefit-list', 1) }}" class="readmore">
                            Read more <i class="bi bi-arrow-right"></i>
                        </a>
                    </div>

                </div>
            </div>
        </div>
        <div class="">
            <div class="card l-bg-blue-dark">
                <div class="card-statistic-3 p-4">
                    <div class="card-icon card-icon-large"><i class="fas fa-plus"></i></div>
                    <div class="mb-3">
                        <h5 class="card-title mb-0">Medical</h5>
                    </div>
                    <div class="row align-items-center mb-2 d-flex">
                        <div class="col-8">
                            <h2 class="d-flex align-items-center mb-0">
                                {{\App\Models\Benefit::where('category_id', 3)->where('status',1)->count()}}
                            </h2>
                        </div>
                        <a href="{{ route('benefit-list', 3) }}" class="readmore">
                            Read more <i class="bi bi-arrow-right"></i>
                        </a>
                    </div>
                    {{-- <div class="progress mt-1 " data-height="8" style="height: 8px;">
                        <div class="progress-bar l-bg-green" role="progressbar" data-width="25%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100" style="width: 25%;"></div>
                    </div> --}}
                </div>
            </div>
        </div>
        <div class="">
            <div class="card l-bg-green-dark">
                <div class="card-statistic-3 p-4">
                    <div class="card-icon card-icon-large"><i class="fas fa-ticket-alt"></i></div>
                    <div class="mb-3">
                        <h5 class="card-title mb-0">Marriage</h5>
                    </div>
                    <div class="row align-items-center mb-2 d-flex">
                        <div class="col-8">
                            <h2 class="d-flex align-items-center mb-0">
                                {{\App\Models\Benefit::where('category_id', 2)->where('status',1)->count()}}
                            </h2>
                        </div>
                        <a href="{{ route('benefit-list', 2) }}" class="readmore">
                            Read more <i class="bi bi-arrow-right"></i>
                        </a>
                    </div>
                    {{-- <div class="progress mt-1 " data-height="8" style="height: 8px;">
                        <div class="progress-bar l-bg-orange" role="progressbar" data-width="25%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100" style="width: 25%;"></div>
                    </div> --}}
                </div>
            </div>
        </div>
        <div class="">
            <div class="card l-bg-orange-dark">
                <div class="card-statistic-3 p-4">
                    <div class="card-icon card-icon-large"><i class="fas fa-plus"></i></div>
                    <div class="mb-3">
                        <h5 class="card-title mb-0">Others</h5>
                    </div>
                    <div class="row align-items-center mb-2 d-flex">
                        <div class="col-8">
                            <h2 class="d-flex align-items-center mb-0">
                                {{\App\Models\Benefit::where('category_id', 4)->where('status',1)->count()}}
                            </h2>
                        </div>
                        <a href="{{ route('benefit-list', 4) }}" class="readmore">
                            Read more <i class="bi bi-arrow-right"></i>
                        </a>
                    </div>
                    {{-- <div class="progress mt-1 " data-height="8" style="height: 8px;">
                        <div class="progress-bar l-bg-cyan" role="progressbar" data-width="25%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100" style="width: 25%;"></div>
                    </div> --}}
                </div>
            </div>
        </div>
    </div>
    {{-- </div> --}}

    {{-- <div class="table-responsive">
        <table class="table table-hover">
            <thead class="table-light">
                <tr>
                    <th width="10%">Sl. No</th>
                    <th width="50%">Scheme Name</th>
                    <th width="20%">Status</th>
                    <th width="20%">Actions</th>
                </tr>
            </thead>
            <tbody>
                <!-- Placeholder for scheme data -->
                <tr>
                    @foreach ($benefits as $benefit)
                <tr class="">
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $benefit->name }}</td>
                    <td><a class="btn btn-sm btn-primary square" href="#">View</a> </td>
                    <td>
                        @if (\App\Models\FormSubmission::where('benefit_id', $benefit->id)->where('worker_id', $workerData->worker_id)->where('status', null)->exists())
                            <a class="btn btn-sm btn-warning square"
                                href="{{ route('worker.apply-now', $benefit->id) }}">Complete Application</a>
                        @elseif(!\App\Models\FormSubmission::where('benefit_id', $benefit->id)->where('worker_id', $workerData->worker_id)->exists())
                            <a class="btn btn-sm btn-primary square"
                                href="{{ route('worker.apply-now', $benefit->id) }}">Apply Now</a>
                        @else
                            <button type="button" class="btn btn-success"> Applied</button>
                        @endif
                    </td>
                </tr>
                @endforeach
                </tr>
            </tbody>
        </table>
    </div> --}}
</section>

<!-- Application Status Tracker -->
{{-- <section class="mb-5">
    <h3 class="mb-3 section-title">Benefit Application Tracker</h3>
    <div class="table-responsive">
        <table class="table table-hover">
            <thead class="table-light">
                <tr>
                    <th>Application ID</th>
                    <th>Scheme</th>
                    <th>Date</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>

        </table>
    </div>
</section> --}}
