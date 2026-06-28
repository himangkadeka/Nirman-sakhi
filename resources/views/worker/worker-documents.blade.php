@extends('layouts.user-app')

@section('title', ' Home')

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
        .bold {
            font-weight: 500;
            font-family: "Montserrat Alternates", "Open Sans", Helvetica, Arial, sans-serif;
            font-size: 14px;
            /*color: #186cb8;*/
            color: #219fa4;
            /*color: #7ea1a2;*/
        }
        .revert-summary-box {
            background-color: #fdfdfd;
            padding: 20px;
            margin-top: 20px;
            border-left: 5px solid #dc3545;
            border-radius: 8px;
            box-shadow: 0 1px 6px rgba(0, 0, 0, 0.05);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            max-width: 700px;
        }

        .section-title {
            font-weight: 600;
            font-size: 16px;
            margin-bottom: 10px;
        }

        .revert-reasons-list {
            list-style: disc inside;
            margin: 0;
            padding-left: 0;
        }

        .revert-reasons-list li {
            margin-bottom: 5px;
            font-size: 14px;
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
                    </div>
                </div>
            </nav>
            <div class="card mt-1">
                <div class="card-body">

                    <div class="container-fluid">
                        <div class="d-flex justify-content-center align-items-center mb-3">
                            <span>
                                <i class="fa fa-user" aria-hidden="true"></i>
                                {{ trans('worker-registration/worker-family-details.workername') }}
                                - {{ $getVaultData['name'] }}
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
                                <div class="revert-summary-box ml-2 mt-2">
                                    <div class="section">
                                        <h6 class="section-title text-primary">For the following reasons application has been reverted:</h6>
                                        <ul class="revert-reasons-list">
                                            @foreach ($remarks->getReasons($remarks->worker_id) as $remark)
                                                <li class="text-danger">{{ $remark->reason }}</li>
                                            @endforeach
                                        </ul>
                                    </div>

                                    <div class="section mt-3">
                                        <h6 class="section-title text-primary">Remarks from Officers</h6>
                                        <p class="text-danger">{{ $remarks->remarks }}</p>
                                    </div>
                                </div>
                            @endif

                            <div class="mr-2 mt-3 ml-2"
                                style="background-color: #f9f9f9; padding: 10px; border-radius: 5px; border: 1px solid #ccc; color: #333;">
                                <p style="margin: 0;">
                                    <strong>{{ trans('worker-registration/worker-documents-details.note') }}:</strong>
                                </p>
                                <p style="margin: 0;">
                                    <strong>{{ trans('worker-registration/worker-documents-details.1') }}</strong><span
                                        class="text-danger">
                                        {{ trans('worker-registration/worker-documents-details.mandatory') }}</span>
                                </p>
                                <p style="margin: 0;">
                                    <strong>{{ trans('worker-registration/worker-documents-details.2') }}</strong><span
                                        class="text-danger">
                                        {{ trans('worker-registration/worker-documents-details.mandatory2') }} </span>
                                </p>
                            </div>


                            <div class="table-container mt-4" style="overflow-x:auto;">
                                <table class="table table-bordered my-table-class">
                                    <thead>
                                        <tr style="background-color:rgb(164, 206, 221)">
                                            <th class="text-center align-middle" scope="col">
                                                {{ trans('worker-registration/worker-documents-details.sno') }}</th>
                                            <th class="text-center align-middle" scope="col">
                                                {{ trans('worker-registration/worker-documents-details.documenttype') }}
                                            </th>
                                            <th class="text-center align-middle" scope="col">
                                                {{ trans('worker-registration/worker-documents-details.status') }}</th>
                                            <th class="text-center align-middle">
                                                {{ trans('worker-registration/worker-documents-details.upload') }}</th>
                                            <th class="text-center align-middle">
                                                {{ trans('worker-registration/worker-documents-details.preview') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $serialNumber = 1;
                                        @endphp
                                        @foreach ($documents as $document)
                                            @if (
                                                ($document['id'] != 3 || $has_ration_card) &&
                                                    ($document['id'] != 5 || $has_pan) &&
                                                    ($document['id'] != 1 || !$has_do_address) && ($document['id'] != 1 || !$has_type_of_document))
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
                                                            action="{{ route('save-worker-documents') }}" method="POST"
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
                                                        <button type="button" class="btn btn-danger"
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
                                    </tbody>
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
                                            <a type="submit" href="{{ route('submit-employer-details') }}"
                                                class="btn btn-sm btn-warning"><i class="fa fa-backward"
                                                    aria-hidden="true"></i>&nbsp;
                                                {{ trans('worker-registration/worker-documents-details.previous') }} </a>
                                            <button type="submit" class="btn btn-sm btn-success" id="submitAll"
                                                disabled> <i class="fa fa-check-circle" aria-hidden="true"></i>&nbsp;
                                                {{ trans('worker-registration/worker-documents-details.save&preview') }}
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
                    @if (($document['id'] != 1 || !$has_do_address) && ($document['id'] != 1 || !$has_type_of_document) && ($document['id'] != 3 || $has_ration_card) && ($document['id'] != 5 || $has_pan))
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
                window.location.href = "{{ route('submit-document-details') }}";
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
