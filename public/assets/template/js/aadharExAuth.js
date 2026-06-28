$(document).ready(function() {
    let otpInterval;

    $('#verifyExButton').click(function(event) {
        const uid = $('#uid').val();
        if (uid === '') {
            toastr.error('Please enter UID');
            return;
        }
        if (uid.length < 12) {
            toastr.error('Please enter 12 digit Aadhaar number');
            return;
        }
        var $button = $(this);
        var $spinner = $('#spinner');
        var $buttonText = $('#buttonText');

        // Change button text to "Please wait..." and show the spinner
        $button.prop('disabled', true);
        $buttonText.text('Please wait...');
        $spinner.show();
        var nonceValue = nonce_value;
        let encryption = new Encryption();
        var uidEnc = encryption.encrypt(uid, nonceValue);

        $.ajax({
            url: 'generate-otp-aadhaar',
            method: 'POST',
            data: { uid: uidEnc, _token: token },
            success: function(response) {
                console.log(response.errorCode);
                if (response.status === '0') {
                    var mobile = response.mobile;
                    toastr.success('OTP has been sent to your Aadhaar linked mobile ' + mobile);
                    $('#otpExVerification').show();
                    $("#uid").prop("readonly", true);
                    $('#verifyExButton').hide();
                    startOtpTimer();
                } else if(response.errorCode === '565') {
                    // Hide OTP input field if status is not 0
                    toastr.error('License key has expired ');

                    $('#otpExVerification').hide();
                }
                else {
                    // Hide OTP input field if status is not 0
                    // console.log(response.errorCode)
                    toastr.error('Failed To Generate OTP,please try again!');
                    $('#otpVerification').hide();
                }
            },
            error: function(xhr, status, error) {
                $('#spinner').hide();
                $('#verifyExButton').prop('disabled', false);
                console.error('Error:', error);

                if (xhr.status >= 500) {
                    console.error('Server Error: An error occurred on the server, please try again later.');
                } else {
                    console.error('Request Error:', error);
                }
            },
            complete: function() {
                // Restore button text and hide the spinner
                $button.prop('disabled', false);
                $buttonText.text('Generate OTP');
                $spinner.hide();
            }
        });
    });

    $('#consent').change(function() {
        if (this.checked) {
            $('.otp-input').prop('disabled', false);
        } else {
            $('.otp-input').prop('disabled', true).val(''); // Clear the OTP fields when disabled
        }
    });

    $('#otpInputs').on('input', '.otp-input', function() {
        var $this = $(this);
        if ($this.val().length === 1) {
            $this.next('.otp-input').focus();
        }
    });

    $('#otpInputs').on('keydown', '.otp-input', function(e) {
        var $this = $(this);
        if (e.key === 'Backspace' && $this.val().length === 0) {
            $this.prev('.otp-input').focus();
        }
    });

    $('#submitExOTP').click(function(event) {
        event.preventDefault();

        // Collect OTP from individual input fields
        var dynamicPin = '';
        $('.otp-input').each(function() {
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
            beforeSend: function() {
                // Show the loader
                $('#spinner-old-auth').show();
                // Disable the button
                $('#submitExOTP').prop('disabled', true);
            },

            success: function(response) {
                // Hide the loader
                $('#spinner-old-auth').hide();
                // Re-enable the button
                $('#submitExOTP').prop('disabled', true);
                console.log(response);

                if (response.errorCode === '000') {
                    toastr.success('Aadhaar eKyc Completed Successfully!');
                    $('#otpExVerification').hide();
                    $('#register-btn-worker-old').show();
                    $('.captcha').show();
                    $('.captcha-submit').show();
                } else {
                    toastr.error('Aadhaar eKyc Failed!');
                    $('#submitExOTP').prop('disabled', false);
                }
            },
            error: function(xhr) {
                // Hide the loader
                $('#spinner-old-auth').hide();
                // Re-enable the button
                $('#submitExOTP').prop('disabled', false);

                if (xhr.status >= 500) {
                    toastr.error('Server error, please try again later.');
                } else {
                    toastr.error('An error occurred, please try again.');
                }
            }
        });
    });


    // toastr.options = {
    //     "positionClass": "toast-top-center",
    //     "preventDuplicates": true,
    //     "timeOut": 3000
    // };

    // $('#consent').change(function() {
    //     $('#dynamicPin').prop('readonly', !this.checked);
    // });

    $('#resendOtpButton').click(function(event) {
        $('.otp-input').val('');
        $('#verifyExButton').click();
    });

    function startOtpTimer() {
        const duration = 90; // 3 minutes in seconds
        let timer = duration, minutes, seconds;

        otpInterval = setInterval(function() {
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
    $(window).on('beforeunload', function() {
        clearInterval(otpInterval);
    });
});



