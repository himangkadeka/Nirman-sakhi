@include('layout.workerheader')
<style>
    /* Custom styles */
    .table th {
        font-size: 12px;
    }

    .table-container {
        overflow-x: auto;
    }

    .fixed-width {
        min-width: 200px;
        /* Adjust the width as needed */
    }

    .fixed {
        min-width: 100px;
        /* Adjust the width as needed */
    }

    .table thead tr {
        border-top: 2px solid #ffc0b4;
    }

    .table thead th {
        border-bottom: 2px solid black;
    }
</style>
<div class="d-flex" id="wrapper">
    @include('worker.leftmenu')
    <!-- Page Content -->
    <div id="page-content-wrapper">
        @include('components.worker.ui.navbar')
        <ul class="breadcrumb">
            <li><a href="{{route('worker-dashboard')}}">Dashboard</a></li>
            <li>Create Certificate</li>

        </ul>
        <div class="container mt-2">
            <div class="card rounded-card">
                <div class="card-header card-header-bg text-white d-flex justify-content-between align-items-center" style="background-color: #248f8f;">
                <span>
                    <i class="fa fa-plus-circle" aria-hidden="true"></i>&nbsp; Create New Certificates
                </span>
                <a href="{{route('all-ninety-days-certificate')}}" class="btn btn-primary" >
                        All Certificates &nbsp;<i class="fa fa-arrow-circle-right" aria-hidden="true"></i>
                    </a>
                </div>
            <form action="{{ route('create-certi') }}" class="form-group" enctype="multipart/form-data" method="post"
                id="employer">
                @csrf
                <div class="container-fluid text-center mt-2">
                    <div class="table-responsive">
                        <table class="table" id="user_table">
                            <thead>
                            <tr>
                                {{-- <th scope="col">Serial No</th> --}}
                                <th scope="col" class="bold">Type of Issuer / ইছ্যুকাৰীৰ প্ৰকাৰ<span
                                        class="text-danger">*</span></th>
                                <th scope="col" class="bold">Name of Issuing Organization / ইছ্যু কৰা
                                    সংস্থাৰ নাম<span class="text-danger">*</span></th>
                                <th scope="col" class="bold">Issue Number / ইছ্যু নম্বৰ<span
                                        class="text-danger">*</span></th>
                                <th scope="col" class="bold">Issue Date / ইছ্যুৰ তাৰিখ<span
                                        class="text-danger">*</span></th>
                                <th scope="col" class="bold">Name of Issuing Person / ইছ্যু কৰা ব্যক্তিৰ নাম<span
                                        class="text-danger">*</span></th>
                                <th scope="col" class="bold">Contact No of Issuing Person / ইছ্যু কৰা ব্যক্তিৰ যোগাযোগ নং<span
                                        class="text-danger">*</span></th>
                                <th scope="col" class="bold">Is Issuer & Employer Same / ইছ্যুকাৰী আৰু নিয়োগকৰ্তা একে নে?
                                    (Yes/No)<span class="text-danger">*</span></th>
                                <th scope="col" class="bold">Employer Name / নিয়োগকৰ্তাৰ নাম<span
                                        class="text-danger">*</span></th>
                                <th scope="col" class="bold">Employer Contact Name / নিয়োগকৰ্তাৰ যোগাযোগৰ নাম<span
                                        class="text-danger">*</span></th>
                                <th scope="col" class="bold">Employer Contact Number / নিয়োগকৰ্তাৰ যোগাযোগ নম্বৰ<span
                                        class="text-danger">*</span></th>
                                <th scope="col" class="bold">From Date / তাৰিখৰ পৰা<span
                                        class="text-danger">*</span></th>
                                <th scope="col" class="bold">To Date / তাৰিখলৈকে<span
                                        class="text-danger">*</span></th>
                                <th scope="col" class="bold">No of Days / দিনৰ সংখ্যা<span
                                        class="text-danger">*</span></th>
                                <th scope="col" class="bold">Type of Employer / নিয়োগকৰ্তাৰ
                                    প্ৰকাৰ<span class="text-danger">*</span></th>
                                <th scope="col" class="bold">Action</th>
                                <!-- Repeat headers as needed -->
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                {{-- <input type="hidden" name="worker_id[]" value="{{$formdata->worker_id}}" class="form-control"/> --}}
                                {{-- <td class="bold font-weight-normal">1</td> --}}
                                <td class="dropdown fixed-width">
                                    <select name="type_of_issuer[]" class="form-control fixed-width">
                                        <option value="">Select Issuer</option>
                                        @foreach ($type_of_issuer as $issuer)
                                            <option value="{{ $issuer->issuer_code }}">
                                                {{ $issuer->issuer_name }}</option>
                                        @endforeach
                                    </select>
                                    <span class="text-danger success" id="type_of_issuer.0_error"></span>
                                </td>
                                <td>
                                    <input type="text" name="issuing_org[]"
                                           class="fixed-width form-control" data-id="1" id="issuing_org_1">
                                    <span class="text-danger success issuing_org" id="issuing_org.0_error"></span>
                                </td>
                                <td class="fixed-width"><input type="text" name="issue_no[]"
                                                               value="{{ old('issue_no[]') }}" class="form-control issueNo" />
                                    <span class="text-danger success" id="issue_no.0_error"></span>
                                </td>
                                <td class="fixed-width">
                                    <input type="date" name="issue_date[]" value=""
                                           class="form-control issue-date" >
                                    <span class="text-danger success" id="issue_date.0_error"></span>
                                </td>
                                <td>
                                    <input type="text" name="issuing_person[]"
                                           class="fixed-width form-control issuing_person" data-id="1" id="issuing_person_1" />
                                    <span class="text-danger success" id="issuing_person.0_error"></span>
                                </td>
                                <td>
                                    <input type="text" name="contact_issuing_person[]"
                                           class="fixed-width form-control contact_issuing_person" data-id="1" id="contact_issuing_person_1" maxlength="10"/>
                                    <span class="text-danger success"
                                          id="contact_issuing_person.0_error"></span>
                                </td>
                                <td class="fixed-width">
                                    <select name="is_same[]" data-id="1" id="issame_1" onchange="toogleIssameInput(1)"
                                            class="form-control issame">
                                        <option value="">Select</option>
                                        <option value="1">Yes</option>
                                        <option value="0">No</option>
                                    </select>
                                    <span class="text-danger success" id="is_same.0_error"></span>
                                </td>
                                <td>
                                    <input readonly type="text" name="employer_name_certi[]"
                                           class="fixed-width form-control employer_name_certi" data-id="1" id="employer_name_certi_1"/>
                                    <span class="text-danger success"
                                          id="employer_name_certi.0_error"></span>
                                </td>
                                <td>
                                    <input readonly type="text" name="employer_contact_name[]"
                                           class="fixed-width form-control employer_contact_name" data-id="1" id="employer_contact_name_1"/>
                                    <span class="text-danger success"
                                          id="employer_contact_name.0_error"></span>
                                </td>
                                <td>
                                    <input readonly type="text" name="employer_contact_number[]"
                                           class="fixed-width form-control employer_contact_number" data-id="1" id="employer_contact_number_1"/>
                                    <span class="text-danger success"
                                          id="employer_contact_number.0_error"></span>
                                </td>

                                <td class="fixed-width"><input type="date" name="from_date[]"
                                                               value="{{ old('from_date[]') }}"
                                                               class="form-control fixed-width from-date" />
                                    <span class="text-danger success" id="from_date.0_error"></span>
                                </td>

                                <td class="fixed-width"><input type="date" name="to_date[]"
                                                               value="{{ old('to_date[]') }}"
                                                               class="form-control fixed-width to-date" />
                                    <span class="text-danger success" id="to_date.0_error"></span>
                                </td>

                                <td class="fixed"><input type="text" id="dateCount"
                                                         class="form-control date_count" />
                                </td>
                                <td class="fixed-width"><select name="type_of_employer[]"
                                                                class="form-control fixed-width">
                                        <option value="">Select employer</option>
                                        @foreach ($type_of_employers as $employers)
                                            <option value="{{ $employers->employer_code }}">
                                                {{ $employers->employer_name }}</option>
                                        @endforeach
                                    </select>
                                    <span class="text-danger success"
                                          id="type_of_employer.0_error"></span>
                                </td>
                                <span id="total_days_span" class="text-info font-weight-normal"></span>

                                <td>
                                    <button type="button" name="remove" id=""
                                            class="btn btn-sm btn-danger remove"><i class="fa fa-trash"
                                                                                    aria-hidden="true"></i></button>
                                </td>
                            </tr>
                            <!-- Additional rows -->
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="d-flex justify-content-between align-items-center mb-1 clearfix mt-4">
                    <div class="ml-2">
                        <button type="button" name="add" id="add" class="btn btn-sm btn-warning"><i
                                class="fa fa-plus-circle"></i>&nbsp;Add New Row</button>
                    </div>
                    <div class="ml-auto d-inline-block align-self-center mr-2">
                        <button type="submit"
                            class="btn btn-primary b-btn"><i class="fa fa-check-circle" aria-hidden="true"></i>&nbsp;
                            Save Certificate</button></div>
                </div>
            </form>

                </div>
        </div>
    </div>
