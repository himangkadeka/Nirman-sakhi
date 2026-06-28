@extends('layouts.user-app')

@section('title', 'Renewal|Update')

@section('style')
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">

    <style>
        #imagePreview {
            max-width: 50%;
            max-height: 50%;
            width: auto;
            height: auto;
        }

        .image-upload {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        #pdf-preview {
            width: 100%;
            height: 400px;
            /* Adjust height as needed */
            border: none;
        }

        #declarationPreview {
            max-width: 100%;
            max-height: 100%;
            width: auto;
            height: auto;
        }

        .hidden {
            display: none;
        }

        #imageInput {
            margin-bottom: 10px;
        }

        .custom-bottom-border {
            border-top: none !important;
            border-right: none !important;
            border-left: none !important;
            border-bottom: none !important;
            /*border-bottom: 1px solid #ced4da; !* You can customize the color *!*/
            border-radius: 0 !important;
            /* Remove border-radius if needed */
        }

        .bg-light-gray {
            background-color: #f0f0f0
        }

        .table,
        td {
            font-size: 13px;
        }

        .bold {
            font-weight: 400;
            font-family: "Montserrat Alternates", "Open Sans", Helvetica, Arial, sans-serif;
            font-size: 13px;
            /*color: #186cb8;*/
            color: #219fa4;
            /*color: #7ea1a2;*/
        }

        .form-control.custom-bottom-border.bold {
            background-color: #f0f0f0;
            /* Light gray background color */
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

        .form-content {
            width: 50%;
            padding: 20px;
            background-color: rgb(222, 222, 230);
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
            .form-content-thumb{
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
            background-color: rgb(219, 226, 232); /* Light gray */
        }

        .my-table-class tbody tr:nth-child(even) {
            background-color: #ffffff; /* White */
        }
        .btn-primary {
            background-color: #0f4547;
        }


    </style>
@endsection

@section('content')

    <div class="container-fluid mb-4">
        <div class="row">
        {{--    <div class="col-md-2"></div> --}}
        <!-- Left side columns -->
            <div class="col-md-12">
                <nav class="custom-navbar navbar-light bg-light p-3" style="border-radius: 20px;">
                    <div class="custom-container">
                        <div class="custom-flex-container">
                            <div class="custom-left-content">
                                <h6 class="custom-heading">Renewal - Construction Worker</h6>
                                <h6 class="custom-bold">
                                    <i class="custom-icon fas fa-file-alt pr-2"></i>Application No - {{ $application_no }}
                                </h6>
                            </div>
{{--                            <div class="custom-right-content">--}}
{{--                                <h6 class="custom-heading">--}}
{{--                                    <i class="custom-icon fas fa-clock"></i> Session Uptime ---}}
{{--                                </h6>--}}
{{--                            </div>--}}
                        </div>
                    </div>
                </nav>
                <div class="card mt-3">
                    <div class="card-body">
                        <div class="container mt-2">
                            <div class="card rounded-card">
                                <div class="card-header card-header-bg text-white d-flex justify-content-between align-items-center" style="background-color: #248f8f;">
                <span>
                    <i class="fa fa-plus-circle" aria-hidden="true"></i>&nbsp; Update Scheme Details
                </span>
                                </div>
                        <h4 class="d-flex">
                            <i class="fa fa-bullhorn" aria-hidden="true"></i>&nbspNote: All fields are mandatory:
                        </h4>
                        <p class="text-danger ml-2 mb-0"><i class="fa fa-check-circle" aria-hidden="true"></i>&nbspFor PDF File
                            the size should not exceed 500kb</p>
                        <p class="text-danger ml-2"><i class="fa fa-check-circle" aria-hidden="true"></i>&nbspFor Image File the
                            size should be between 20kb to 150kb</p>
                        <div class="table-container mt-4 ml-2 mr-2">
                            <table class="table table-responsive table-bordered my-table-class">
                                <thead>
                                <tr style="background-color:rgb(164, 206, 221)">
                                    <th scope="col">Sl.No</th>
                                    <th scope="col">Type Of Documents</th>
                                    <th></th>
                                    <th scope="col">Status</th>
                                    <th></th>
                                    <th></th>
                                </tr>
                                </thead>
                                <tbody>
                                @php
                                    $serialNumber = 1;
                                @endphp
                                @foreach ($documents as $document)
                                    @if (!in_array($document['id'], [6, 7])) {{-- Exclude document IDs 6 and 7 --}}
                                    @if (($document['id'] != 8 || $has_ration_card) && ($document['id'] != 10 || $has_pan))
                                    <tr>
                                        <td>{{ $serialNumber }}</td>
                                        <td class="bold align-middle" style="width: 300px">{{ $document['label'] }}</td>
                                        <td class="bold align-middle" style="width: 300px">
                                            @if (in_array($document['id'], [3, 5]))
                                                {{-- Check for Age Proof (3) or Certificate Proof (5) --}}
                                                @if ($document['id'] == 3)
                                                    <select required name="age_proof_id" form="form-{{ $document['id'] }}"
                                                            class="form-control fixed custom-bottom-border bg-light-gray">
                                                        @if (isset($twd->age_proof_id))
                                                            <option value="{{ $twd->age_proof_id }}">{{ $twd->age_proof_name }}</option>
                                                        @else
                                                            <option value="">Select Age Proof</option>
                                                        @endif
                                                        @foreach ($age_proof as $age)
                                                            <option value="{{ $age->age_proof_code }}">{{ $age->age_proof_name }}</option>
                                                        @endforeach
                                                    </select>
                                                @elseif ($document['id'] == 5)
                                                    <select required name="certificate_id" form="form-{{ $document['id'] }}"
                                                            class="form-control fixed custom-bottom-border bg-light-gray">
                                                        @if (isset($twd->certificate_id))
                                                            <option value="{{ $twd->certificate_id }}">{{ $twd->issuer_name }}</option>
                                                        @else
                                                            <option value="">Select Certificate Proof</option>
                                                        @endif
                                                        @foreach ($type_of_issuer as $issuer)
                                                            <option value="{{ $issuer->issuer_code }}">{{ $issuer->issuer_name }}</option>
                                                        @endforeach
                                                    </select>
                                                @endif
                                            @endif
                                        </td>
                                        <td class="bold align-middle" id="status-{{ $document['id'] }}"  style="width: 300px">
                                            @if($document['uploaded'])
                                                <span class="badge badge-success">Uploaded</span>
                                            @else
                                                <span class="badge badge-warning">Pending</span>
                                            @endif
                                        </td>
                                        <td class="bold align-middle"  style="width: 300px">
                                            <form id="form-{{ $document['id'] }}" action="{{ route('save-document-details') }}"
                                                  method="POST" enctype="multipart/form-data">
                                                @csrf
                                                <input type="hidden" name="document_id" value="{{ $document['id'] }}">
                                                <div class="input-group mr-2">
                                                    <div class="custom-file">
                                                        <input type="file" name="{{ $document['name'] }}" id="{{ $document['name'] }}"
                                                               class="custom-file-input {{ $readonly ? 'readonly' : '' }}" required>
                                                        <label class="custom-file-label" for="{{ $document['name'] }}"></label>
                                                    </div>
                                                </div>
                                        <td class="bold align-middle"  style="width: 300px; display:flex">
                                            <div class="form-button">
                                                <button type="submit" class="btn btn-sm {{ $document['uploaded'] ? 'btn-success' : 'btn-primary' }} mr-2" id="upload-{{ $document['id'] }}">
                                                    {{ $document['uploaded'] ? 'Update ' : 'Upload ' }}
                                                </button>
                                            </div>
                                            <div>
                                                @if ($document['id'] == 1 && $document['uploaded'])
                                                    <a class="btn btn-danger btn-sm" target="_blank"
                                                       href="{{ route('view-id-proof', ['id' => mt_rand(1, 1000)]) }}">
                                                        <i class="fa fa-eye" aria-hidden="true"></i>
                                                    </a>
                                                @elseif ($document['id'] == 2 && $document['uploaded'])
                                                    <a class="btn btn-danger btn-sm" target="_blank"
                                                       href="{{ route('view-res-proof', ['id' => mt_rand(1, 1000)]) }}">
                                                        <i class="fa fa-eye" aria-hidden="true"></i>
                                                    </a>
                                                @elseif ($document['id'] == 3 && $document['uploaded'])
                                                    <a class="btn btn-danger btn-sm" target="_blank"
                                                       href="{{ route('view-age-proof', ['id' => mt_rand(1, 1000)]) }}">
                                                        <i class="fa fa-eye" aria-hidden="true"></i>
                                                    </a>
                                                @elseif ($document['id'] == 4 && $document['uploaded'])
                                                    <a class="btn btn-danger btn-sm" target="_blank"
                                                       href="{{ route('view-bank-copy', ['id' => mt_rand(1, 1000)]) }}">
                                                        <i class="fa fa-eye" aria-hidden="true"></i>
                                                    </a>
                                                @elseif ($document['id'] == 5 && $document['uploaded'])
                                                    <a class="btn btn-danger btn-sm" target="_blank"
                                                       href="{{ route('view-cert-proof', ['id' => mt_rand(1, 1000)]) }}">
                                                        <i class="fa fa-eye" aria-hidden="true"></i>
                                                    </a>
                                                @elseif ($document['id'] == 8 && $document['uploaded'])
                                                    <a class="btn btn-danger btn-sm" target="_blank"
                                                       href="{{ route('view-ration_card', ['id' => mt_rand(1, 1000)]) }}">
                                                        <i class="fa fa-eye" aria-hidden="true"></i>
                                                    </a>
                                                @elseif ($document['id'] == 9 && $document['uploaded'])
                                                    <a class="btn btn-danger btn-sm" target="_blank"
                                                       href="{{ route('view-nominee-bank-copy', ['id' => mt_rand(1, 1000)]) }}">
                                                        <i class="fa fa-eye" aria-hidden="true"></i>
                                                    </a>
                                                @elseif ($document['id'] == 10 && $document['uploaded'])
                                                    <a class="btn btn-danger btn-sm" target="_blank"
                                                       href="{{ route('view-pan-card', ['id' => mt_rand(1, 1000)]) }}">
                                                        <i class="fa fa-eye" aria-hidden="true"></i>
                                                    </a>
                                                @endif
                                            </div>
                                        </td>
                                        </form>
                                        </td>
                                    </tr>
                                    @php
                                        $serialNumber++;
                                    @endphp
                                    @endif
                                    @endif
                                @endforeach

                                </tbody>
                            </table>
                        </div>


                        <div class="container">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="card mt-2 border-top border-dark-green" style="-webkit-box-shadow: -2px 2px 1px 1px rgba(128, 128, 128, 1) !important; -moz-box-shadow: -2px 2px 0px 1px rgba(128, 128, 128, 1) !important;
                                     box-shadow: 2px 2px 0px 1px rgba(128, 128, 128, 1) !important;">
                                        <div class="card-body">
                                            <div class="justify-content-center">
                                                <h4>Image Upload</h4>
                                            </div>
                                            <p class="text-danger justify-content-center"><i class="fa fa-check-circle" aria-hidden="true"></i>&nbspFor Image File the
                                                size should be between 20kb to 120kb</p>

                                            <div class="row">
                                                @foreach ($documents as $document)
                                                    @if ($document['id'] == 6)
                                                        <div class="col-md-6">
                                                            <form action="{{ route('save-document-details') }}" method="post"
                                                                  enctype="multipart/form-data">
                                                                @csrf
                                                                <div class="row justify-content-center">
                                                                    <h6 class="form-heading ml-2">Applicant Photograph</h6><span
                                                                        class="text-danger">*</span>
                                                                </div>
                                                                <div class="form-image-container">
                                                                    <img id="passportPreview"
                                                                         src="{{ route('view-worker-passport', ['id' => mt_rand(1, 1000)]) }}"
                                                                         class="form-image"
                                                                         onerror="this.onerror=null; this.src='https://www.kurin.com/wp-content/uploads/placeholder-square.jpg';" />
                                                                </div>
                                                                <div class="form-controls mt-2"
                                                                     style="display: flex; justify-content: center; align-items: center">
                                                                    <div class="form-input">
                                                                        <input accept="image/*" type="hidden" name="document_id"
                                                                               value="6">
                                                                        <input id="passportInput" required type="file" accept="image/*"
                                                                               name="passport_image" onchange="validateImage(this)">
                                                                    </div>
                                                                    <div class="form-button">
                                                                        <button class="btn btn-primary btn-sm"
                                                                                type="submit">Upload</button>
                                                                    </div>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    @elseif($document['id'] == 7)
                                                        <div class="col-md-6">
                                                            <form action="{{ route('save-document-details') }}" method="post"
                                                                  enctype="multipart/form-data">
                                                                @csrf
                                                                <div class="row justify-content-center">
                                                                    <h6 class="text-center ml-2">Applicant Thumb Photograph</h6><span
                                                                        class="text-danger">*</span>
                                                                </div>
                                                                <div class="form-image-container">
                                                                    <img id="thumbPreview"
                                                                         src="{{ route('view-thumb', ['id' => mt_rand(1, 1000)]) }}"
                                                                         class="form-image1"
                                                                         onerror="this.onerror=null; this.src='https://www.kurin.com/wp-content/uploads/placeholder-square.jpg';" />
                                                                </div>
                                                                <div class="form-controls mt-2"
                                                                     style="display: flex; justify-content: center; align-items: center">
                                                                    <div class="form-input">
                                                                        <input accept="image/*" type="hidden" name="document_id"
                                                                               value="7">
                                                                        <input id="thumbInput" required type="file" accept="image/*"
                                                                               name="thumb_image" onchange="validateThumb(this)">
                                                                    </div>
                                                                    <div class="form-button">
                                                                        <button class="btn btn-primary btn-sm"
                                                                                type="submit">Upload</button>
                                                                    </div>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    @endif
                                                @endforeach
                                            </div>


                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>



{{--                        <div class="form-row mt-4" style="">--}}
{{--                            <div class="form-group col-md-1">--}}
{{--                            </div>--}}
{{--                            <div class="form-group col-md-1"--}}
{{--                                 style="display: flex; justify-content: right; padding-right: 15px;">--}}
{{--                                <input class="form-check-input mt-5 styled-checkbox" type="checkbox"--}}
{{--                                       id="termsCheck">--}}
{{--                            </div>--}}

{{--                            <div class="form-group col-md-9" style=" display: flex;justify-content: center;">--}}

{{--                                <span style="color: red;">*</span>&nbsp<p class=" lead">I hereby declare--}}
{{--                                    that the information /--}}
{{--                                    documents provided in--}}
{{--                                    above form is true &--}}
{{--                                    correct to the best of my--}}
{{--                                    knowledge and belief and--}}
{{--                                    nothing has been falsely--}}
{{--                                    stated. In case any of the--}}
{{--                                    above information is--}}
{{--                                    found to be false or untrue--}}
{{--                                    or misleading or--}}
{{--                                    misrepresenting, I am--}}
{{--                                    aware that I may be held--}}
{{--                                    liable for it.--}}
{{--                                </p>--}}
{{--                            </div>--}}
{{--                            <div class="form-group col-md-1">--}}
{{--                            </div>--}}
{{--                        </div>--}}


                                <div class="d-flex justify-content-between align-items-center mb-3 clearfix mt-4">

                                    <div class="ml-auto d-inline-block align-self-center mr-2">
                                        <a type="submit" href="{{route('scheme-details')}}"
                                           class="btn btn-sm btn-warning"><i class="fa fa-backward" aria-hidden="true"></i>&nbsp;
                                            Previous</a>
                                        <a type="submit" href="{{route('preview-renewal-application')}}"
                                                class="btn btn-sm btn-primary"><i class="fa fa-check-circle" aria-hidden="true"></i>&nbsp;
                                            Save & Preview</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    </div>
                </div>
            </div>
        </div><!-- End Left side columns -->

    <!-- Preview Modal -->
    <div class="modal fade" id="previewModal" tabindex="-1" role="dialog" aria-labelledby="previewModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="previewModalLabel">PDF Preview</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <iframe id="pdf-preview" src="" width="100%" height="100%" frameborder="0"></iframe>
                </div>
            </div>
        </div>
    </div>

@endsection


@section('footer')

    <script>
        function validateImage(input) {
            const file = input.files[0];
            const maxSizeKB = 120;
            const minSizeKB = 10;

            // Check if file is an image
            if (!file.type.startsWith('image/')) {
                alert("Please select an image file.");
                input.value = '';
                return;
            }

            // Check file size
            const fileSizeKB = file.size / 1024; // Convert bytes to KB
            if (fileSizeKB < minSizeKB || fileSizeKB > maxSizeKB) {
                alert(`Image size must be between ${minSizeKB}KB and ${maxSizeKB}KB.`);
                input.value = '';
                return;
            }

            // You can perform additional actions here, such as previewing the image
            previewImage(input);
        }
        function previewImage() {
            const imageInput = document.getElementById('passportInput');
            const imagePreview = document.getElementById('passportPreview');
            if (imageInput.files && imageInput.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    imagePreview.src = e.target.result;
                };
                reader.readAsDataURL(imageInput.files[0]);
            } else {
                imagePreview.src = '';
            }
        }
    </script>

    <script>
        function validateThumb(input) {
            const file = input.files[0];
            const maxSizeKB = 120;
            const minSizeKB = 10;

            // Check if file is an image
            if (!file.type.startsWith('image/')) {
                alert("Please select an image file.");
                input.value = '';
                return;
            }

            // Check file size
            const fileSizeKB = file.size / 1024; // Convert bytes to KB
            if (fileSizeKB < minSizeKB || fileSizeKB > maxSizeKB) {
                alert(`Image size must be between ${minSizeKB}KB and ${maxSizeKB}KB.`);
                input.value = '';
                return;
            }

            // You can perform additional actions here, such as previewing the image
            previewThumb(input);
        }

        function previewThumb() {
            const thumbInput = document.getElementById('thumbInput');
            const thumbPreview = document.getElementById('thumbPreview');

            if (thumbInput.files && thumbInput.files[0]) {
                const reader = new FileReader();

                reader.onload = function(e) {
                    thumbPreview.src = e.target.result;
                };

                reader.readAsDataURL(thumbInput.files[0]);
            } else {
                thumbPreview.src = '';
            }
        }
    </script>

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
        let rotation = 0;

        function rotateImage(degrees) {
            rotation += degrees;
            document.getElementById('imagePreview').style.transform = `rotate(${rotation}deg)`;
        }
        document.addEventListener("DOMContentLoaded", function() {
            const rotate90degree = document.getElementById('rotate90degree');
            const rotateminus90degree = document.getElementById('rotateminus90degree');
            rotate90degree.addEventListener('click', function(event) {
                event.preventDefault();
            });
            rotateminus90degree.addEventListener('click', function(event) {
                event.preventDefault();
            });
        });
    </script>
    <script>
        // Show loader and overlay
        function showLoader() {
            document.querySelector('.loader-container').style.display = 'block';
            document.querySelector('.overlay').style.display = 'block';
        }

        // Hide loader and overlay
        function hideLoader() {
            document.querySelector('.loader-container').style.display = 'none';
            document.querySelector('.overlay').style.display = 'none';
        }

        // Show loader initially
        showLoader();

        document.addEventListener('DOMContentLoaded', function() {
            setTimeout(function() {
                hideLoader();
            }, 100);
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
@endsection
