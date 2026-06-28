@extends('layouts.user-app')

@section('title', 'Documents')

@section('style')
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">

    <style>
        body {
            background-color: #f1f1f1;
            font-family: "Montserrat Alternates", "Open Sans", Helvetica, Arial, sans-serif;
        }

        #pdf-preview {
            width: 100%;
            height: 400px;
            /* Adjust height as needed */
            border: none;
        }


        .bg-light-gray {
            background-color: #f0f0f0
        }

        .table,
        td {
            font-size: 13px;
        }


        th,
        td {
            border: 1px solid black;
            border-collapse: collapse;
        }

        /* Default styles */
        .form-container {
            display: flex;
            align-items: center;
            margin-top: 40px;
        }



        .form-heading {
            margin-bottom: 12px;
        }

        .form-image-container {
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            padding: 12px;
            margin-right: 12px;
            height: 200px;
        }

        .form-image {
            width: 200px;
            height: 200px;
        }

        .form-image1 {
            width: 200px;
            height: 80px;
        }

        .form-controls {
            display: flex;
            align-items: center;
            margin-top: 12px;
            padding: 12px;
        }

        .btn-primary {
            background-color: #0f4547;
        }

        .form-input input[type="file"] {
            margin-right: 12px;
        }

        .form-button button {
            margin-left: 12px;
        }

        /* Media queries for smaller screens */
        @media screen and (max-width: 768px) {
            .form-container {
                flex-direction: column;
                margin-left: 0;
            }

            .form-content {
                width: 100%;
                margin-bottom: 20px;
            }

            .form-content-thumb {
                width: 100%;
            }
        }

        .custom-navbar {
            border-bottom: 2px solid #eee;
        }

        .custom-container {
            max-width: 1200px;
        }

        .custom-flex-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .custom-left-content {
            display: flex;
            flex-direction: column;
        }

        .custom-heading {
            margin-bottom: 0.5rem;
            font-size: 11px;
        }

        .custom-bold {
            font-weight: bold;
        }

        .custom-icon {
            color: #007bff;
        }

        .my-table-class tbody tr:nth-child(odd) {
            background-color: rgb(219, 226, 232);
            /* Light gray */
        }

        .my-table-class tbody tr:nth-child(even) {
            background-color: #ffffff;
            /* White */
        }

        .fixed-width {
            min-width: 200px;
            /* Adjust the width as needed */
        }
    </style>
@endsection

