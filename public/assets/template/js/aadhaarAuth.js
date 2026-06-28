$(document).ready(function () {
    let otpInterval;

    $('#verifyButton').click(function (event) {
        const uid = $('#uid').val();


        if (uid === '') {
            toastr.error('Please enter UID.');
            return;
        }
        if (uid.length < 12) {
            toastr.error('Please enter 12 digit Aadhaar number');
            return;
        }
        var $button = $(this);
        var $spinner = $('#spinner');
        var $buttonText = $('#buttonText');
        $button.prop('disabled', true);
        $buttonText.text('Please wait...');
        $spinner.show();
        var nonceValue = nonce_value;
        // Encrypt form data
        let encryption = new Encryption();
        var uidEnc = encryption.encrypt(uid, nonceValue);

        $.ajax({
            url: 'generate-otp-aadhaar',
            method: 'POST',
            data: { uid: uidEnc, _token: token },
            success: function (response) {
                if (response.status === '0') {
                    var mobile = response.mobile;
                    toastr.success('OTP has been sent to your Aadhaar linked mobile ' + mobile);
                    $('#otpVerification').show();
                    $("#uid").prop("readonly", true);
                    $('#verifyButton').hide();
                    startOtpTimer();
                }
                else if (response.errorCode === '565') {
                    // Hide OTP input field if status is not 0
                    toastr.error('License key has expired ');

            $('#otpExVerification').hide();
        }
                else if(response.errorCode === '998') {
                    // Hide OTP input field if status is not 0
                    toastr.error('Invalid Aadhaar Number!');

                    $('#otpExVerification').hide();
                }


                else {
                    // Hide OTP input field if status is not 0
                    toastr.error('Failed To Generate OTP,please try again!');
                    $('#otpVerification').hide();
                }
            },
            error: function (xhr, status, error) {
                $('#spinner').hide();
                $('#verifyButton').prop('disabled', false);
                console.error('Error:', error);

                if (xhr.status >= 500) {
                    console.error('Server Error: An error occurred on the server, please try again later.');
                } else {
                    console.error('Request Error:', error);
                }
            },
            complete: function () {
                // Restore button text and hide the spinner
                $button.prop('disabled', false);
                $buttonText.text('Generate OTP');
                $spinner.hide();
            }
        });
    });

    $('#consent').change(function () {
        if (this.checked) {
            $('.otp-input').prop('disabled', false);
        } else {
            $('.otp-input').prop('disabled', true).val(''); // Clear the OTP fields when disabled
        }
    });

    $('#otpInputs').on('input', '.otp-input', function () {
        var $this = $(this);
        if ($this.val().length === 1) {
            $this.next('.otp-input').focus();
        }
    });

    $('#otpInputs').on('keydown', '.otp-input', function (e) {
        var $this = $(this);
        if (e.key === 'Backspace' && $this.val().length === 0) {
            $this.prev('.otp-input').focus();
        }
    });

    $('#submitOTP').click(function (event) {
        event.preventDefault();

        // Collect OTP from individual input fields
        var dynamicPin = '';
        $('.otp-input').each(function () {
            dynamicPin += $(this).val();
        });

        const consentChecked = $('#consent').is(':checked');
        if (!consentChecked) {
            toastr.error('You must agree to the terms and conditions');
            return;
        }

        if (dynamicPin.length !== 6) {
            toastr.error('Please enter a 6-digit OTP');
            return;
        }

        // Set consent value to 'y'
        const consent = 'y';
        // console.log(consent);

        $.ajax({
            url: 'ekyc-otp-aadhaar',
            method: 'POST',
            data: {
                dynamicPin: dynamicPin,
                consent: consent,
                _token: token
            },
            beforeSend: function () {
                // Show the loader
                $('#spinner-old-auth').show();
                // Disable the button
                $('#submitOTP').prop('disabled', true);
            },

            success: function (response) {
                // Hide the loader
                $('#spinner-old-auth').hide();
                // Re-enable the button
                $('#submitOTP').prop('disabled', true);

                if (response.errorCode === '000') {
                    toastr.success('Aadhaar eKyc Completed Successfully!');
                    $('#otpVerification').hide();
                    $('#register-btn-worker').show();
                    $('.captcha').show();
                    $('.captcha-submit').show();
                } else {
                    toastr.error('Aadhaar eKyc Failed!');
                    $('#submitOTP').prop('disabled', false);
                }
            },
            error: function (xhr) {
                // Hide the loader
                $('#spinner-old-auth').hide();
                // Re-enable the button
                $('#submitOTP').prop('disabled', false);

                if (xhr.status >= 500) {
                    toastr.error('Server error, please try again later.');
                } else {
                    toastr.error('An error occurred, please try again.');
                }
            }
        });
    });



    $('#resendOtpButton').click(function (event) {
        $('.otp-input').val('');
        $('#verifyButton').click();
    });

    function startOtpTimer() {
        const duration = 90; // 3 minutes in seconds
        let timer = duration, minutes, seconds;

        otpInterval = setInterval(function () {
            minutes = parseInt(timer / 60, 10);
            seconds = parseInt(timer % 60, 10);

            minutes = minutes < 10 ? "0" + minutes : minutes;
            seconds = seconds < 10 ? "0" + seconds : seconds;

            $('#otpTimer').text("Resend OTP in " + minutes + ":" + seconds);

            if (--timer < 0) {
                clearInterval(otpInterval);
                $('#otpTimer').text("");
                $('#resendOtpButton').prop('disabled', false);
            }
        }, 1000);

        $('#resendOtpButton').prop('disabled', true);
    }

    // Make sure to clear the interval if the page is refreshed or navigated away from
    $(window).on('beforeunload', function () {
        clearInterval(otpInterval);
    });
});



