@include('layout.workerheader')

<div class="d-flex" id="wrapper">
    @include('worker.leftmenu')
    <div id="page-content-wrapper">
        @include('components.worker.ui.navbar')
        <div class="container py-5">
            <div class="card">
                <div class="card-header">
                    <h4>Apply for: {{ $benefit->name }}</h4>
                    <p class="text-muted">Please select the family member you are applying for.</p>
                </div>
                <div class="card-body">

                    <!-- 1. Global Eligibility Warnings -->
                    @if (in_array($benefit->benefit_code, ['MT', 'MR', 'CE', 'EA']))

                        <!-- Year Requirements -->
                        @if ($benefit->benefit_code == 'MT' && !$isEligibleByYears)
                            <div class="alert alert-danger mb-4"><i class="fas fa-lock"></i> <strong>Not
                                    Eligible:</strong> At least 3 years of continuous membership is required.</div>
                        @elseif ($benefit->benefit_code == 'MR' && !$isEligibleByYears)
                            <div class="alert alert-danger mb-4"><i class="fas fa-lock"></i> <strong>Not
                                    Eligible:</strong> At least 5 years of continuous membership is required.</div>
                        @endif

                        <!-- Spouse Rule -->
                        @if (in_array($benefit->benefit_code, ['MR', 'CE', 'EA']) && ($isSpouseApplied ?? false))
                            <div class="alert alert-danger mb-4"><i class="fas fa-ban"></i> <strong>Not
                                    Eligible:</strong> Your registered spouse has already applied for this benefit. Only
                                one parent/spouse can claim it.</div>
                        @endif

                        <!-- Max Limits -->
                        @if (!in_array($benefit->benefit_code, ['CE', 'EA']))
                            @if ($totalWorkerApplications >= 2)
                                <div class="alert alert-danger mb-4"><i class="fas fa-ban"></i> <strong>Limit
                                        Reached:</strong> A maximum of two applications are allowed under this benefit.
                                    You
                                    have reached this limit.</div>
                            @else
                                <!-- Status Info -->
                                <div class="alert alert-info mb-4">
                                    <i class="fas fa-info-circle"></i> <strong>Benefit Status:</strong>
                                    {{ $totalWorkerApplications }} of 2 allowed applications used.
                                </div>
                            @endif
                        @endif

                    @endif

                    <!-- 2. Family Members List -->
                    @if ($familyMembers->isNotEmpty())
                        <div class="list-group">
                            @foreach ($familyMembers as $member)
                                @php
                                    $memberAppCount = $applicationsPerMember[$member->id] ?? 0;
                                    $isDisabled = false;
                                    $blockReason = '';

                                    // Block if Global Limits hit
                                    if (in_array($benefit->benefit_code, ['MR', 'MT']) && $totalWorkerApplications >= 2) {
                                        $isDisabled = true;
                                        $blockReason = 'Benefit limit reached';
                                    } elseif (
                                        in_array($benefit->benefit_code, ['MR', 'CE', 'EA']) &&
                                        ($isSpouseApplied ?? false)
                                    ) {
                                        $isDisabled = true;
                                        $blockReason = 'Spouse already applied';
                                    }

                                    // Benefit Specific Blocks
                                    if ($benefit->benefit_code == 'MT') {
                                        $isFemale = in_array($member->relation, [3, 6, 8, 16]);
                                        if (!$isFemale) {
                                            $isDisabled = true;
                                            $blockReason = 'Female applicants only';
                                        } elseif (!$isEligibleByYears) {
                                            $isDisabled = true;
                                            $blockReason = '3-Year membership required';
                                        }
                                    } elseif ($benefit->benefit_code == 'MR') {
                                        if (!$isEligibleByYears) {
                                            $isDisabled = true;
                                            $blockReason = '5-Year membership required';
                                        }
                                    } elseif (in_array($benefit->benefit_code, ['CE', 'EA'])) {
                                        $isChild = in_array($member->relation, [3, 5, 6]);
                                        if (!$isChild) {
                                            $isDisabled = true;
                                            $blockReason = 'Dependent child only';
                                        }
                                    }
                                @endphp

                                <div
                                    class="list-group-item list-group-item-action d-flex justify-content-between align-items-center {{ $isDisabled ? 'bg-light text-muted' : '' }}">
                                    <div>
                                        <h5 class="mb-1">{{ $member->first_name }} {{ $member->last_name }}</h5>
                                        <p class="mb-1">Relation:
                                            {{ $member->relationDetails->relation_name ?? $member->relation }}</p>

                                        @if ($member->is_aadhar_verified)
                                            <span class="badge bg-success" style="color: #fff;"><i
                                                    class="fas fa-check-circle"></i> Aadhaar Verified</span>
                                        @else
                                            <span class="badge bg-warning text-dark"><i
                                                    class="fas fa-exclamation-triangle"></i> Aadhaar Not Verified</span>
                                        @endif

                                        @if ($memberAppCount > 0)
                                            <span class="badge bg-primary ms-2"><i class="fas fa-file-alt"></i> Applied:
                                                {{ $memberAppCount }} time(s)</span>
                                        @endif

                                        @if ($benefit->benefit_code == 'MT' && isset($isFemale) && !$isFemale)
                                            <span class="badge bg-danger ms-2"><i class="fas fa-venus"></i> Not Eligible
                                                (Male)</span>
                                        @elseif(in_array($benefit->benefit_code, ['CE', 'EA']) && isset($isChild) && !$isChild)
                                            <span class="badge bg-danger ms-2"><i class="fas fa-child"></i> Not a
                                                dependent child</span>
                                        @endif
                                    </div>

                                    @if ($memberAppCount > 0)
                                        <button class="btn btn-info" disabled><i class="fas fa-check"></i>
                                            Applied</button>
                                    @elseif (!$isDisabled)
                                        @if ($member->is_aadhar_verified)
                                            <a href="{{ route('view-form', [$benefit->id, $member->id]) }}"
                                                class="btn btn-success">Select & Proceed <i
                                                    class="fas fa-arrow-right"></i></a>
                                        @else
                                            <button type="button" class="btn btn-primary verify-aadhaar-btn"
                                                data-bs-toggle="modal" data-bs-target="#aadhaarVerificationModal"
                                                data-member-id="{{ $member->id }}"
                                                data-member-name="{{ $member->first_name }} {{ $member->last_name }}">Verify
                                                Aadhaar <i class="fas fa-fingerprint"></i></button>
                                        @endif
                                    @else
                                        <button class="btn btn-secondary" disabled><i class="fas fa-ban"></i>
                                            {{ $blockReason ?: 'Blocked' }}</button>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="alert alert-warning">
                            No family members found in your profile for <strong>{{ $benefit->name }}</strong>. You must
                            add family members before applying for this scheme.
                        </div>
                    @endif
                </div>
                <div class="card-footer">
                    <a href="{{ url()->previous() }}" class="btn btn-secondary">Back</a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal and Script logic remains unchanged below -->