@section('content')
    @include('components.multistep-existing')

    <div class="container-fluid mb-4">
        <div class="col-md-12">
            <nav class="custom-navbar navbar-light p-3" style="border-radius: 20px;">
                <div class="custom-container">
                    <div class="custom-flex-container">
                        <div class="custom-left-content">

                        </div>
                        @include('components.session-timeout')
                    </div>
                </div>
            </nav>
            <div class="card mt-1">
                <div class="card-body">

                    <div class="container-fluid">
                        <div class="d-flex justify-content-center align-items-center mb-1">
                            <span>
                                <i class="fa fa-user" aria-hidden="true"></i>
                                {{ trans('worker-registration/worker-family-details.workername') }}
                                - {{ $getVaultData['name'] }}
                            </span>

                        </div>
                        <div class="d-flex justify-content-center align-items-center mb-3">

                            <span>

                                {{ trans('worker-registration/worker_basic_details.id_card') }}
                                - <span class="font-weight-bold">{{ $worker_id }}</span>
                            </span>
                        </div>

                        <div class="card rounded-card">
                            <div class="card-header card-header-bg text-white d-flex justify-content-between align-items-center"
                                style="background-color: #2badee;">
                                <span>
                                    <i class="fa fa-plus-circle" aria-hidden="true"></i>&nbsp;
                                    {{ trans('worker-registration/worker-documents-details.supportingdoc') }}
                                </span>
                            </div>
                           @if($remarks)
                                <div class="mt-2 ml-2">
                                    <h6 class="text-primary">For the following reasons application has been reverted:</h6>
                                    <p>
                                    <ul>
                                        @foreach ($remarks->getReasons($remarks->worker_id) as $remark)
                                            <li class="text-danger">{{$remark->reason}}</li>
                                        @endforeach
                                    </ul>
                                    </p>
                                </div>
                                <div class="">
                                    <div class="ml-2">
                                        <h6 class="text-primary">Remarks from officers:</h6>
                                        <p class="text-danger">{{$remarks->remarks}}</p>
                                    </div>
                                </div>
                           @endif
                            <div class="mr-2 mt-3 ml-2"
                                style="background-color: #f9f9f9; padding: 10px; border-radius: 5px; border: 1px solid #ccc; color: #333;">
                                <p style="margin: 0;">
                                    <strong>{{ trans('worker-registration/worker-documents-details.note') }}:</strong>
                                </p>
                                <p style="margin: 0;">
                                    <strong>{{ trans('worker-registration/worker-documents-details.1') }}.</strong><span
                                        class="text-danger">
                                        {{ trans('worker-registration/worker-documents-details.mandatory') }}</span>
                                </p>
                                <p style="margin: 0;">
                                    <strong>{{ trans('worker-registration/worker-documents-details.2') }}.</strong><span
                                        class="text-danger">
                                        {{ trans('worker-registration/worker-documents-details.mandatory2') }}
                                    </span>
                                </p>
                            </div>


                            @if (session()->has('error'))
                                <div class="alert alert-warning alert-dismissible fade show">
                                    <i class="bi bi-check-circle me-1"></i>
                                    {{ session('error') }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"
                                        aria-label="Close"></button>
                                </div>
                            @endif
                            @csrf
                            <div class="table-container mt-4" style="overflow-x:auto;">
                                <table class="table table-bordered my-table-class">
                                    <thead>
                                        <tr style="background-color:rgb(164, 206, 221)">
                                            <th class="text-center align-middle" scope="col">Sl.No</th>
                                            <th class="text-center align-middle" scope="col">Type Of Documents</th>
                                            <th class="text-center align-middle" scope="col">Status</th>
                                            <th class="text-center align-middle">Upload</th>
                                            <th class="text-center align-middle">Preview</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $serialNumber = 1;
                                        @endphp
                                        @foreach ($documents as $document)
                                            @if (
                                                ($document['id'] != 5 || $has_ration_card) &&
                                                    ($document['id'] != 7 || $has_pan) &&
                                                    ($document['id'] != 3 || $has_subscription_receipt) &&
                                                    ($document['id'] != 1 || !$has_do_address) &&
                                                    ($document['id'] != 1 || !$has_type_of_document))
                                                <tr>
                                                    <td class="text-center align-middle">{{ $serialNumber }}</td>
                                                    <td class="fixed-width font-weight-bold">{{ $document['label'] }}</td>
                                                    <td class="bold align-middle text-center fixed-width"
                                                        id="status-{{ $document['id'] }}" style="width: 100px">
                                                        @if ($document['uploaded'])
                                                            <span
                                                                class="badge badge-success">{{ trans('worker-registration/worker-documents-details.Uploaded') }}</span>
                                                        @else
                                                            <span
                                                                class="badge badge-warning">{{ trans('worker-registration/worker-documents-details.pending') }}</span>
                                                        @endif
                                                    </td>
                                                    <td class="fixed-width text-center align-middle">
                                                        <form id="form-{{ $document['id'] }}"
                                                            action="{{ route('save-existing-documents') }}" method="POST"
                                                            enctype="multipart/form-data">
                                                            @csrf
                                                            <input type="hidden" name="document_id"
                                                                value="{{ $document['id'] }}">
                                                            <div class="text-center">
                                                                <button id="file-input-button-{{ $document['id'] }}"
                                                                    class="btn btn-primary btn-sm" type="button">
                                                                    {{ trans('worker-registration/worker-documents-details.choose') }}
                                                                </button>
                                                                <input id="file-input-{{ $document['id'] }}" type="file"
                                                                    class="d-none" name="{{ $document['name'] }}"
                                                                    accept="application/pdf">
                                                            </div>
                                                            <!-- Hidden fields for file preview modal -->
                                                            <input type="hidden"
                                                                id="modal-file-name-{{ $document['id'] }}"
                                                                name="modal_file_name">
                                                            <input type="hidden"
                                                                id="modal-file-size-{{ $document['id'] }}"
                                                                name="modal_file_size">
                                                        </form>
                                                    </td>
                                                    <td class="fixed-width text-center align-middle">
                                                        <div>
                                                            @if ($document['id'] == 1 && $document['uploaded'])
                                                                <a class="btn btn-danger btn-sm" target="_blank"
                                                                    href="{{ route('show-res-proof', ['id' => mt_rand(1, 1000)]) }}">
                                                                    <i class="fa fa-eye" aria-hidden="true"></i>
                                                                </a>
                                                            @elseif ($document['id'] == 2 && $document['uploaded'])
                                                                <a class="btn btn-danger btn-sm" target="_blank"
                                                                    href="{{ route('show-old-id-card', ['id' => mt_rand(1, 1000)]) }}">
                                                                    <i class="fa fa-eye" aria-hidden="true"></i>
                                                                </a>
                                                            @elseif ($document['id'] == 3 && $document['uploaded'])
                                                                <a class="btn btn-danger btn-sm" target="_blank"
                                                                    href="{{ route('show-worker-subscription', ['id' => mt_rand(1, 1000)]) }}">
                                                                    <i class="fa fa-eye" aria-hidden="true"></i>
                                                                </a>
                                                            @elseif ($document['id'] == 4 && $document['uploaded'])
                                                                <a class="btn btn-danger btn-sm" target="_blank"
                                                                    href="{{ route('show-bank-copy', ['id' => mt_rand(1, 1000)]) }}">
                                                                    <i class="fa fa-eye" aria-hidden="true"></i>
                                                                </a>
                                                            @elseif ($document['id'] == 5 && $document['uploaded'])
                                                                <a class="btn btn-danger btn-sm" target="_blank"
                                                                    href="{{ route('show-ration_card', ['id' => mt_rand(1, 1000)]) }}">
                                                                    <i class="fa fa-eye" aria-hidden="true"></i>
                                                                </a>
                                                            @elseif ($document['id'] == 6 && $document['uploaded'])
                                                                <a class="btn btn-danger btn-sm" target="_blank"
                                                                    href="{{ route('show_nominee_bank_copy', ['id' => mt_rand(1, 1000)]) }}">
                                                                    <i class="fa fa-eye" aria-hidden="true"></i>
                                                                </a>
                                                            @elseif ($document['id'] == 7 && $document['uploaded'])
                                                                <a class="btn btn-danger btn-sm" target="_blank"
                                                                    href="{{ route('show-pan_card', ['id' => mt_rand(1, 1000)]) }}">
                                                                    <i class="fa fa-eye" aria-hidden="true"></i>
                                                                </a>
                                                            @elseif ($document['id'] == 8 && $document['uploaded'])
                                                                <a class="btn btn-danger btn-sm" target="_blank"
                                                                    href="{{ route('show-work-book', ['id' => mt_rand(1, 1000)]) }}">
                                                                    <i class="fa fa-eye" aria-hidden="true"></i>
                                                                </a>
                                                            @endif
                                                        </div>
                                                    </td>
                                                </tr>
                                                @php
                                                    $serialNumber++;
                                                @endphp
                                            @endif
                                        @endforeach

                                        <div class="modal fade" id="file-preview-modal" tabindex="-1" role="dialog"
                                            aria-labelledby="filePreviewModalLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-lg" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="filePreviewModalLabel">
                                                            File Preview
                                                        </h5>
                                                        <button type="button" class="close" data-bs-dismiss="modal"
                                                            aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <iframe id="pdf-preview" src="" width="100%"
                                                            height="500px"></iframe>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                            data-bs-dismiss="modal">Discard</button>
                                                        <button id="submit-form-button" type="button"
                                                            class="btn btn-primary">Upload</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <tr>
                                            <td class="text-center align-middle">{{ $serialNumber }}</td>
                                            <td class="fixed-width font-weight-bold align-middle">
                                                {{ trans('worker-registration/worker-documents-details.passportimg') }}&nbsp;<span
                                                    class="text-danger">({{ trans('worker-registration/worker-documents-details.aadhaar') }})</span>
                                            </td>
                                            <td colspan="5" class="text-center align-middle">
                                                @if (!empty($base64Image))
                                                    <img src="data:image/jpeg;base64,{{ $base64Image }}"
                                                        alt="User Photo" class="bordered-image"
                                                        style="border: 1px solid grey;">
                                                @else
                                                    <p>{{ trans('worker-registration/worker-documents-details.nophoto') }}
                                                    </p>
                                                @endif
                                            </td>
                                        </tr>
                                </table>
                            </div>
                            <div class="d-flex justify-content-center align-items-center mt-4 mx-4">

                                <div>
                                    <input class="styled-checkbox" type="checkbox" id="termsCheck" required>
                                </div>

                                <div class="" style=" display: flex;justify-content: center;">

                                    <span style="color: red;" class="text-danger">*</span>&nbsp<p class="">
                                        {{ trans('worker-registration/worker-documents-details.declaration') }}

                                    </p>
                                </div>

                            </div>


                            <div class="d-flex justify-content-center mt-4">
                                <form action="{{ route('save-worker-documents') }}" method="post"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <div class="d-flex justify-content-between align-items-center mb-1 clearfix mt-4">
                                        <div class="ml-auto d-inline-block align-self-center mr-2">
                                            <a type="submit" href="{{ route('submit-existing-employers') }}"
                                                class="btn btn-sm btn-warning"><i class="fa fa-backward"
                                                    aria-hidden="true"></i>&nbsp;
                                                Previous</a>
                                            <button type="submit" class="btn btn-sm btn-success" id="submitAll"
                                                disabled> <i class="fa fa-check-circle" aria-hidden="true"></i>&nbsp;
                                                Save & Preview Application</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>

@endsection


@section('footer')
    <script src="{{ URL::asset('assets/template/js/session-timeout.js') }}"></script>
    <script>
        $(document).ready(function() {

            let totalDocuments = 0;
            let uploadedDocuments = 0;

            @foreach ($documents as $document)
                @if (
                    ($document['id'] != 5 || $has_ration_card) &&
                        ($document['id'] != 7 || $has_pan) &&
                        ($document['id'] != 3 || $has_subscription_receipt) &&
                        ($document['id'] != 1 || !$has_do_address) &&
                        ($document['id'] != 1 || !$has_type_of_document))

                    totalDocuments++;
                    console.log('{{ $document['id'] }}')

                    @if ($document['uploaded'])
                        uploadedDocuments++;
                    @endif
                @endif
            @endforeach

            console.log("Total docs ", totalDocuments++)
            console.log(uploadedDocuments++)

            function checkConditions() {
                if (uploadedDocuments === totalDocuments && $('#termsCheck').is(':checked')) {
                    $('#submitAll').prop('disabled', false);
                } else {
                    $('#submitAll').prop('disabled', true);
                }
            }

            // Event listener for terms checkbox
            $('#termsCheck').on('change', function() {
                checkConditions();
            });

            // Event listener for document uploads
            $('form').on('submit', function(event) {
                // Assume form submission is successful and increment the count
                uploadedDocuments++;
                checkConditions();
            });

            // Initial check
            checkConditions();

            // Event listener for the submit button
            $('#submitAll').on('click', function(event) {
                event.preventDefault(); // Prevent the default form submission behavior
                window.location.href = "{{ route('submit-existing-documents') }}";
            });
        });
    </script>


    <script>
        $(document).ready(function() {
            $('.custom-file-input').on('change', function(event) {
                var inputFile = event.currentTarget;
                $(inputFile).parent()
                    .find('.custom-file-label')
                    .html(inputFile.files.length > 0 ? inputFile.files[0].name : 'Choose file');
            });
        });
    </script>


    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.addEventListener('click', function(event) {
                if (event.target && event.target.matches('[id^="file-input-button-"]')) {
                    const id = event.target.id.split('-').pop();
                    document.getElementById(`file-input-${id}`).click();
                }
            });

            document.addEventListener('change', function(event) {
                if (event.target && event.target.matches('[id^="file-input-"]')) {
                    const id = event.target.id.split('-').pop();
                    const file = event.target.files[0];
                    const filePreview = document.getElementById('pdf-preview');
                    const form = document.getElementById(`form-${id}`);
                    const submitButton = document.getElementById('submit-form-button');

                    if (file) {
                        const fileType = file.type;
                        if (fileType !== 'application/pdf') {
                            alert('Only PDF files are allowed.');
                            return;
                        }

                        const fileReader = new FileReader();
                        fileReader.onload = function(e) {
                            filePreview.src = e.target.result;
                            $('#file-preview-modal').modal('show');
                        };
                        fileReader.readAsDataURL(file);

                        submitButton.onclick = function() {
                            form.submit();
                        };
                    }
                }
            });
        });
    </script>
@endsection
