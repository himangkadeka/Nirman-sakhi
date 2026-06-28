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
    @include('components.multistep')

    <div class="container-fluid mb-4">
        <div class="col-md-12">
            <nav class="custom-navbar navbar-light p-3">
                <div class="custom-container">
                    <div class="custom-flex-container">
                        <div class="custom-left-content">
                            <h6 class="custom-heading">{{ trans('worker-registration/worker-documents-details.reg') }}
                            </h6>
                            <h6 class="custom-bold">
                                <i class="custom-icon fas fa-file-alt pr-2"></i>{{ trans('worker-registration/worker-documents-details.appno') }} - {{ $application_no }}
                            </h6>
                        </div>
                        {{--                            <div class="custom-right-content"> --}}
                        {{--                                <h6 class="custom-heading"> --}}
                        {{--                                    <i class="custom-icon fas fa-clock"></i> Session Uptime - --}}
                        {{--                                </h6> --}}
                        {{--                            </div> --}}
                    </div>
                </div>
            </nav>
            <div class="card mt-2">
                <div class="card-body">

                    <div class="container-fluid">
                        <div class="card rounded-card">
                            <div class="card-header card-header-bg text-white d-flex justify-content-between align-items-center"
                                 style="background-color: #248f8f;">
                                <span>
                                    <i class="fa fa-plus-circle" aria-hidden="true"></i>&nbsp; {{ trans('worker-registration/worker-documents-details.supportingdoc') }}
                                </span>
                                <span>
                                    <i class="fa fa-user" aria-hidden="true"></i> {{ trans('worker-registration/worker-documents-details.workername') }} - {{ $getVaultData['name'] }}
                                </span>
                            </div>
                            <div class="mr-2 mt-3 ml-2"
                                 style="background-color: #f9f9f9; padding: 10px; border-radius: 5px; border: 1px solid #ccc; color: #333;">
                                <p style="margin: 0;">
                                    <strong>{{ trans('worker-registration/worker-documents-details.note') }}:</strong>
                                </p>
                                <p style="margin: 0;">
                                    <strong>{{ trans('worker-registration/worker-documents-details.1') }}</strong><span class="text-danger"> {{ trans('worker-registration/worker-documents-details.mandatory') }}</span>
                                </p>
                                <p style="margin: 0;">
                                    <strong>{{ trans('worker-registration/worker-documents-details.2') }}</strong><span class="text-danger"> {{ trans('worker-registration/worker-documents-details.mandatory2') }} </span>
                                </p>
                            </div>

                            <div class="table-container mt-4" style="overflow-x:auto;">
                                <table class="table table-bordered my-table-class">
                                    <thead>
                                    <tr style="background-color:rgb(164, 206, 221)">
                                        <th class="text-center align-middle" scope="col">{{ trans('worker-registration/worker-documents-details.sno') }}</th>
                                        <th class="text-center align-middle" scope="col">{{ trans('worker-registration/worker-documents-details.documenttype') }}</th>
                                        <th class="text-center align-middle" scope="col">{{ trans('worker-registration/worker-documents-details.status') }}</th>
                                        <th class="text-center align-middle">{{ trans('worker-registration/worker-documents-details.upload') }}</th>
                                        <th class="text-center align-middle">{{ trans('worker-registration/worker-documents-details.preview') }}</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @php
                                        $serialNumber = 1;
                                    @endphp
                                    @foreach ($documents as $document)
                                        @if (
                                            ($document['id'] != 4 || $has_ration_card) &&
                                                ($document['id'] != 5 || $has_pan) &&
                                                ($document['id'] != 1 || !$has_do_address))
                                            <tr>
                                                <td class="text-center align-middle">{{ $serialNumber }}</td>
                                                <td class="fixed-width font-weight-bold">{{ $document['label'] }}</td>
                                                <td class="bold align-middle text-center fixed-width"
                                                    id="status-{{ $document['id'] }}" style="width: 100px">
                                                    @if ($document['uploaded'])
                                                        <span class="badge badge-success">{{ trans('worker-registration/worker-documents-details.Uploaded') }}</span>
                                                    @else
                                                        <span class="badge badge-warning">{{ trans('worker-registration/worker-documents-details.pending') }}</span>
                                                    @endif
                                                </td>
                                                <td class="fixed-width text-center align-middle">
                                                    <form id="form-{{ $document['id'] }}"
                                                          action="{{ route('save-document-details') }}" method="POST"
                                                          enctype="multipart/form-data">
                                                        @csrf
                                                        <input type="hidden" name="document_id"
                                                               value="{{ $document['id'] }}">
                                                        <div class="text-center">
                                                            <button id="file-input-button-{{ $document['id'] }}"
                                                                    class="btn btn-primary btn-sm" type="button">{{ trans('worker-registration/worker-documents-details.choose') }}
                                                            </button>
                                                            <input id="file-input-{{ $document['id'] }}" type="file"
                                                                   class="d-none" name="{{ $document['name'] }}" accept="application/pdf">
                                                        </div>
                                                        <div id="file-preview-{{ $document['id'] }}"
                                                             class="mt-3 d-none">
                                                            <div>
                                                                <div>
                                                                    <p class="mb-1 fw-bold"
                                                                       id="file-name-{{ $document['id'] }}"></p>
                                                                    <p class="mb-0 small text-muted"
                                                                       id="file-size-{{ $document['id'] }}"></p>
                                                                </div>
                                                            </div>
                                                            <div class="progress mt-2">
                                                                <div id="upload-progress-{{ $document['id'] }}"
                                                                     class="progress-bar" role="progressbar"
                                                                     style="width: 0%;" aria-valuenow="0"
                                                                     aria-valuemin="0" aria-valuemax="100">0%</div>
                                                            </div>
                                                            <div>
                                                                <p id="error-message-{{ $document['id'] }}"
                                                                   class="text-danger mt-2 d-none">{{ trans('worker-registration/worker-documents-details.fileexceed') }}
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </td>
                                                <td class="fixed-width text-center align-middle">
                                                    <div>
                                                        @if ($document['id'] == 1 && $document['uploaded'])
                                                            <a class="btn btn-danger btn-sm" target="_blank"
                                                               href="{{ route('get-res-proof', ['id' => mt_rand(1, 1000)]) }}">
                                                                <i class="fa fa-eye" aria-hidden="true"></i>
                                                            </a>
                                                        @elseif ($document['id'] == 2 && $document['uploaded'])
                                                            <a class="btn btn-danger btn-sm" target="_blank"
                                                               href="{{ route('get-bank-copy', ['id' => mt_rand(1, 1000)]) }}">
                                                                <i class="fa fa-eye" aria-hidden="true"></i>
                                                            </a>
                                                        @elseif ($document['id'] == 3 && $document['uploaded'])
                                                            <a class="btn btn-danger btn-sm" target="_blank"
                                                               href="{{ route('get-ration_card', ['id' => mt_rand(1, 1000)]) }}">
                                                                <i class="fa fa-eye" aria-hidden="true"></i>
                                                            </a>
                                                        @elseif ($document['id'] == 4 && $document['uploaded'])
                                                            <a class="btn btn-danger btn-sm" target="_blank"
                                                               href="{{ route('nominee_bank_copy', ['id' => mt_rand(1, 1000)]) }}">
                                                                <i class="fa fa-eye" aria-hidden="true"></i>
                                                            </a>
                                                        @elseif ($document['id'] == 5 && $document['uploaded'])
                                                            <a class="btn btn-danger btn-sm" target="_blank"
                                                               href="{{ route('get-pan_card', ['id' => mt_rand(1, 1000)]) }}">
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
                                    <tr>
                                        <td class="text-center align-middle">{{ $serialNumber }}</td>
                                        <td class="fixed-width font-weight-bold align-middle">{{ trans('worker-registration/worker-documents-details.passportimg') }}&nbsp;<span
                                                class="text-danger">({{ trans('worker-registration/worker-documents-details.aadhaar') }})</span></td>
                                        <td colspan="5" class="text-center align-middle">
                                            @if (!empty($base64Image))
                                                <img src="data:image/jpeg;base64,{{ $base64Image }}"
                                                     alt="User Photo" class="bordered-image"
                                                     style="border: 1px solid grey;">
                                            @else
                                                <p>{{ trans('worker-registration/worker-documents-details.nophoto') }}</p>
                                            @endif
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>

                            </div>

                            <div class="d-flex justify-content-center align-items-center mt-4 mx-4">

                                <div>
                                    <input class="styled-checkbox" type="checkbox" id="termsCheck" required>
                                </div>

                                <div class="" style=" display: flex;justify-content: center;">

                                    <span style="color: red;" class="text-danger">*</span>&nbsp<p class="">{{ trans('worker-registration/worker-documents-details.declaration') }}

                                    </p>
                                </div>

                            </div>


                            <div class="d-flex justify-content-center mt-4">
                                <form action="{{ route('save-document-details') }}" method="post"
                                      enctype="multipart/form-data">
                                    @csrf
                                    <div class="d-flex justify-content-between align-items-center mb-1 clearfix mt-4">
                                        <div class="ml-auto d-inline-block align-self-center mr-2">
{{--                                            <a type="submit" href="{{ route('scheme-details') }}"--}}
{{--                                               class="btn btn-sm btn-warning"><i class="fa fa-backward"--}}
{{--                                                                                 aria-hidden="true"></i>&nbsp;Previous Page</a>--}}
                                            <button type="submit" class="btn btn-sm btn-success" id="submitAll"
                                                    disabled> <i class="fa fa-check-circle" aria-hidden="true"></i>&nbsp;Update Documents
                                            </button>
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