</div>
</div>


<!--view application details-->
<div class="modal fade" id="signout-modal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header text-center d-block p-5 border-bottom-0">
                <h3 class="modal-title">Sign Out?</h3>
                <button type="button" class="close position-absolute" style="right: 15px; top: 8px;"
                    data-dismiss="modal">&times;</button>
            </div>
            <!-- Modal body -->
            <div class="modal-body">
                <p class="text-center">Are you sure you want to Log Out?</p>
                <div class="text-center py-4">
                    <form action="{{ route('user-logout') }}" method="post">
                        @csrf
                        <button type="submit" class="btn btn-primary b-btn mx-2">Sign Out</button>
                        <button class="btn btn-secondary mx-3" data-dismiss="modal">Cancel</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</div>

<!-- Modal -->
<div class="modal fade" id="successModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Welcome to the dashboard!</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                @if ($message = Session::get('success'))
                    <div class="alert alert-success alert-block">
                        <strong>{!! $message !!} </strong>
                    </div>
                @endif
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<link rel="stylesheet" href="{{ URL::asset('assets/template/datepicker/jquery-ui.min.css') }}">
<script src="{{ URL::asset('assets/template/datepicker/jquery-3.7.date.js') }}"></script>
<script src="{{ URL::asset('assets/template/datepicker/jquery-ui.min.js') }}"></script>
<script>
    $(document).ready(function() {

        let count = 1;
        let dynamicRowsData = [];

        function dynamic_field(number, data = null) {
            let html = `<tr>
                <td class="dropdown">
                    <select name="type_of_issuer[` + count + `]" class="form-control fixed-width">
                        <option value="">Select Issuer</option>`;
            @foreach ($type_of_issuer as $issuer)
                html += `<option value="{{ $issuer->issuer_code }}">{{ $issuer->issuer_name }}</option>`;
            @endforeach
                html += `</select><span class="text-danger success"  id="type_of_issuer.`+ count +`_error"></span>
                </td>`;

            html += '<td><input type="text" name="issuing_org[' + count + ']" class="form-control fixed-width issuing_org" id="issuing_org_' + number +'"/>' +
                '<span class="text-danger success"  id="issuing_org.' + count + '_error"></span></td>';

            html += '<td><input type="text" name="issue_no[' + count + ']" class="form-control fixed-width"/>'+
                '<span class="text-danger success"  id="issue_no.' + count + '_error"></span></td>';

            html += '<td><input type="date" name="issue_date[' + count + ']" id="issue_date" data-id="1" class="form-control issue-date"  max="<?php echo json_encode(date('Y-m-d')); ?>" />'+
                '<span class="text-danger success"  id="issue_date.' + count + '_error"></span></td>';

            html += '<td><input type="text" name="issuing_person[' + count + ']" class="form-control fixed-width issuing_person" id="issuing_person_' + number +'"/>'+
                '<span class="text-danger success"  id="issuing_person.' + count + '_error"></span></td>';

            html += '<td><input type="text" name="contact_issuing_person[' + count + ']" class="form-control fixed-width contact_issuing_person" maxlength="10" id="contact_issuing_person_' + number +'">'+
                '<span class="text-danger success"  id="contact_issuing_person.' + count + '_error"></span></td>';

            html += '<td><select id="issame_' + number + '" name="is_same[' + count + ']" class="form-control issame" onchange="toogleIssameInput(' + number + ')">';
            html += '<option value="">Select</option>';
            html += '<option value="1">Yes</option>';
            html += '<option value="0">No</option>';
            html += '</select><span class="text-danger success"  id="is_same.' + count + '_error"></span></td>';

            html += '<td><input type="text" id="employer_name_certi_'  + number + '" name="employer_name_certi[' + count + ']" class="form-control employer_name_certi fixed-width"> ' +
                '<span class="text-danger success"  id="employer_name_certi.' + count + '_error"></span></td>';

            html += '<td><input type="text" id="employer_contact_name_'  + number + '" name="employer_contact_name[' + count + ']" class="form-control employer_contact_name fixed-width">'+
                '<span class="text-danger success"  id="employer_contact_name.' + count + '_error"></span></td>';

            html += '<td><input type="text" id="employer_contact_number_'  + number + '" name="employer_contact_number[' + count + ']" class="form-control employer_contact_number fixed-width" maxlength="10" >' +
                '<span class="text-danger success"  id="employer_contact_number.' + count + '_error"></span></td>';

            html+= '<td><input type="date" name="from_date[' + count + ']" id="from_date_' + number + '" class="form-control from-date"  max="<?php echo json_encode(date('Y-m-d')); ?>" />' +
                '<span class="text-danger success" id="to_date.' + count + '_error"></span></td>';

            html +='<td><input type="date" name="to_date[' + count + ']" id="to_date_' + number + '" data-id="1" class="form-control to-date to_date"  max="<?php echo json_encode(date('Y-m-d')); ?>" />' +
                '<span class="text-danger success" id="to_date.' + count + '_error"></span></td>';

            html += '<td><input type="text"  id="dateCount" class="form-control date_count" /></td>';

            html+=`<td class="dropdown">
                    <select name="type_of_employer[` + count + `]" class="form-control fixed-width">
                        <option value="">Select Employer</option>`;

            @foreach ($type_of_employers as $emp)
                html += `<option value="{{ $emp->employer_code }}">{{ $emp->employer_name }}</option>`;
            @endforeach
                html += '</select><span class="text-danger success"  id="type_of_employerr.' + count + '_error"></span></td>';

            html += '<td><button type="button" name="remove" id="" class="btn btn-sm btn-danger remove"><i class="fa fa-trash" aria-hidden="true"></i></button></td></tr>';
            $('tbody').append(html);
            count++;
        }

        // Event listener for form submission
        $('#employer').submit(function(event) {
            event.preventDefault();
            $('.success').html('');
            $('tbody tr').each(function(index, element) {
                let rowData = {
                    typeOfIssuer: $(element).find('input[name="type_of_issuer[]"]').val(),
                    issueDate: $(element).find('input[name="issue_date[]"]').val(),
                    issueNo: $(element).find('input[name="issueNo[]"]').val(),
                    typeOfEmployer: $(element).find('input[name="type_of_employer[]"]')
                        .val(),
                    Name: $(element).find('input[name="name[]"]').val(),
                    mobile: $(element).find('input[name="mobile[]"]').val(),
                    from_date: $(element).find('input[name="from_date[]"]').val(),
                    to_date: $(element).find('input[name="to_date[]"]').val(),

                };
                dynamicRowsData.push(rowData);
            });
            const formData = $(this).serialize();
            $.ajax({
                url: "{{ route('create-certi') }}",
                method: 'POST',
                data: formData,
                success: function(response) {
                    if (response.success) {
                        console.log(response.success)
                        window.location.href = "{{ route('create-new-certificate') }}";
                    } else {
                        if (response.msg === 'true') {
                            toastr.error('Issue number already exists');
                        } else {
                            if (response.errors) {
                                console.log(response.errors)
                                $.each(response.errors, function(field, messages) {
                                    const escapedKey = field.replace('.', '\\.');
                                    $("#" + escapedKey + '_error').html(messages[
                                        0]);
                                });
                            }
                        }
                    }
                },
                error: function(xhr, status, error) {

                    alert('An error occurred while processing your request.');
                }
            });
        });

        function reAddDynamicRows() {
            for (let i = 0; i < dynamicRowsData.length; i++) {
                dynamic_field(count, dynamicRowsData[i]);
            }
        }

        // Call reAddDynamicRows function after the page reloads if dynamicRowsData is not empty
        if (dynamicRowsData.length > 0) {
            reAddDynamicRows();
        }

        $('#user_table').on('change', '.from-date, .to-date', function() {
            const row = $(this).closest('tr');
            // console.log("Row:", row);
            calculateDateDifference(row);

        });

        function calculateDateDifference(row) {
            var fromDate = row.find('.from-date').val();
            var toDate = row.find('.to-date').val();
            console.log("From Date:", fromDate);
            console.log("To Date:", toDate);
            if (fromDate === toDate) {
                // alert("From Date and To Date cannot be the same.");
                Swal.fire({
                    text: 'From Date and To Date cannot be the same.',
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
                row.find('.from-date').val('');
                row.find('.to-date').val('');
                row.find('.days-difference').text('');
                row.find('.date_count').val('');
                return;
            }

            const isTimePeriodDuplicate = checkForDuplicateTimePeriod(row);
            // if (isTimePeriodDuplicate) {
            //     // alert("The time period must not be the same for other dynamically added rows.");
            //     // You can customize the validation error handling here
            //     Swal.fire({
            //         title: 'Error',
            //         text: 'Cannot Select Same Time Period!',
            //         icon: 'error',
            //         confirmButtonText: 'OK'
            //     });
            //     row.find('.from-date').val('');
            //     row.find('.to-date').val('');
            //     row.find('.days-difference').text('');
            //     row.find('.date_count').val('');
            //     return;
            // }
            if (fromDate && toDate) {
                const differenceInMilliseconds = new Date(toDate) - new Date(fromDate);
                const differenceInDays = differenceInMilliseconds / (1000 * 60 * 60 * 24);
                //getting the days difference
                row.find('.days-difference').text('Days Difference: ' + differenceInDays.toFixed(0));
                // Update the value of the date_count input field
                row.find('.date_count').val(differenceInDays.toFixed(0));

            } else {
                row.find('.days-difference').text('');
                row.find('.date_count').val('');

            }
            calculateTotalDays();
        }

        function checkForDuplicateTimePeriod(currentRow) {
            var isDuplicate = false;
            var currentFromDate = new Date(currentRow.find('.from-date').val());
            var currentToDate = new Date(currentRow.find('.to-date').val());

            // Iterate through existing rows
            $('.from-date').not(currentRow.find('.from-date')).each(function() {
                var existingFromDate = new Date($(this).val());
                var existingToDate = new Date($(this).closest('tr').find('.to-date').val());

                // Check if the current date range overlaps with existing date ranges
                if (
                    (currentFromDate >= existingFromDate && currentFromDate <= existingToDate) ||
                    (currentToDate >= existingFromDate && currentToDate <= existingToDate)
                ) {
                    isDuplicate = true;
                    return false; // Exit the loop if a duplicate is found
                }
            });

            return isDuplicate;
        }
        // Function to calculate total days
        function calculateTotalDays() {
            var totalDays = 0;

            // Iterate through each row
            $('.date_count').each(function() {
                val = parseInt($(this).val());
                if (isNaN(val)) {
                    val = 0;
                }
                console.log(val);
                totalDays += val;
            });
            // Update the total days in the span tag
            $('#total_days_span').text('Total Days: ' + totalDays);

            // Check if the total days is less than 90 and show a message
            if (totalDays < 90) {
                $('#total_days_span').addClass('text-danger').append(' (Total days should be at least 90)');
            } else {
                $('#total_days_span').removeClass('text-danger');
            }
        }
        // Trigger the calculation on input change
        $('#user_table').on('change', '.from-date, .to-date', function() {
            // calculateTotalDays();
        });

        $(document).on('click', '#add', function() {
            let count = $('#user_table tbody tr').length + 1;
            dynamic_field(count);
            calculateTotalDays(); // Recalculate total days after adding a row
        });
        // Event handler for removing rows
        $(document).on('click', '.remove', function() {
            $(this).closest("tr").remove();
            calculateTotalDays(); // Recalculate total days after removing a row
        });
        $('form').on('submit', function(e) {
            // Calculate total days before form submission
            calculateTotalDays();

            // Check if the total days is less than 90
            var totalDays = parseFloat($('#total_days_span').text().replace('Total Days: ', ''));
            if (totalDays < 90) {
                // Show an alert or perform other actions to notify the user
                Swal.fire({
                    title: 'Certificate Duration',
                    text: 'Total no of days should be 90 days or more.',
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
                e.preventDefault(); // Prevent form submission
            }
        });
    });
</script>
<script>
    // Initialize the datepicker
    $(document).ready(function() {
        $("#doj").datepicker({
            dateFormat: "dd-mm-yy",
            changeMonth: true,
            changeYear: true,
            yearRange: "-100:+0", // Allow selecting DOB up to 100 years ago from the current year
        });
    });
</script>

<script>
    const forceKeyPressUppercase = (e) => {
        let el = e.target;
        let charInput = e.keyCode;
        if ((charInput >= 97) && (charInput <= 122)) { // lowercase
            if (!e.ctrlKey && !e.metaKey && !e.altKey) { // no modifier key
                let newChar = charInput - 32;
                let start = el.selectionStart;
                let end = el.selectionEnd;
                el.value = el.value.substring(0, start) + String.fromCharCode(newChar) + el.value.substring(end);
                el.setSelectionRange(start + 1, start + 1);
                e.preventDefault();
            }
        }
    };

    document.querySelectorAll(".uc-text-smooth").forEach(function(current) {
        current.addEventListener("keypress", forceKeyPressUppercase);
    });
</script>
<script>
    function ajaxStart() {
        // Show the loader when an AJAX request starts
        $("#loader").show();
    };

    function ajaxStop() {
        // Hide the loader when all AJAX requests are complete
        $("#loader").hide();
    };
    $(document).ready(function() {

        $('.dist').on('change', function() {
            ajaxStart();
            var cDist = $(this).data('id');
            var district_code = $(this).val();

            if (district_code) {
                $.ajax({
                    url: 'get-subdistricts',
                    type: 'GET',
                    data: {
                        district_code: district_code,
                        _token: '{{ csrf_token() }}'
                    },
                    dataType: 'json',
                    success: function(data) {
                        ajaxStop();
                        if (cDist == 'd') {
                            var dis = '#subdist';
                        }
                        console.log(data)
                        $(dis).html('<option value="">--Select Sub-District--</option>');
                        $.each(data.subdist, function(key, value) {
                            $(dis).append('<option value="' + value
                                .subdistrict_code + '">' + value
                                .subdistrict_name + '</option>');
                        });
                    }
                });
            } else {
                $('#subdist').empty();
                // $('#subdistrict').empty();
            }
        });
    });
</script>
<script>
    $(document).ready(function() {
        // Function to check if the date already exists in the table
        function isDateUnique(date) {
            let dates = [];
            $('.issue').each(function() {
                dates.push($(this).val());
            });

            return dates.indexOf(date) === dates.lastIndexOf(date);
        }

        $(document).on('change', '.issue', function() {
            let currentDate = $(this).val();

            if (!isDateUnique(currentDate)) {
                // alert('Issue date must be unique.');
                Swal.fire({
                    title: 'Issue Date',
                    text: 'Issue date cannot be same!',
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
                $(this).val('');
            }
        });
    });
</script>
<script>
    $(document).ready(function() {
        // Function to check if the issue number is unique
        function isIssueNoUnique(issueNo) {
            let issueNos = [];
            $('.issueNo').each(function() {
                issueNos.push($(this).val());
            });

            return issueNos.indexOf(issueNo) === issueNos.lastIndexOf(issueNo);
        }

        // Event delegation for dynamically added issue number fields
        $(document).on('change', '.issueNo', function() {
            let currentIssueNo = $(this).val();

            if (!isIssueNoUnique(currentIssueNo)) {
                Swal.fire({
                    title: 'Issue Number',
                    text: 'Issue number cannot be same!',
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
                $(this).val('');
            }
        });
    });
</script>

<script src="{{ URL::asset('assets/template/js/sweetAlert.js') }}"></script>
<script>
    function updateMaxAttribute() {
        // Get today's date
        var today = new Date().toISOString().split('T')[0];

        // Set the max attribute for each date input field
        $('input[type="date"]').each(function() {
            $(this).attr('max', today);
        });
    }

    // Call the function initially
    updateMaxAttribute();
</script>

<script>
    function toogleIssameInput(number) {
        // Get the dropdown element
        var isSameDropdown = document.getElementById('issame_' + number);

        var selectedIndex = isSameDropdown.selectedIndex;
        var selectedOption = isSameDropdown.options[selectedIndex].value;

        // Get the input fields
        var orgInput = document.getElementById('issuing_org_' + number);
        var personInput = document.getElementById('issuing_person_' + number);
        var contactInput = document.getElementById('contact_issuing_person_' + number);
        var employerNameInput = document.getElementById('employer_name_certi_' + number);
        var employerContactNameInput = document.getElementById('employer_contact_name_' + number);
        var employerContactNumberInput = document.getElementById('employer_contact_number_' + number);

        // If "Yes" is selected, copy and paste the values
        if (selectedOption === '1') {
            employerNameInput.value = orgInput.value;
            employerContactNameInput.value = personInput.value;
            employerContactNumberInput.value = contactInput.value;

            // Make the employer fields read-only if copied
            employerNameInput.readOnly = true;
            employerContactNameInput.readOnly = true;
            employerContactNumberInput.readOnly = true;
        } else {
            // If "No" is selected, make the employer fields writable
            employerNameInput.readOnly = false;
            employerContactNameInput.readOnly = false;
            employerContactNumberInput.readOnly = false;

            employerNameInput.value = '';
            employerContactNameInput.value = '';
            employerContactNumberInput.value = '';
        }
    }

</script>
<script src="{{ URL::asset('assets/template/js/sweetAlert.js') }}"></script>
@include('layout.footer')
