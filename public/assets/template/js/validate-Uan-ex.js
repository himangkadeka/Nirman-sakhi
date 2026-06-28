

$(document).ready(function() {
    var csrfToken = $('meta[name="csrf-token"]').attr('content');
    const host = base_url;

    function getEncryptedData() {
        return $.ajax({
            url: 'encrypt-data',
            type: 'POST',
            headers: {
                'X-CSRF-TOKEN': csrfToken
            },

        });
    }


    function generateAuthToken(encryptedData) {
        return $.ajax({
            url: 'generate-auth-token',
            type: 'POST',
            headers: {
                'X-CSRF-TOKEN': csrfToken
            },
            data: {
                encRequest: encryptedData
            }
        });
    }

    getEncryptedData().done(function(response) {
        if (response.encRequest) {
            generateAuthToken(response.encRequest).done(function(response) {

                if (response.jwtToken) {
                    console.log('JWT Token:', response.jwtToken);
                    authToken = response.jwtToken;
                } else {
                    console.error('Failed to retrieve JWT token');
                }
            }).fail(function(xhr, status, error) {

                console.error('Error generating auth token:', error);
            });
        } else {
            console.error('Failed to retrieve encrypted data');
        }
    }).fail(function(xhr, status, error) {

        console.error('Error retrieving encrypted data:', error);
    });

    $('#verifyButtonEx').click(function(event) {
        event.preventDefault();

        const dobValue = $('#dob').val();
        // let yearOnly = '';
        // if (dobValue.includes('-')) {
        //     yearOnly = dobValue.split('-')[0]; // for YYYY-MM-DD
        // } else if (dobValue.includes('/')) {
        //     yearOnly = dobValue.split('/')[2]; // for DD/MM/YYYY
        // }
        const uanNo = $('#uan').val();
        const name = $('#name').val();


        const data = {
            uanNo: uanNo,
            dob: dobValue,
            name: name
        };

        console.log(data);

        $.ajax({

            url: 'encrypt-data-uan',
            type: 'POST',
            contentType: 'application/json',
            data: JSON.stringify(data),
            headers: {
                'X-CSRF-TOKEN': csrfToken
            },
            success: function(response) {
                if (response.encRequest) {
                    console.log('Encrypted data:', response.encRequest);
                    $.ajax({
                        url: 'validate-uan-no',
                        type: 'POST',
                        contentType: 'application/json',
                        data: JSON.stringify({ encRequest: response.encRequest }),
                        headers: {
                            'Authorization': authToken,  // JWT token
                            'X-CSRF-TOKEN': csrfToken    // CSRF token
                        },
                        success: function(response) {
                            console.log(response);
                            if (response.code === 1) {
                                alert('Validation successful');
                                $('#submitBtnBasic').removeAttr('disabled');
                            } else if (response.code === 0) {
                                Swal.fire({
                                    title: 'UAN Validation Failed,Data Not found!',
                                    icon: 'error',
                                    confirmButtonText: 'Ok',
                                    allowOutsideClick: false
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        window.location.href = host;
                                    }
                                });
                            }else if (response.status === 403) {
                                Swal.fire({
                                    title: 'e-Shram Server is busy, Kindly wait or try after some time',
                                    icon: 'error',
                                    confirmButtonText: 'Ok',
                                    allowOutsideClick: false
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        window.location.href = host;
                                    }
                                });
                            }
                        },
                        error: function(xhr, status, error) {
                            console.log(xhr.responseText);
                            alert('Validation Unsuccessful');
                            window.location.href = host;
                        }
                    });
                } else {
                    console.error('Encryption failed on the backend.');
                }
            },
            error: function(xhr, status, error) {
                console.log(xhr.responseText);
                alert('Failed to encrypt data.');
            }
        });
    });
});
