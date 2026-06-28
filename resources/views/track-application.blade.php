@extends('layouts.user-app')



@section('title', 'Acts and Rules')

@section('style')

    {{-- <link rel="stylesheet" href="{{ URL::asset('assets/template/css/actandrules.css') }}" /> --}}
    <style>
        .cardhead1 {
            cursor: pointer;
            position: relative;
            background: linear-gradient(to right, #00008b, #279ca0);
            width: 341px;
            height: 40px;
        }

        .cardhead1triangle {
            position: absolute;
            top: 50%;
            right: -12px;
            width: 0;
            height: 0;
            border-left: 35px solid transparent;
            border-right: 35px solid transparent;
            border-bottom: 50px solid white;
            transform: translateY(-50%) rotate(-90deg);
        }


        .headbackground {
            background-color: #65c4ff !important;
        }


        .table thead th,
        .table tbody td {
            word-wrap: break-word;
            white-space: normal;
        }

        a:link{
            text-decoration: none;
        }

        .download {
            background-color: #1b949e !important;
        }

        .table-bordered tr:nth-child(even) {

            background: #f7f3f3;
        }

        @media (max-width: 767px) {
            .cardhead1 {
                width: 300px;
            }

            .table thead {
                display: none;

            }

            .table,
            .table tbody,
            .table tr {
                display: block;

                width: 100%;

            }

            .table td {
                display: block;

                position: relative;
                padding-left: 50%;


                text-align: left;
                border-bottom: 1px solid #ddd;

            }

            .table td:before {
                content: attr(data-label);

                position: absolute;
                top: 0;
                left: 0;
                width: 100%;


                padding: 0 10px;

                font-weight: bold;
                white-space: nowrap;
                background-color: #65c4ff;

                color: white;

                text-align: center;

                line-height: 1.5;

                box-sizing: border-box;

            }


            .table tr {
                margin-bottom: 1rem;

                background: #f9f9f9;

            }

            .download {

                margin-top: 8%;


            }

            .bodycolor {
                background-color: white !important;

            }

        }
    </style>

@endsection

@section('content')

    <div class="container my-5">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6">
                <div class="card shadow-sm rounded-4">
                    <div class="card-header bg-white border-bottom-0">
                        <h5 class="mb-0 text-center text-primary fw-semibold">Track Your Application</h5>
                    </div>
                    <div class="card-body bg-light rounded-bottom-4">
                        @if(session('error'))
                            <div class="alert alert-danger">{{ session('error') }}</div>
                        @endif

                        <form method="POST" action="">
                            @csrf

                            <div class="mb-4">
                                <label class="form-label fw-semibold d-block mb-2">Search By:</label>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="search_by" id="byPhone" value="phone" required>
                                    <label class="form-check-label" for="byPhone">Phone Number</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="search_by" id="byWorkerId" value="worker_id">
                                    <label class="form-check-label" for="byWorkerId">Worker ID</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="search_by" id="byAckNo" value="ack_no">
                                    <label class="form-check-label" for="byAckNo">Acknowledgement No</label>
                                </div>
                            </div>

                            <div class="mb-4">
                                <label for="search_value" class="form-label fw-semibold">Enter Value</label>
                                <input type="text" class="form-control" id="search_value" name="search_value" placeholder="Enter search value" required>
                            </div>

                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary">Track Application</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('footer')
    <script>
        // Select all elements with the class 'downloadLink'
        const downloadLinks = document.querySelectorAll('.downloadLink');

        // Add a click event listener to each link
        downloadLinks.forEach(link => {
            link.addEventListener('click', function(event) {
                event.preventDefault(); // Prevent the default link behavior
                alert('File not found');
            });
        });
    </script>

@endsection
