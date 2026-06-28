// let host = "{{ route('home.index') }}";
$(document).ready(function () {

    var csrfToken = $('meta[name="csrf-token"]').attr('content');
    let authToken = null; // Store the auth token globally
    const host = base_url;

    function showLoader() {
        $('#loader-overlay').show(); // Show overlay loader
    }

    function hideLoader() {
        $('#loader-overlay').hide(); // Hide overlay loader
    }

    function getEncryptedData() {
        return $.ajax({
            url: 'encrypt-data',
            type: 'POST',
            headers: {
                'X-CSRF-TOKEN': csrfToken,
            },
        });
    }

    function generateAuthToken(encryptedData) {
        return $.ajax({
            url: '/worker/generate-auth-token',
            type: 'POST',
            headers: {
                'X-CSRF-TOKEN': csrfToken,
            },
            data: {
                encRequest: encryptedData,
            },
        });
    }

    // Generate auth token when the user focuses on the eShram input field
    $('#uan').focus(function () {
        if (!authToken) {
            showLoader(); // Show loader
            getEncryptedData()
                .done(function (response) {
                    if (response.encRequest) {
                        generateAuthToken(response.encRequest)
                            .done(function (response) {
                                if (response.jwtToken) {
                                    console.log('JWT Token:', response.jwtToken);
                                    authToken = response.jwtToken; // Store the auth token
                                } else {
                                    console.error('Failed to retrieve JWT token');
                                }
                            })
                            .fail(function (xhr, status, error) {
                                console.error('Error generating auth token:', error);
                            })
                            .always(hideLoader); // Hide loader
                    } else {
                        console.error('Failed to retrieve encrypted data');
                        hideLoader();
                    }
                })
                .fail(function (xhr, status, error) {
                    console.error('Error retrieving encrypted data:', error);
                    hideLoader();
                });
        }
    });

    $('#verifyButtonEshram').click(function (event) {
        event.preventDefault();

        const dobValue = $('#dob').val();
        // let yearOnly = '';
        // if (dobValue.includes('-')) {
        //     yearOnly = dobValue.split('-')[0]; // for YYYY-MM-DD
        // } else if (dobValue.includes('/')) {
        //     yearOnly = dobValue.split('/')[2]; // for DD/MM/YYYY
        // }
        // console.log(yearOnly)
        const uanNo = $('#uan').val();
        const name = $('#name').val();

        const data = {
            uanNo: uanNo,
            dob: dobValue,
            name: name,
        };

        console.log(data);

        showLoader(); // Show loader

        $.ajax({
            url: '/worker/encrypt-data-uan',
            type: 'POST',
            contentType: 'application/json',
            data: JSON.stringify(data),
            headers: {
                'X-CSRF-TOKEN': csrfToken,
            },
            success: function (response) {
                if (response.encRequest) {
                    console.log('Encrypted data:', response.encRequest);
                    $.ajax({
                        url: '/worker/validate-uan-no',
                        type: 'POST',
                        contentType: 'application/json',
                        data: JSON.stringify({ encRequest: response.encRequest }),
                        headers: {
                            'Authorization': authToken, // JWT token
                            'X-CSRF-TOKEN': csrfToken, // CSRF token
                        },
                        success: function (response) {
                            hideLoader(); // Hide loader on success
                            console.log(response);
                            if (response.code === 1) {
                                Swal.fire({
                                    title: 'UAN Validation is Successful',
                                    icon: 'success',
                                    confirmButtonText: 'Ok',
                                    allowOutsideClick: false,
                                });
                                $('#submitButtonBasic').removeAttr('disabled');
                            } else if (response.code === 0) {
                                Swal.fire({
                                    title: 'UAN Validation Failed, Data not found!',
                                    icon: 'error',
                                    confirmButtonText: 'Ok',
                                    allowOutsideClick: false,
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        window.location.href = host; // Change to your home page URL
                                    }
                                });
                            } else if (response.status === 403) {
                                Swal.fire({
                                    title: 'e-Shram Server is busy, Kindly wait or try after some time',
                                    icon: 'error',
                                    confirmButtonText: 'Ok',
                                    allowOutsideClick: false,

                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        window.location.href = host; // Change to your home page URL
                                    }
                                });
                            }
                        },
                        error: function (xhr, status, error) {
                            hideLoader(); // Hide loader on error
                            console.log(xhr.responseText);
                            alert('Validation Unsuccessful');
                            window.location.href = host;
                        },
                    });
                } else {
                    hideLoader(); // Hide loader if encryption fails
                    console.error('Encryption failed on the backend.');
                }
            },
            error: function (xhr, status, error) {
                hideLoader(); // Hide loader on error
                console.log(xhr.responseText);
                alert('Failed to encrypt data.');
            },
        });
    });
});