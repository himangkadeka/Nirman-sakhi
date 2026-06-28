@extends('layouts.admin-app')

@section('title', 'Admin | INDEX NOTIFICATION | ADD NOTIFICATION')
@section('breadcrumb_item_1', 'Notification')
@section('breadcrumb_item_2', 'Create')

@section('content')

    <div class="container-fluid">

        <h4 class="text-left mb-3">ADD NOTIFICATION</h4>
        <form action="{{ route('admin.index_notification.store') }}"
            data-action="{{ route('admin.index_notification.store') }}" method="POST" class="add-image-form"
            enctype="multipart/form-data">

            <div class="row" id="card-container">
                <!-- Initial Upload Card -->
                <div class="col-md-4 mb-4">
                    <div class="card">
                        <div class="card-body">
                            @csrf



                            <!-- Category Dropdown -->
                            <div class="form-group">
                                <label for="caption">Category</label>
                                <select name="category[]" id="category" class="form-control"
                                    onchange="toggleYearDropdown()">
                                    <option value="">Select Category</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->category_name }}
                                        </option>
                                    @endforeach

                                </select>
                            </div>

                            <!-- Year Dropdown -->
                            {{-- <div class="form-group" id="year-group" style="display: none;">
                                <label for="caption">Year</label>
                                <select id="year" name="year[]" class="form-control"
                                    onchange="toggleBenefitDropdown()">
                                    <option value="">Select Year</option>
                                    @foreach (range(2020, 2025) as $year)
                                        <option value="{{ $year }}">{{ $year }}</option>
                                    @endforeach
                                </select>
                            </div> --}}
                            <div class="form-group" id="year-group" style="display: none;">
                                <label for="caption">Year</label>
                                <select id="year" name="year[]" class="form-control" onchange="toggleBenefitDropdown()">
                                    <option value="">Select Year</option>
                                    @foreach ($years as $year)
                                    <option value="{{ $year }}">{{ $year }}</option>
                                @endforeach

                                </select>
                            </div>


                            <!-- Benefit/ District Dropdown -->
                            <div class="form-group" id="benefit-group" style="display: none;">
                                <label for="benefit" id="benefit-label">Select Option</label>
                                <select name="benefit_id" id="benefit_id" class="form-control">
                                    <option value="">Select Benefit</option>
                                    @foreach ($benefits as $benefit)
                                        <option value="{{ $benefit->id }}">{{ $benefit->benefit_name }}</option>
                                    @endforeach
                                </select>
                            </div>









                            <!-- District Dropdown - Initially Hidden -->
                            <div class="form-group w-50" id="district-group" style="display: none;">
                                <label for="district_name">{{ trans('pfcdetails.SelectDistrict') }}<span
                                        style="color: red;">*</span>:</label>
                                <select class="form-control" id="district_name" name="district_name[]">
                                    <option value="" selected disabled>--Select District--</option>
                                    <option value="ALL">All Districts</option> <!-- 👈 Add this line -->
                                    @foreach ($districts as $district)
                                        <option value="{{ $district->district_code }}">{{ $district->district_name }}
                                        </option>
                                    @endforeach
                                </select>
                                <div class="invalid-feedback" id="district_name_error">
                                    {{ trans('pfcdetails.pleaseselect') }}
                                </div>
                                @if ($errors->has('district_name'))
                                    <span class="text-danger font-weight-bold">
                                        {{ $errors->first('district_name') }}
                                    </span>
                                @endif
                            </div>


                            <div class="form-group">
                                <label for="pdf_path">PDF Upload:</label>
                                <input type="file" name="pdf_path[]" class="form-control-file" id="pdf_path0"
                                    accept="application/pdf" onchange="previewPDF(this, 'pdf-preview0')">
                                <div id="pdf-preview0" class="mt-2" style="display: none;">
                                    <a href="#" id="pdf-link0" target="_blank">View PDF</a>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="caption">Caption</label>
                                <textarea name="caption[]" class="form-control" rows="3"></textarea>
                            </div>





                        </div>
                    </div>
                </div>

                <!-- Plus Icon Card -->
                <div class="col-md-4 mb-4">
                    <div class="card bg-primary text-white text-center plus-icon-card" id="plus-icon-card"
                        style="height:400px;">
                        <div class="card-body" style="display:flex; justify-content:center; align-items:center">
                            <i class="fas fa-plus fa-5x"></i>
                        </div>
                    </div>
                </div>
            </div>


            <button type="submit" class="btn btn-primary mb-3" id="submit-form">Add PDF</button>
        </form>
    </div>


    <script>
        // Correct PDF Preview with Dynamic IDs
        function previewPDF(input, previewId) {
            var preview = document.getElementById(previewId);
            var link = preview.querySelector("a");

            if (input.files && input.files[0]) {
                var file = input.files[0];

                if (file.type === "application/pdf") {
                    var objectURL = URL.createObjectURL(file);
                    link.href = objectURL;
                    link.textContent = file.name;
                    preview.style.display = "block";
                } else {
                    alert("Please upload a valid PDF file.");
                    input.value = ""; // Clear input if invalid
                    preview.style.display = "none";
                }
            }
        }

        // Handle Adding New Upload Fields
        let cardId = 1; // Start with 1 because initial card is 0
        document.getElementById('plus-icon-card').addEventListener('click', function() {
            var newCard = document.createElement('div');
            newCard.classList.add('col-md-4', 'mb-4');
            newCard.innerHTML = `
        <div class="card">
            <div class="card-body">
                <div class="form-group">
                    <label for="pdf_path${cardId}">PDF Upload:</label>
                    <input type="file" name="pdf_path[]" class="form-control-file" id="pdf_path${cardId}" accept="application/pdf" onchange="previewPDF(this, 'pdf-preview${cardId}')">
                    <div id="pdf-preview${cardId}" class="mt-2" style="display: none;">
                        <a href="#" id="pdf-link${cardId}" target="_blank">View PDF</a>
                    </div>
                </div>
                <div class="form-group">
                    <label for="caption">Caption</label>
                    <textarea name="caption[]" class="form-control" rows="3"></textarea>
                </div>
            </div>
        </div>
    `;

            // Insert the new card before the plus icon
            document.getElementById('card-container').insertBefore(newCard, document.getElementById(
                'plus-icon-card').parentNode);
            cardId++; // Increment ID for the next card
        });
    </script>


    {{-- <script>
        function toggleYearDropdown() {
            // alert('alert');
            var category = document.getElementById('category').value;

            var yearGroup = document.getElementById('year-group');
            var benefitGroup = document.getElementById('benefit-group');
            var districtGroup = document.getElementById('district-group');

            // Hide other dropdowns initially
            benefitGroup.style.display = 'none';
            districtGroup.style.display = 'none';

            // Show year dropdown for "Disbursed Benefits" or "Benefit Returned"
            if (category === '4' || category === '5') {
                yearGroup.style.display = 'block';
            } else {
                yearGroup.style.display = 'none';
            }
        }

        function toggleBenefitDropdown() {
            var category = document.getElementById('category').value;
            var year = document.getElementById('year').value; // Updated to caption
            var benefitGroup = document.getElementById('benefit-group');
            var benefitDropdown = document.getElementById('benefit_id');

            var benefitLabel = document.getElementById('benefit-label');
            var districtGroup = document.getElementById('district-group');




            if ((category === '4' || category === '5') && year !== '') {
                benefitGroup.style.display = 'block';
                districtGroup.style.display = 'none'; // Hide district dropdown initially

                if (category === '4') {
            benefitLabel.innerText = 'Benefit';
        }  else if (category === '5') {
                    // Show district dropdown for returned category
                    benefitLabel.innerText = 'District';
                    districtGroup.style.display = 'block';
                    benefitGroup.style.display = 'none'; // Hide benefit dropdown
                }
            } else {
                benefitGroup.style.display = 'none';
                districtGroup.style.display = 'none';
            }
        }

        function addOptions(selectElement, optionsArray) {
            optionsArray.forEach(function(optionText) {
                var option = document.createElement('option');
                option.value = optionText;
                option.textContent = optionText;
                selectElement.appendChild(option);
            });
        }
    </script> --}}
    <script>
        function toggleYearDropdown() {
    var category = document.getElementById('category').value;

    var yearGroup = document.getElementById('year-group');
    var benefitGroup = document.getElementById('benefit-group');
    var districtGroup = document.getElementById('district-group');

    // Reset visibility
    yearGroup.style.display = 'none';
    districtGroup.style.display = 'none';
    benefitGroup.style.display = 'none';

    if (category === '4' || category === '5') {
        yearGroup.style.display = 'block';
    }
}

function toggleBenefitDropdown() {
    var category = document.getElementById('category').value;
    var year = document.getElementById('year').value;

    var benefitGroup = document.getElementById('benefit-group');
    var districtGroup = document.getElementById('district-group');
    var benefitLabel = document.getElementById('benefit-label');

    // Reset visibility
    benefitGroup.style.display = 'none';
    districtGroup.style.display = 'none';

    if ((category === '4' || category === '5') && year !== '') {
        // First always show district
        districtGroup.style.display = 'block';

        if (category === '4') {
            benefitGroup.style.display = 'block';
            benefitLabel.innerText = 'Benefit';
        } else if (category === '5') {
            benefitGroup.style.display = 'none'; // hide for returned
        }
    }
}

    </script>
@endsection
