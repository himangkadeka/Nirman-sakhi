@include('layout.workerheader')
<style>
    .card-title{
        border-bottom: 2px solid #1466ff;
    }
    .custom-form {
        background-color: #fdfdfd;
        padding: 2rem;
        border-radius: 1rem;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
        margin-top: 2rem;
    }

    .custom-form .form-label {
        font-weight: 600;
        font-size: 0.95rem;
        color: #333;
    }

    .custom-form .form-control-sm {
        border-radius: 0.5rem;
        border: 1px solid #ccc;
        font-size: 0.9rem;
        transition: border-color 0.3s ease-in-out, box-shadow 0.3s ease-in-out;
    }

    .custom-form .form-control-sm:focus {
        border-color: #0d6efd;
        box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.1);
    }

    /* Optional max width for larger screens */
    .custom-form .container {
        max-width: 960px;
    }
    .row .col-md-4 {
        padding-right: 1rem; /* horizontal spacing */
    }


    /* Spacing between rows and columns (already applied via Bootstrap gx-4 gy-3) */

</style>
<div class="d-flex" id="wrapper" style="font-family: Roboto,Sans-Serif;">
    @include('worker.leftmenu')

    <div id="page-content-wrapper">
        @include('components.worker.ui.navbar')
        <div class="container my-5">
            <div class="custom-form">
                <div class="card shadow-sm border-0 rounded-4">
                    <div class="card-body text-center p-5">
                        <div class="mb-4">
                            <i class="fas fa-check-circle fa-4x text-success"></i>
                        </div>
                        <h3 class="card-title fw-bold text-success">Payment Completed</h3>
                        <p class="mt-3 mb-1 fs-5 text-muted">
                            Your subscription payment has been successfully completed.
                        </p>
                        {{--<p class="fw-semibold text-dark">--}}
                            {{--Duration: <span class="text-primary">01-Jan-2025 to 31-Dec-2025</span>--}}
                        {{--</p>--}}

                        <div class="mt-4">
                            <a href="{{ route('worker-dashboard') }}" class="btn btn-outline-primary rounded-pill px-4">
                                Go to Dashboard
                            </a>
                            <a href="{{ route('my-subscription') }}" class="btn btn-primary rounded-pill px-4 ms-2">
                                View Payment Details
                            </a>
                            <a href="{{ route('idcards.index') }}" class="btn btn-outline-primary rounded-pill px-4 ms-2">
                                View ID Card
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
@include('components.footer')