<div class="modal fade" id="aadhaarVerificationModal" tabindex="-1" aria-labelledby="aadhaarModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="aadhaarModalLabel">Aadhaar e-KYC for <span id="modalMemberName"></span></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="alert-container"></div>
                <input type="hidden" id="modalFamilyMemberId" value="">

                <!-- Step 1: Enter Aadhaar Number -->
                <div id="step1Aadhaar">
                    <div class="mb-3">
                        <label for="aadhaar_no" class="form-label">Enter 12-digit Aadhaar Number</label>
                        <input type="text" class="form-control" id="aadhaar_no_input" maxlength="12"
                            placeholder="xxxx xxxx xxxx">
                    </div>
                    <button id="sendOtpBtn" class="btn btn-primary">Send OTP</button>

                    <p class="text-danger" id="errorAadhar" style="display:none"><span id="errorText"></span> </p>
                </div>

                <!-- Step 2: Enter OTP -->
                <div id="step2Otp" style="display: none;">
                    <p class="text-success">An OTP has been sent to the mobile number linked with Aadhaar number <strong
                            id="aadhaarDisplay"></strong>.</p>
                    <div class="mb-3">
                        <label for="otp" class="form-label">Enter 6-digit OTP</label>
                        <input type="text" class="form-control" id="otp_input" maxlength="6">
                    </div>
                    <button id="verifyOtpBtn" class="btn btn-success">Verify OTP</button>
                    <button id="resendOtpBtn" class="btn btn-link" disabled>Resend OTP (<span
                            id="timer">60</span>s)</button>
                </div>

                <!-- Step 3: Confirm Details -->
                <div id="step3Confirm" style="display: none;">
                    <h5 class="text-center text-success mb-3">✓ Aadhaar Verified Successfully</h5>
                    <p>Please confirm the following details fetched via e-KYC.</p>
                    <div class="card">
                        <div class="card-body row">
                            <div class="col-md-4 text-center">
                                <img id="kycPhoto" src="" class="img-thumbnail" alt="Applicant Photo"
                                    style="max-width: 150px;">
                            </div>
                            <div class="col-md-8">
                                <p><strong>Name:</strong> <span id="kycName"></span></p>
                                <p><strong>Date of Birth:</strong> <span id="kycDob"></span></p>
                                <p><strong>Gender:</strong> <span id="kycGender"></span></p>
                                <p><strong>Address:</strong> <span id="kycAddress"></span></p>
                            </div>
                        </div>
                    </div>
                    <div class="form-check mt-3">
                        <input class="form-check-input" type="checkbox" value="" id="consentCheck">
                        <label class="form-check-label" for="consentCheck">
                            I hereby confirm that the above details are correct and consent to saving them for this
                            application.
                        </label>
                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="saveDetailsBtn" style="display: none;">Confirm &
                    Save</button>
            </div>
        </div>
    </div>