@endsection


@section('footer')
    <script src="{{ URL::asset('assets/template/js/worker-documents-styles.js') }}"></script>


    <script>
        function validateFileSize(input) {
            const file = input.files[0];
            const maxSizeKB = 500; // Maximum size allowed in KB
            const minSizeKB = 5; // Minimum size allowed in KB

            // Check file type
            if (!file.type.startsWith('application/pdf')) {
                alert("Please select a PDF file.");
                input.value = '';
                return false;
            }

            // Check file size
            const fileSizeKB = file.size / 1024; // Convert bytes to KB
            if (fileSizeKB < minSizeKB || fileSizeKB > maxSizeKB) {
                alert(`File size must be between ${minSizeKB}KB and ${maxSizeKB}KB.`);
                input.value = '';
                return false;
            }

            return true;
        }
    </script>





    <script>
        $(document).ready(function() {
            let totalDocuments = 0;
            let uploadedDocuments = 0;

            @foreach ($documents as $document)

                @if ($document['id'])
                @if (
                    ($document['id'] != 1 || !$has_do_address) &&
                        ($document['id'] != 4 || $has_ration_card) &&
                        ($document['id'] != 5 || $has_pan))
                totalDocuments++;

            @if ($document['uploaded'])
                uploadedDocuments++;
            @endif
            @endif
            @endif
            @endforeach

            console.log('Total Documents: ', totalDocuments);
            console.log('Uploaded Documents: ', uploadedDocuments);

            function checkConditions() {
                console.log('Check Conditions - Uploaded: ', uploadedDocuments, ' Total: ', totalDocuments);
                if (uploadedDocuments === totalDocuments && $('#termsCheck').is(':checked')) {
                    $('#submitAll').prop('disabled', false);
                } else {
                    $('#submitAll').prop('disabled', true);
                }
            }

            $('#termsCheck').on('change', function() {
                checkConditions();
            });

            $('form').on('submit', function() {
                uploadedDocuments++;
                console.log('Form submitted, uploadedDocuments incremented: ', uploadedDocuments);
                checkConditions();
            });

            checkConditions();

            $('#submitAll').on('click', function(event) {
                event.preventDefault();
                console.log('Submit button clicked');
                window.location.href = "{{ route('preview-renewal-application') }}";
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
                    const filePreview = document.getElementById(`file-preview-${id}`);
                    const fileNameElement = document.getElementById(`file-name-${id}`);
                    const fileSizeElement = document.getElementById(`file-size-${id}`);
                    const progressBar = document.getElementById(`upload-progress-${id}`);
                    const errorMessage = document.getElementById(`error-message-${id}`);
                    const form = document.getElementById(`form-${id}`);

                    if (file) {
                        const fileSizeKB = file.size / 1024;
                        const fileType = file.type;

                        // Validate file type
                        if (fileType !== 'application/pdf') {
                            alert('Only PDF files are allowed.');
                            errorMessage.textContent = 'Invalid file type. Only PDF files are allowed.';
                            errorMessage.classList.remove('d-none');
                            progressBar.style.width = '0%';
                            progressBar.setAttribute('aria-valuenow', '0');
                            progressBar.textContent = '0%';
                            filePreview.classList.add('d-none');
                            return; // Stop further execution
                        }

                        // Validate file size
                        if (fileSizeKB > 500 || fileSizeKB < 5) {
                            if (fileSizeKB > 500) {
                                alert('File Size Should Not Exceed 500 KB');
                            } else if (fileSizeKB < 5) {
                                alert('File Size Should be more than 5 KB');
                            } else {
                                alert('Only PDF files are allowed');
                            }
                            errorMessage.textContent = 'File size must be between 5KB and 500KB.';
                            errorMessage.classList.remove('d-none');
                            progressBar.style.width = '0%';
                            progressBar.setAttribute('aria-valuenow', '0');
                            progressBar.textContent = '0%';
                            filePreview.classList.add('d-none');
                        } else {
                            errorMessage.classList.add('d-none');
                            fileNameElement.textContent = file.name;
                            fileSizeElement.textContent = `Size: ${fileSizeKB.toFixed(2)} KB`;
                            progressBar.style.width = '0%';
                            progressBar.setAttribute('aria-valuenow', '0');
                            progressBar.textContent = '0%';
                            filePreview.classList.remove('d-none');

                            let progress = 0;
                            const interval = setInterval(() => {
                                progress += 10;
                                progressBar.style.width = `${progress}%`;
                                progressBar.setAttribute('aria-valuenow', progress);
                                progressBar.textContent = `${progress}%`;

                                if (progress >= 100) {
                                    clearInterval(interval);
                                    form.submit();
                                }
                            }, 200);
                        }
                    }
                }
            });

            document.addEventListener('click', function(event) {
                if (event.target && event.target.matches('[id^="remove-file-"]')) {
                    const id = event.target.id.split('-').pop();
                    document.getElementById(`file-input-${id}`).value = '';
                    document.getElementById(`file-preview-${id}`).classList.add('d-none');
                }
            });
        });
    </script>

@endsection
