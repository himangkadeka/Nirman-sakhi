@extends('layouts.user-app')

@section('title', 'e-KYC Verification Successful')

@section('style')
    {{-- We can add Bootstrap Icons CDN if not already in the main layout --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

    <style>
        .thank-you-section {
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 70vh; /* Adjust height as needed */
            padding: 40px 15px;
            background-color: #f8f9fa;
        }

        .thank-you-card {
            background-color: #ffffff;
            border-radius: 12px;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
            padding: 40px;
            max-width: 600px;
            width: 100%;
            text-align: center;
            border-top: 5px solid #28a745; /* Green accent color */
            animation: fadeIn 0.8s ease-in-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .success-icon {
            font-size: 6rem;
            color: #28a745;
            margin-bottom: 20px;
        }

        .card-title {
            font-size: 2.2rem;
            font-weight: 700;
            color: #343a40;
            margin-bottom: 15px;
        }

        .card-text {
            font-size: 1.1rem;
            color: #6c757d;
            line-height: 1.6;
            margin-bottom: 30px;
        }

        .btn-dashboard {
            font-size: 1rem;
            padding: 12px 30px;
            border-radius: 50px;
            font-weight: 600;
            transition: all 0.3s ease;
        }
    </style>
@endsection


@section('content')
    <section class="thank-you-section">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="thank-you-card">
                        {{-- Success Icon --}}
                        <div class="success-icon">
                            <i class="bi bi-check-circle-fill"></i>
                        </div>

                        {{-- Title --}}
                        <h2 class="card-title">Verification Successful!</h2>

                        {{-- Message --}}
                        <p class="card-text">
                            Thank you for completing your Aadhaar e-KYC. Your profile details have been successfully updated as per your Aadhaar records. This helps secure your account and ensures you have access to all benefits.
                        </p>

                        {{-- Action Button --}}
                        <a href="{{ route('ekyc-ack-download',$nomine_id) }}" class="btn btn-primary btn-dashboard mb-3" target="_blank">
                           <i class="bi bi-arrow-down-circle"></i> &nbsp; Download Acknowledgement
                        </a>
                        <a href="{{ route('home.index') }}" class="btn btn-primary btn-dashboard">
                           <i class="bi bi-arrow-left-circle"></i> &nbsp; Go to My Dashboard
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection


@section('footer')
    {{-- No specific scripts needed for this page, so this section can be empty or removed. --}}
@endsection
