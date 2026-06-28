<div class="modal fade" id="user-transfer-modal" tabindex="-1" role="dialog" aria-labelledby="userTransferModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content border-0 rounded-lg shadow-lg">
            <div class="modal-header d-block p-3 text-center bg-primary text-white rounded-top-lg">
                <h5 class="modal-title font-weight-bold" id="userTransferModalLabel">Transfer User Account</h5>
                <button type="button" class="close position-absolute" style="right: 20px; top: 15px; color: white; opacity: 1;" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body p-4 bg-light">
                <div id="usr-msg" class="alert alert-info d-none"></div>
                <form id="user-transfer-form" action="{{ route('admin.users.transfer') }}" method="post" enctype="multipart/form-data" class="">
                    @csrf
                    <input type="hidden" id="user_id_transfer" name="user_id">

                    <fieldset class="border p-3 mb-4 rounded-lg shadow-sm bg-white">
                        <legend class="w-auto px-2 text-primary font-weight-bold small">User Details</legend>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="user-name-transfer" class="form-label font-weight-bold">Username<span class="text-danger">*</span>:</label>
                                <input type="text" class="form-control form-control-sm border-0 bg-light rounded-pill px-4 py-3" id="user-name-transfer" name="user_name" placeholder="Enter User Name" value="{{ old('username') }}" required>
                            </div>
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-sm-6 mb-3">
                                        <label for="first-name-transfer" class="form-label font-weight-bold">Firstname<span class="text-danger">*</span>:</label>
                                        <input type="text" class="form-control form-control-sm border-0 bg-light rounded-pill px-4 py-3" id="first-name-transfer" name="firstname" placeholder="Enter Firstname" value="{{ old('firstname') }}" required>
                                    </div>
                                    <div class="col-sm-6 mb-3">
                                        <label for="last-name-transfer" class="form-label font-weight-bold">Lastname<span class="text-danger">*</span>:</label>
                                        <input type="text" class="form-control form-control-sm border-0 bg-light rounded-pill px-4 py-3" id="last-name-transfer" name="lastname" placeholder="Enter Lastname" value="{{ old('lastname') }}" required>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="phone-transfer" class="form-label font-weight-bold">Phone No<span class="text-danger">*</span>:</label>
                                <input type="text" class="form-control form-control-sm border-0 bg-light rounded-pill px-4 py-3" id="phone-transfer" name="phone" maxlength="10" placeholder="Enter 10 digit Phone Number" value="{{ old('phone') }}" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="email-transfer" class="form-label font-weight-bold">Email<span class="text-danger">*</span>:</label>
                                <input type="email" class="form-control form-control-sm border-0 bg-light rounded-pill px-4 py-3" id="email-transfer" name="email" placeholder="Enter Email Address" value="{{ old('email') }}" required>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="designation_id_transfer" class="form-label font-weight-bold">Select Designation<span class="text-danger">*</span></label>
                                <select class="form-control form-control-lg border-0 bg-light rounded-pill px-4 py-3 custom-select" id="designation_id_transfer" name="designation" required>
                                    <option value="" selected disabled>--Select Designation--</option>
                                    @foreach ($designations as $designation)
                                        <option value="{{ $designation->id }}">{{ $designation->designation }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="role-name-transfer" class="form-label font-weight-bold">Select Role<span class="text-danger">*</span></label>
                                <select class="form-control form-control-lg border-0 bg-light rounded-pill px-4 py-3 custom-select" id="role-name-transfer" name="role_name" required>
                                    <option value="" selected disabled>--Select Role--</option>
                                    @foreach ($roles as $role)
                                        <option value="{{ $role->id }}">{{ $role->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </fieldset>
                    <div class="form-group mb-3">
                        <label class="form-label fw-bold">Is Retired/Death?</label>
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="is_retired" name="is_retired">
                            <label class="form-check-label" for="is_retired">Mark user as retired</label>
                        </div>
                    </div>
                    <div class="form-group mb-3">
                        <label class="form-label fw-bold">In Charge?</label>
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="is_incharged" name="is_incharged">
                            <label class="form-check-label" for="is_incharged">Mark user if in In-charge</label>
                        </div>
                    </div>
                    <fieldset class="border p-3 mb-4 rounded-lg shadow-sm bg-white">
                        <legend class="w-auto px-2 text-primary font-weight-bold small">Transfer Details</legend>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="district_code_transfer" class="form-label font-weight-bold">Transfer From District<span class="text-danger">*</span></label>
                                <select class="form-control form-control-lg border-0 bg-light rounded-pill px-4 py-3 custom-select" id="district_code_transfer" name="district_from" required>
                                    <option value="" selected disabled>--Select District--</option>
                                    @foreach ($dists as $district)
                                        <option value="{{ $district->district_code }}"> {{ $district->district_name }} </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="office_id_transfer" class="form-label font-weight-bold">Transfer From Office<span class="text-danger">*</span></label>
                                <select name="office_id_from" class="form-control form-control-lg border-0 bg-light rounded-pill px-4 py-3 custom-select" id="office_id_transfer">
                                    <option value="" selected disabled> {{ trans('worker-registration/worker_new_registration.select_office') }} </option>
                                </select>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="district_code_transfer_to" class="form-label font-weight-bold">Transfer To District<span class="text-danger">*</span></label>
                                <select class="form-control form-control-lg border-0 bg-light rounded-pill px-4 py-3 custom-select" id="district_code_transfer_to" name="district_to" required>
                                    <option value="" selected disabled>--Select District-- </option>
                                    @foreach ($dists as $district)
                                        <option value="{{ $district->district_code }}"> {{ $district->district_name }} </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="office_id_transfer_to" class="form-label font-weight-bold">Transfer To Office<span class="text-danger">*</span></label>
                                <select name="office_id_to" class="form-control form-control-lg border-0 bg-light rounded-pill px-4 py-3 custom-select" id="office_id_transfer_to">
                                    <option value="" selected disabled> {{ trans('worker-registration/worker_new_registration.select_office') }} </option>
                                </select>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="district_code_transfer_to" class="form-label font-weight-bold">End date<span class="text-danger">*</span></label>
                                <input type="date" name="officers_end_date" id="officers_end_date" class="form-control form-control-lg border-0 bg-light rounded-pill px-4 py-3">
                            </div>

                        </div>

                        {{--<div class="row mb-3">--}}
                            {{--<label for="transfer_document" class="form-label font-weight-bold">Upload Transfer/Relieving Order<span class="text-danger">*</span></label>--}}
                            {{--<input type="file"--}}
                                   {{--class="form-control form-control-sm border-0 bg-light rounded-pill px-4 py-3"--}}
                                   {{--id="transfer_document"--}}
                                   {{--name="transfer_document"--}}
                                   {{--accept=".pdf,.jpg,.jpeg,.png"--}}
                                   {{--required>--}}
                            {{--<small class="text-muted">Accepted formats: PDF | Max: 2MB</small>--}}
                        {{--</div>--}}
                    </fieldset>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="transfer_document" class="form-label font-weight-bold">Upload Transfer/Relieving Order<span class="text-danger">*</span></label>
                            <input type="file"
                                   class="form-control form-control-lg border-0 bg-light rounded-pill px-4 py-3 custom-select"
                                   id="transfer_document"
                                   name="transfer_document"
                                   accept="application/pdf"
                                   required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="retire" class="form-label font-weight-bold">Retired At<span class="text-danger">*</span></label>
                            <input type="date" name="retired_at" id="retired_at" class="form-control form-control-lg border-0 bg-light rounded-pill px-4 py-3">
                        </div>
                    </div>

                    <div class="d-flex justify-content-center pt-3 pb-2">
                        <button type="submit" class="btn btn-primary btn-sm rounded-pill px-5 py-3 shadow-sm b-btn animate__animated animate__pulse animate__infinite">
                            <i class="fas fa-sync-alt mr-2"></i> UPDATE TRANSFER
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
    /* Custom CSS for enhanced aesthetics */
    .modal-header.bg-primary {
        background: white; /* Gradient background */
        border-bottom: none;
    }
    .modal-title {
        font-size: 1.8rem;
        letter-spacing: 0.5px;
    }
    .modal-body {
        background-color: #f8f9fa; /* Lighter body background */
    }
    .form-control-lg {
        /* Adjusted height and padding for better text display */
        height: auto; /* Allow height to adjust based on content */
        min-height: calc(2.8rem + 2px); /* Maintain a minimum height */
        padding: 0.75rem 1.5rem;
    }
    .rounded-pill {
        border-radius: 50rem !important;
    }
    .custom-select {
        background-color: #e9ecef; /* Lighter background for selects */
        border: none;
        padding-right: 2.5rem; /* Space for arrow */
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 4 5'%3e%3cpath fill='%23343a40' d='M2 0L0 2h4zm0 5L0 3h4z'/%3e%3c/svg%3e"); /* Custom arrow */
        background-repeat: no-repeat;
        background-position: right 1rem center;
        background-size: 8px 10px;
        -webkit-appearance: none;
        -moz-appearance: none;
        appearance: none;
        line-height: 1.5; /* Ensure standard line-height */
        white-space: nowrap; /* Prevent text wrapping inside select */
        overflow: hidden; /* Hide overflow */
        text-overflow: ellipsis; /* Add ellipsis for overflowed text */
    }
    .form-label {
        color: #495057;
        margin-bottom: 0.5rem;
        display: block; /* Ensure label takes full width above input */
    }
    fieldset {
        border-color: #e9ecef !important; /* Lighter border for fieldset */
    }
    legend {
        color: #007bff !important;
        font-size: 1rem !important;
        padding: 0 10px !important;
        margin-bottom: 0; /* Remove default margin */
        background-color: #f8f9fa; /* Match body background */
        border-radius: 5px;
    }
    .btn-primary {
        background: linear-gradient(45deg, #007bff 0%, #0056b3 100%); /* Gradient for button */
        border: none;
        transition: all 0.3s ease;
    }
    .btn-primary:hover {
        background: linear-gradient(45deg, #0056b3 0%, #007bff 100%);
        transform: translateY(-2px);
        box-shadow: 0 8px 15px rgba(0, 123, 255, 0.3);
    }
    .animate__pulse.animate__infinite {
        animation-duration: 2s;
        animation-iteration-count: infinite;
    }
</style>
<link rel="stylesheet" href="{{ URL::asset('assets/template/css/animates.min.css') }}">
<link rel="stylesheet" href="{{ URL::asset('assets/template/css/all.min.css') }}">

<script>
    $('#user-transfer-form').on('submit', function(e) {
        e.preventDefault();
        let form = this;

        $.ajax({
            url: $(form).attr('action'),
            type: 'POST',
            data: new FormData(form),
            contentType: false,
            processData: false,
            beforeSend: function() {
                // Optionally disable button or show spinner
            },
            success: function(response) {
                if (response.status) {
                    alert(response.message);
                    $('#userTransferModal').modal('hide');
                    form.reset();
                    location.reload();
                } else {
                    alert(response.message || 'Something went wrong.');
                }
            },
            error: function(xhr) {
                if (xhr.status === 422) {
                    let errors = xhr.responseJSON.errors;
                    $.each(errors, function (key, value) {
                        alert(value[0]);
                    });
                } else {
                    alert('Unexpected error. Please try again.');
                }
            }
        });
    });

</script>
<script>
    $(document).ready(function () {

        // Set default state when the page loads (Retired At disabled + faded)
        $('#retired_at')
            .prop('disabled', true)
            .css('opacity', '0.6');


        // Handle checkbox toggle
        $(document).on('change', '#is_retired', function () {
            const isChecked = $(this).is(':checked');

            // Disable or enable transfer-related fields
            $('#district_code_transfer, #office_id_transfer, #district_code_transfer_to, #office_id_transfer_to, #officers_end_date')
                .prop('disabled', isChecked);

            // Adjust opacity for the Transfer Details fieldset
            const fieldset = $(this).closest('form').find('fieldset').last();
            if (isChecked) {
                fieldset.css('opacity', '0.6');
            } else {
                fieldset.css('opacity', '1');
            }

            // Handle retired_at field separately
            if (isChecked) {
                $('#retired_at').prop('disabled', false).css('opacity', '1');
            } else {
                $('#retired_at').prop('disabled', true).css('opacity', '0.6').val('');
            }
        });




        $('#user-transfer-modal').on('show.bs.modal', function () {
            const checkbox = $('#is_retired');
            checkbox.prop('checked', false);

            // Enable transfer fields by default
            $('#district_code_transfer, #office_id_transfer, #district_code_transfer_to, #office_id_transfer_to, #officers_end_date')
                .prop('disabled', false)
                .closest('fieldset').css('opacity', '1');

            // Retired date field disabled with opacity
            $('#retired_at').prop('disabled', true).css('opacity', '0.6').val('');
        });
    });
</script>