</div>

@include('components.footer')
<script type="text/javascript" src="{{ URL::asset('assets/template/js/toastr.min.js') }}"></script>
<script src="{{ URL::asset('assets/encrypt/crypto-js.min.js') }}"></script>
<script src="{{ URL::asset('assets/encrypt/Encryption.js') }}"></script>
<script>
    $(document).ready(function() {
        let otpInterval;
        let kycDataStore = {};
        let aadhaarModal; // Store modal instance
        const nonceValue = "{{ $nonceValue }}";
        const token = "{{ csrf_token() }}";

        // Initialize modal instance once
        aadhaarModal = new bootstrap.Modal(document.getElementById('aadhaarVerificationModal'));

        // 1. Setup Modal on button click
        $('.verify-aadhaar-btn').on('click', function() {
            const memberId = $(this).data('member-id');
            const memberName = $(this).data('member-name');
            $('#modalFamilyMemberId').val(memberId);
            $('#modalMemberName').text(memberName);
            resetModal();
            aadhaarModal.show();
        });

        function resetModal() {
            $('#alert-container').html('');
            $('#step1Aadhaar').show();
            $('#step2Otp, #step3Confirm, #saveDetailsBtn').hide();
            $('#aadhaar_no_input').val('').prop("readonly", false);
            $('#otp_input').val('');
            $('#sendOtpBtn, #verifyOtpBtn, #saveDetailsBtn').prop('disabled', false);
            clearInterval(otpInterval);
        }

        // 2. Send OTP
        $('#sendOtpBtn').on('click', function() {
            const uid = $('#aadhaar_no_input').val();
            const memberId = $('#modalFamilyMemberId').val();

            if (uid.length !== 12) {
                $("#errorText").html('Please enter a valid 12-digit Aadhaar number');
                        $("#errorAadhar").show();
                toastr.error('Please enter a valid 12-digit Aadhaar number');
                return;
            }

            const $button = $(this);
            $("#errorAadhar").hide();
            $button.prop('disabled', true).html(
                '<span class="spinner-border spinner-border-sm"></span> Sending...');

            let encryption = new Encryption();
            var uidEnc = encryption.encrypt(uid, nonceValue);

            $.ajax({
                url: "{{ route('family.aadhaar.send-otp') }}",
                method: 'POST',
                data: {
                    uid_enc: uidEnc,
                    family_member_id: memberId,
                    _token: token
                },
                success: function(response) {
                    if (response.status === '0') {
                        var mobile = response.mobile;
                        toastr.success('OTP sent to Aadhaar linked mobile ' + mobile);
                        $('#step1Aadhaar').hide();
                        $('#step2Otp').show();
                        $('#aadhaar_no_input').prop("readonly", true);
                        startOtpTimer();
                    } else {
                        console.log('dd');
                        const message = response.message || response.errorDescription ||
                            'Failed to generate OTP, please try again!';
                        $("#errorText").html('Failed to generate OTP, please try again!');
                        $("#errorAadhar").show();
                        toastr.error(message);
                    }
                },
                error: function(xhr) {
                    toastr.error('An error occurred. Please check the console.');
                    console.error(xhr.responseText);
                },
                complete: function() {
                    $button.prop('disabled', false).html('Send OTP');
                }
            });
        });

        // 3. Verify OTP
        $('#verifyOtpBtn').on('click', function() {
            const dynamicPin = $('#otp_input').val();

            if (!dynamicPin || dynamicPin.length !== 6) {
                toastr.error('Please enter a valid 6-digit OTP');
                return;
            }

            const $button = $(this);
            $button.prop('disabled', true).html(
                '<span class="spinner-border spinner-border-sm"></span> Verifying...');

            $.ajax({
                url: "{{ route('family.aadhaar.verify-otp') }}",
                method: 'POST',
                data: {
                    dynamicPin: dynamicPin,
                    consent: 'y',
                    _token: token
                },
                success: function(response) {
                    if (response.errorCode === '000') {
                        toastr.success('Aadhaar e-KYC Completed Successfully!');
                        kycDataStore = response;

                        $('#kycPhoto').attr('src', 'data:image/jpeg;base64,' + response
                            .kycData.photo);
                        $('#kycName').text(response.kycData.name);
                        $('#kycDob').text(response.kycData.dob);
                        $('#kycGender').text(response.kycData.gender);
                        $('#kycAddress').text(response.kycData.address);

                        $('#step2Otp').hide();
                        $('#step3Confirm').show();
                        $('#saveDetailsBtn').show().prop('disabled', true);
                        $('#consentCheck').prop('checked', false);
                    } else {
                        const message = response.errorMessage || 'Aadhaar e-KYC Failed!';
                        toastr.error(message);
                    }
                },
                error: function(xhr) {
                    toastr.error('An error occurred during verification.');
                    console.error(xhr.responseText);
                },
                complete: function() {
                    $button.prop('disabled', false).html('Verify OTP');
                }
            });
        });

        // 4. Consent Check and Save Details
        $('#consentCheck').on('change', function() {
            $('#saveDetailsBtn').prop('disabled', !this.checked);
        });

        $('#saveDetailsBtn').on('click', function() {
            const $button = $(this);
            $button.prop('disabled', true).html(
                '<span class="spinner-border spinner-border-sm"></span> Saving...');

            $.ajax({
                url: "{{ route('family.aadhaar.save-details') }}",
                method: 'POST',
                data: {
                    _token: token,
                    vaultToken: kycDataStore.vaultToken,
                    vaultPassKey: kycDataStore.vaultPasskey
                },
                success: function(response) {
                    console.log('Save response:', response);
                    if (response.success) {

                        toastr.success(
                            'Aadhaar details saved successfully! The page will now reload.'
                        );
                        aadhaarModal.hide();
                        setTimeout(() => location.reload(), 3000);
                    } else {
                        toastr.error(response.message || 'Could not save details.');
                        $button.prop('disabled', false).html('Confirm & Save');
                    }
                },
                error: function(xhr) {
                    console.error('Save error:', xhr.responseJSON);
                    toastr.error('An error occurred while saving.');
                    console.error(xhr.responseText);
                    $button.prop('disabled', false).html('Confirm & Save');
                }
            });
        });

        // 5. Timer and Resend Logic
        function startOtpTimer() {
            let timer = 90;
            $('#resendOtpBtn').prop('disabled', true);
            otpInterval = setInterval(function() {
                let minutes = parseInt(timer / 60, 10);
                let seconds = parseInt(timer % 60, 10);
                minutes = minutes < 10 ? "0" + minutes : minutes;
                seconds = seconds < 10 ? "0" + seconds : seconds;
                $('#timer').text(minutes + ":" + seconds);
                if (--timer < 0) {
                    clearInterval(otpInterval);
                    $('#resendOtpBtn').prop('disabled', false);
                    $('#timer').text("00:00");
                }
            }, 1000);
        }

        $('#resendOtpBtn').click(function() {
            toastr.info('Requesting a new OTP...');
            $('#sendOtpBtn').click();
        });
    });
</script>
