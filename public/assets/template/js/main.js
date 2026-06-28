// Sidebar
$("#menu-toggle").click(function (e) {
    e.preventDefault();
    $("#wrapper").toggleClass("toggled");
});

$('.sub-menu ul').hide();
$('.sub-sub-menu ul').hide();
$(".sub-menu a").click(function () {
    $(this).parent(".sub-menu").children("ul").slideToggle("100");
    $(this).find(".right").toggleClass("fa-caret-up fa-caret-down");
});

$(".sub-sub-menu a").click(function () {
    $(this).parent(".sub-sub-menu").children("ul").slideToggle("100");
    $(this).find(".right").toggleClass("fa-caret-up fa-caret-down");
});

// End Sidebar


// Datatable
$(document).ready(function () {
    $('#abaocTable').DataTable({
        dom: '<"dt-top-container"fB<"dt-button-space">l><r>t<"dt-filter-spacer"><ip>',
        buttons: ['copy', 'csv', 'excel', 'pdf', 'print']
    });
});

function dataTable(id) {
    $(id).DataTable({
        dom: '<"dt-top-container"fB<"dt-button-space">l><r>t<"dt-filter-spacer"><ip>',
        buttons: ['copy', 'csv', 'excel', 'pdf', 'print']
    });
}

// End Data Table


const host = base_url;

// =======================Form Submit===========================

$(document).ready(function () {
    $('.master-data-form').submit(function (event) {
        event.preventDefault();
        $.ajax({
            type: 'POST',
            url: $(this).attr('action'),
            data: $(this).serialize(),
            success: function (response) {
                if (response.status == true) {
                    window.location.reload();
                } else {
                    console.log(response);
                    window.location.reload();
                }
            },
            error: function (xhr, status, error) {
                console.error(xhr.responseText);
            }
        });
    });
});

// =================END FORM SUBMIT============================

// =======================DELETE FORM=======================

function confirmDelete(id, string) {
    Swal.fire({
        title: 'Are you sure?',
        text: 'You are about to delete the ' + string + '.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes, Delete !',
        cancelButtonText: 'No, cancel!',
        reverseButtons: true
    }).then((result) => {
        if (result.isConfirmed) {
            // Update the form values
            document.getElementById('primary_code_input').value = id;
            // Submit the form
            document.getElementById('deleteForm').submit();
        }
    });
}

// =======================END DELETE FORM=======================
// ===========================State Masterdata==================
// Send Data to Edit Modal
function editState(code, data) {
    $("#edit-state-code").val(code);
    $("#edit-state-name").val(data);
    $('#state_code').val(code)
}


// ========================END STATE MASTERDATA===============================

// ========================DISTRICT MASTERDATA================================


// Send Data to Edit Modal
function editDistrict(district_code, state_code, district_name) {
    $("#state_code_select").val(state_code);
    $("#edit-district-code").val(district_code);
    $('#edit-district-name').val(district_name);
    $("#state_code_select option").each(function () {
        if ($(this).val() == state_code) {
            $(this).prop("selected", true);
        }
    })
}




// $("#state_code").on("change", function () {
//     var statecode = $("#po-state").val();
//     $.ajax
//         ({

//             url: host + 'admin/getdistrict',
//             method: 'POST',
//             data: 'statecode=' + statecode,
//             cache: false,
//             dataType: 'JSON',
//             success: function (response) {
//                 console.log(response);
//                 $('#po-district').html(response.districtinfo);
//             }

//         });

// });

// ================SUB DISTRICT===================

function clearFormFields() {
    document.getElementById("add-sub-district-form").reset();
}

function editSubdistrict(subdistrict_code, subdistrict_name, district_code, state_code) {
    $("#edit-sub-district-name").val(subdistrict_name);
    $("#edit-sub-district-code").val(subdistrict_code);


    $("#edit_state_code_select option").each(function () {
        if ($(this).val() == state_code) {
            $(this).prop("selected", true);
        }
    });
    getDistrict(state_code, district_code)
}


// ==================END SUB DISTRICT==================

// ========================BANK========================
// Search Post -office
$(document).ready(function () {
    $('#bank-search').submit(function (event) {
        $("#bank-table tbody").html('');
        if ($.fn.DataTable.isDataTable('#bank-table')) {
            $('#bank-table').DataTable().destroy();
        }
        event.preventDefault();
        $.ajax({
            type: 'POST',
            url: $(this).attr('action'),
            data: $(this).serialize(),
            success: function (response) {
                if (response.status == false) {
                    location.reload()
                } else {
                    $("#bank-table tbody").html(response.results);
                    dataTable("#bank-table");
                }
            },
            error: function (xhr, status, error) {
                console.error(xhr.responseText);
            }
        });
    });
});

// Edit Bank

function editBank(id, state, ifsc, branch_name, bank_name) {
    $("#bank_id").val(id);
    $("#state-code-edit").val(state);
    $("#ifsc-code-edit").val(ifsc)
    $("#branch-name-edit").val(branch_name);
    $("#bank-name-edit").val(bank_name);
    $("#state_code_select_edit option").each(function () {
        if ($(this).val() == state) {
            $(this).prop("selected", true);
        }
    })
}
// ======================END BANK======================

// ====================POST OFFICE====================


// Search Post -office
$(document).ready(function () {
    $('#post-office-search').submit(function (event) {
        $("#post-office-table tbody").html('');
        if ($.fn.DataTable.isDataTable('#post-office-table')) {
            $('#post-office-table').DataTable().destroy();
        }
        event.preventDefault();
        $.ajax({
            type: 'POST',
            url: $(this).attr('action'),
            data: $(this).serialize(),
            success: function (response) {
                if (response.status == false) {
                    location.reload()
                } else {
                    $("#post-office-table tbody").html(response.results);
                    dataTable("#post-office-table");
                }
            },
            error: function (xhr, status, error) {
                console.error(xhr.responseText);
            }
        });
    });
});

// Edit Post Office

function editPostofficemodal(id, district_name, state_name, pin_code, post_office_name) {
    $("#edit-post-office-id").val(id);
    $("#post-office-state-edit").val(state_name);
    $("#post-office-district-edit").val(district_name);
    $("#edit_pin_code").val(pin_code);
    $("#edit-post-office-name").val(post_office_name);

}
// ===========================END POST OFFICE===========================

// ==============================CATEGORY==============================

function categoryEditModal(category_code, category_name) {
    $("#category_id").val(category_code);
    $("#category_name_edit").val(category_name);
}
// ==============================END CATEGORY==========================

/// ==============================EDUCATION==============================

function educationEditModal(education_code, education_name) {
    $("#education_id").val(education_code);
    $("#education_name_edit").val(education_name);
}
// ==============================END EDUCATION==========================

/// ==============================GENDER==============================

function genderEditModal(gender_code, gender_name) {
    $("#gender_id").val(gender_code);
    $("#gender_name_edit").val(gender_name);
}
// ==============================END GENDER==========================

// ==============================HOUSE TYPE==============================

function houseTypeEditModal(house_type_code, house_type_name) {
    $("#house_type_id").val(house_type_code);
    $("#house_type_name_edit").val(house_type_name);
}
// ==============================END HOUSE TYPE==========================

// ==============================MARITAL STATUS==============================

function maritalStatusEditModal(marital_status_code, marital_status_name) {
    $("#marital_status_id").val(marital_status_code);
    $("#marital_status_name_edit").val(marital_status_name);
}
// ==============================END MARITAL STATUS==========================


// ==============================NATURE OF WORK==============================

function natureOfWorkEditModal(nature_of_work_code, nature_of_work_name) {
    $("#nature_of_work_id").val(nature_of_work_code);
    $("#nature_of_work_name_edit").val(nature_of_work_name);
}
// ==============================END NATURE OF WORK==========================

// ==============================DESIGNATION==============================

function ageDesignationEditModal(designation_code, designation_name) {
    $("#designation_id").val(designation_code);
    $("#designation_name_edit").val(designation_name);
}
// ==============================END DESIGNATION==========================


// ==============================AGE PROOF==============================

function ageProofEditModal(age_proof_code, age_proof_name) {
    $("#age_proof_id").val(age_proof_code);
    $("#age_proof_name_edit").val(age_proof_name);
}

// ==============================END AGE PROOF==========================

// ==============================WORK TYPE==============================

function workTypeEditModal(work_type_code, work_type_name) {
    $("#work_type_id").val(work_type_code);
    $("#work_type_name_edit").val(work_type_name);
}
// ==============================END WORK TYPE==========================

// ==============================ISSUER TYPE==============================

function issuerTypeEditModal(issuer_type_code, issuer_type_name) {
    $("#issuer_type_id").val(issuer_type_code);
    $("#issuer_type_name_edit").val(issuer_type_name);
}
// ==============================END ISSUER TYPE==========================

// ==============================RESIDENCE TYPE==============================

function residenceTypeEditModal(residence_type_code, residence_type_name) {
    $("#residence_type_id").val(residence_type_code);
    $("#residence_type_name_edit").val(residence_type_name);
}
// ==============================END RESIDENCE TYPE==========================

// ==============================GALLERY CATEGORY==============================

function galleryCategoryEditModal(gallery_category_code, gallery_category_name) {
    $("#gallery_category_id").val(gallery_category_code);
    $("#gallery_category_name_edit").val(gallery_category_name);
}
// ==============================END GALLERY CATEGORY==========================
// ================================AMOUNT================================

// Edit Modal

function amountEditModal(id, amount_description, amount) {
    $("#amount_id").val(id);
    $("#amount_description_edit").val(amount_description);
    $("#amount_edit").val(amount);
}



// ==============================END AMOUNT==============================

// ==============================RATION TYPE==============================


// edit modal

function editRationTypeModal(id, name) {
    $("#ration_type_id").val(id);
    $("#ration_type_edit").val(name);
}


// ============================END RATION TYPE============================

// =================================SKILL=================================



// edit modal

function skillEditModal(skill_code, skill_name) {
    $("#skill_id").val(skill_code);
    $("#skill_name_edit").val(skill_name)
}

// ===============================END SKILL===============================
// ===============================PROFESSION===============================


// edit profession modal

function professionEditModal(profession_code, profession_name) {
    $("#profession_id").val(profession_code);
    $("#profession_name_edit").val(profession_name)
}


// ===============================END PROFESSION===============================

// ===============================SCHEME===============================

// edit schemes modal

function schemeEditModal(scheme_code, scheme_name) {
    $("#scheme_id").val(scheme_code);
    $("#scheme_name_edit").val(scheme_name)
}

// ===============================END PROFESSION===============================



// ============================OFFICE MANAGEMENT=========================
// ===============================OFFICES================================

function editOfficeData(id, district_code, office_name) {
    $("#office_id").val(id);
    $("#district_select_id").val(district_code);
    $("#office-name").val(office_name);
    $("#district_select_id option").each(function () {
        if ($(this).val() == district_code) {
            $(this).prop("selected", true);
        }
    });
}

function confirmOfficeUpdate(id, status) {
    Swal.fire({
        title: 'Are you sure?',
        text: 'You are about to change the status of the Office',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes, change it!',
        cancelButtonText: 'No, cancel!',
        reverseButtons: true
    }).then((result) => {
        if (result.isConfirmed) {
            // Update the form values
            document.getElementById('office_id_input').value = id;
            document.getElementById('status_input').value = status == 1 ? 0 : 1;

            // Submit the form
            document.getElementById('updateOfficeForm').submit();
        }
    });
}

// ==============================END OFFICE==============================
// =================================ROLE=================================

// edit role
function editRoleData(role_id, role_name) {
    $("#role_id").val(role_id);
    $("#role-name-edit").val(role_name);
}

// ===============================END ROLE===============================

// ==============================PERMISSION==============================
function editPermissionData(permission_id, permission_name) {
    $("#permission_id").val(permission_id);
    $("#permission-name-edit").val(permission_name);
}
// ==========================END PERMISSION==============================

// =================================USER=================================


// edit modal

function editUserData(id, username, firstname, lastname, phone, email, designation_id, office_id, role_id, district_code_edit, is_incharge) {
    $("#user_id").val(id);
    $("#user-name-edit").val(username);
    $("#first-name-edit").val(firstname);
    $("#last-name-edit").val(lastname);
    $("#phone-edit").val(phone);
    new_email = email.replace(/\[at\]/g, '@').replace(/\[dot\]/g, '.');
    $("#email-edit").val(new_email);
    $("#designation_id").val(designation_id);
    $("#district_code_edit").val(district_code_edit);
    $("#role-name-edit").val(role_id);
    $("#is-incharge-edit").val(is_incharge == 1 ? '1' : '0');
    if (district_code_edit) {
        $.ajax({
            url: host + 'worker/get-office',
            type: 'GET',
            data: {
                district_code: district_code_edit,
                _token: '{{csrf_token()}}'
            },
            dataType: 'json',
            success: function (data) {
                var officeDropdown = "#office_id_edit";
                $(officeDropdown).html('<option value="">--Select Office--</option>');
                $.each(data.office, function (key, value) {
                    $(officeDropdown).append('<option value="' + value.office_id + '">' + value.office_name + '</option>');
                });

                // Set the selected office_id
                if (office_id) {
                    $(officeDropdown).val(office_id);
                }
            },
            error: function () {
                alert('Failed to fetch office data. Please try again.');
            }
        });
    } else {
        $('#office_id_edit').empty();
    }
}

function confirmPasswordUpdate(id) {
    Swal.fire({
        title: 'Are you sure?',
        text: 'You are about to change the Password of the User. Your new Password will be your Username',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes, change it!',
        cancelButtonText: 'No, cancel!',
        reverseButtons: true
    }).then((result) => {
        if (result.isConfirmed) {
            // Update the form values
            document.getElementById('user_id_input_pass').value = id;

            // Submit the form
            document.getElementById('updatePasswordForm').submit();
        }
    });
}
function transferUpdateUsers(id, username, firstname, lastname, phone, email, designation_id, office_id, role_id, district_code,is_retired = 0) {
    $("#user_id_transfer").val(id);
    $("#user-name-transfer").val(username);
    $("#first-name-transfer").val(firstname);
    $("#last-name-transfer").val(lastname);
    $("#phone-transfer").val(phone);
    new_email = email.replace(/\[at\]/g, '@').replace(/\[dot\]/g, '.');
    $("#email-transfer").val(new_email);
    $("#designation_id_transfer").val(designation_id);
    $("#district_code_transfer").val(district_code);
    $("#role-name-transfer").val(role_id);
    if (district_code) {
        $.ajax({
            url: host + 'worker/get-office',
            type: 'GET',
            data: {
                district_code: district_code,
                _token: '{{csrf_token()}}'
            },
            dataType: 'json',
            success: function (data) {
                var officeDropdown = "#office_id_transfer";
                $(officeDropdown).html('<option value="">--Select Office--</option>');
                $.each(data.office, function (key, value) {
                    $(officeDropdown).append('<option value="' + value.office_id + '">' + value.office_name + '</option>');
                });

                // Set the selected office_id
                if (office_id) {
                    $(officeDropdown).val(office_id);
                }
            },
            error: function () {
                alert('Failed to fetch office data. Please try again.');
            }
        });
    } else {
        $('#office_id_transfer').empty();
    }

}

$(document).ready(function () {

    $('#district_code_edit').on('change', function () {
        // ajaxStart();
        var office_id = $(this).val();
        // console.log(cState);return
        var district_code = $(this).val();

        if (district_code) {
            $.ajax({
                url: host + 'worker/get-office',
                type: 'GET',
                data: {
                    district_code: district_code,
                    _token: '{{csrf_token()}}'
                },
                dataType: 'json',
                success: function (data) {
                    var dis = '#office_id_edit';
                    console.log(data);
                    $(dis).html('<option value="">--Select Office--</option>');
                    $.each(data.office, function (key, value) {
                        $(dis).append('<option value="' + value.office_id + '">' + value.office_name + '</option>');
                    });

                }
            });
        } else {
            $('#office_id_edit').empty();
            // $('#subdistrict').empty();
        }
    });
});

$(document).ready(function () {

    $('#district_code_transfer').on('change', function () {
        // ajaxStart();
        var office_id = $(this).val();
        // console.log(cState);return
        var district_code = $(this).val();

        if (district_code) {
            $.ajax({
                url: host + 'worker/get-office',
                type: 'GET',
                data: {
                    district_code: district_code,
                    _token: '{{csrf_token()}}'
                },
                dataType: 'json',
                success: function (data) {
                    var dis = '#office_id_transfer';
                    console.log(data);
                    $(dis).html('<option value="">--Select Office--</option>');
                    $.each(data.office, function (key, value) {
                        $(dis).append('<option value="' + value.office_id + '">' + value.office_name + '</option>');
                    });


                }
            });
        } else {
            $('#office_id_transfer').empty();
            // $('#subdistrict').empty();
        }
    });
});

$(document).ready(function () {

    $('#district_code_transfer_to').on('change', function () {
        // ajaxStart();
        var office_id = $(this).val();
        // console.log(cState);return
        var district_code = $(this).val();

        if (district_code) {
            $.ajax({
                url: host + 'worker/get-office',
                type: 'GET',
                data: {
                    district_code: district_code,
                    _token: '{{csrf_token()}}'
                },
                dataType: 'json',
                success: function (data) {
                    var dis = '#office_id_transfer_to';
                    var dis = '#office_id_transfer_to';
                    console.log(data);
                    $(dis).html('<option value="">--Select Office--</option>');
                    $.each(data.office, function (key, value) {
                        $(dis).append('<option value="' + value.office_id + '">' + value.office_name + '</option>');
                    });


                }
            });
        } else {
            $('#office_id_transfer').empty();
            // $('#subdistrict').empty();
        }
    });
});

// Status Update

function confirmUserUpdate(id, status) {
    Swal.fire({
        title: 'Are you sure?',
        text: 'You are about to change the status of the User',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes, change it!',
        cancelButtonText: 'No, cancel!',
        reverseButtons: true
    }).then((result) => {
        if (result.isConfirmed) {
            // Update the form values
            document.getElementById('user_id_input').value = id;
            document.getElementById('status_input').value = status == 1 ? 0 : 1;

            // Submit the form
            document.getElementById('updateUserForm').submit();
        }
    });
}

function confirmReasonUpdate(id, status) {
    Swal.fire({
        title: 'Are you sure?',
        text: 'You are about to change the status of the Reason',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes, change it!',
        cancelButtonText: 'No, cancel!',
        reverseButtons: true
    }).then((result) => {
        if (result.isConfirmed) {
            // Update the form values
            document.getElementById('reason_id_input').value = id;
            document.getElementById('reason_status_input').value = status == 1 ? 0 : 1;

            // Submit the form
            document.getElementById('updateReasonForm').submit();
        }
    });
}

// ===============================END USER===============================

// ===============================BENEFIT===============================
function benefitListEditModal(benefit_code, benefit_name, description) {
    $("#benefit_id").val(benefit_code);
    $("#benefit_name_edit").val(benefit_name);
    $("#benefit_description_edit").val(description);
}

function confirmBenefitUpdate(id, status) {
    Swal.fire({
        title: 'Are you sure?',
        text: 'You are about to change the status of the Benefit',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes, change it!',
        cancelButtonText: 'No, cancel!',
        reverseButtons: true
    }).then((result) => {
        if (result.isConfirmed) {
            // Update the form values
            document.getElementById('benefit_id_input').value = id;
            document.getElementById('status_input').value = status == 1 ? 0 : 1;

            // Submit the form
            document.getElementById('updateBenefitForm').submit();
        }
    });
}




// ==================================AUTH================================
// =========================ADMIN AUTHENTICATION=========================

$(document).ready(function () {
    $('#admin-login').submit(function (event) {
        event.preventDefault();
        $.ajax({
            type: 'POST',
            url: $(this).attr('action'),
            data: $(this).serialize(),
            success: function (response) {
                if (response.status == true) {

                    // alert(response.otp)
                    $('#adminLogin_form').fadeOut(1000);
                    setTimeout(() => {
                        $("#otp_form_admin").fadeIn(2000);
                    }, 1000);

                    $("#username_admin").html(response.username);
                    $("#mobile_admin").html(response.phone);
                    startTimerAdmin();
                } else if (response.results == 0) {
                    location.reload()
                } else {
                    // console.log(response)
                    reloadCaptcha();
                    if (response.error['username'] != null) {
                        $("#username_error_admin").html(response.error['username'][0])
                    } else {
                        $("#username_error_admin").html('');
                    }
                    if (response.error['password'] != null) {
                        $("#password_error_admin").html(response.error['password'][0])
                    } else {
                        $("#password_error_admin").html('');
                    }
                    if (response.error['captcha'] != null) {
                        $("#captcha_error_admin").html(response.error['captcha'][0])
                    } else {
                        $("#captcha_error_admin").html('');
                    }
                }
            },
            error: function (xhr, status, error) {
                console.error(response.results);
                reloadCaptcha();
                if (xhr.response.errors['username'] != null) {
                    $("#username_error_admin").html(xhr.response.errors['username'][0])
                } else {
                    $("#username_error_admin").html('');
                }
                if (xhr.response.errors['password'] != null) {
                    $("#password_error_admin").html(xhr.response.errors['password'][0])
                } else {
                    $("#password_error_admin").html('');
                }
                if (xhr.response.errors['captcha'] != null) {
                    $("#captcha_error_admin").html(xhr.response.errors['captcha'][0])
                } else {
                    $("#captcha_error_admin").html('');
                }
            }
        });
    });
});

function startTimerAdmin() {
    var timeleft = 240;
    var downloadTimer = setInterval(function () {
        timeleft--;
        document.getElementById("timer_admin").textContent = timeleft;
        if (timeleft == 0) {
            $("#resend_timer_admin").hide();
            $("#resend_otp_admin").show();
            $otpButton = document.getElementById("resend_otp_admin");
            $otpButton.removeAttribute('disabled');
        } else if (timeleft < 0)
            clearInterval(downloadTimer);
    }, 1000);

}

const inputs_admin = document.querySelectorAll(".input-field-otp-admin input"),
    button_admin = document.getElementById("verify_otp_admin");

// iterate over all inputs
inputs_admin.forEach((input, index1) => {
    input.addEventListener("keyup", (e) => {
        const currentInput = input,
            nextInput = input.nextElementSibling,
            prevInput = input.previousElementSibling;

        if (currentInput.value.length > 1) {
            currentInput.value = "";
            return;
        }

        if (nextInput && nextInput.hasAttribute("disabled") && currentInput.value !== "") {
            nextInput.removeAttribute("disabled");
            nextInput.focus();
        }

        if (e.key === "Backspace") {
            inputs_admin.forEach((input, index2) => {
                if (index1 <= index2 && prevInput) {
                    input.setAttribute("disabled", true);
                    input.value = "";
                    prevInput.focus();
                }
            });
        }

        if (!inputs_admin[5].disabled && inputs_admin[5].value !== "") {
            button_admin.classList.add("active");
            return;
        }
        button_admin.classList.remove("active");
    });
});

//focus the first input which index is 0 on window load
window.addEventListener("load", () => inputs_admin[0].focus());

$("#resend_otp_admin").on('click', function () {

    const username = $("#username_admin").html();
    sendOfficeorAdminOtp(username);
    startTimerAdmin();
    $("#resent_msg_admin").addClass('text-success');
    $("#resent_msg_admin").html("OTP Resent Successfully");
    setTimeout(() => {
        $("#resent_msg_admin").fadeOut(2000);
    }, 5000);
    $("#resend_timer_admin").show();
    $("#resend_otp_admin").hide();
    $otpButton = document.getElementById("resend_otp_admin");
    $otpButton.setAttribute('disabled', true);
})


// Send OTP
async function sendOfficeorAdminOtp(username) {
    const form = document.getElementById('resendOtpFrom');
    const url = form.getAttribute('action');

    document.getElementById('username_input').value = username;

    try {
        const response = await fetch(url, {
            method: 'POST',
            body: new FormData(form)
        });

        if (response.ok) {
            const responseData = await response.json();
            // Handle the response data here
            // console.log(responseData);
        } else {
            throw new Error('Failed to send OTP');
        }
    } catch (error) {
        console.error(error);
    }
}

const otpInputsAdmin = document.querySelectorAll('.input-field-otp-admin input');

function collectAdminOTPValues() {
    let otpValue = '';
    otpInputsAdmin.forEach(input => {
        if (!input.disabled) {
            otpValue += input.value;
        }
    });
    return otpValue;
}



$("#verify_otp_admin").on('click', function () {

    const otpCode = collectAdminOTPValues();

    verify_otp = document.getElementById('verify_otp_admin');
    verify_otp.setAttribute('disabled', true);
    console.log(host);
    $.ajax({
        "url": host + 'auth/verify-otp',
        "method": 'POST',
        "data": {
            "_token": $('meta[name="csrf-token"]').attr('content'),
            "username": $("#username_admin").html(),
            "otp": otpCode,
            "role": "admin"
        },
        "cache": false,
        "dataType": 'JSON',
        "processing": true,
        "serverside": true,
        success: function (res) {

            if (res.status == false) {

                verify_otp.removeAttribute('disabled');
                Swal.fire({
                    title: 'Verification Failed',
                    text: res.msg,
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
            } else {
                Swal.fire({
                    title: 'Login Successfull!',
                    text: 'OTP Verified',
                    icon: 'success',
                    showConfirmButton: false
                });
                console.log(res.redirect)
                setTimeout(() => {
                    // Replace 'your_redirect_url' with the URL where you want to redirect
                    window.location.href = res.redirect;
                }, 2000);
            }

        },

    });
});




// ==========================END ADMIN AUTH==============================

// =============================OFFICE AUTH=============================

// $(document).ready(function () {
//     $('#office-login-form').submit(function (event) {
//         event.preventDefault();
//         $.ajax({
//             type: 'POST',
//             url: $(this).attr('action'),
//             data: $(this).serialize(),
//             success: function (response) {
//                 if (response.status == true) {
//
//                     // Successful login - show OTP form
//                     $('#officialLogin_form').fadeOut(1000);
//                     setTimeout(() => {
//                         $("#otp_form_official").fadeIn(2000);
//                     }, 1000);
//
//                     $("#username").html(response.username);
//                     $("#mobile").html(response.phone);
//                     startTimerOffice();
//
//                 } else {
//                     // Wrong credentials or validation errors
//                     reloadCaptcha();
//
//                     if (response.results == 0) {
//                         // Instead of reload, just show an error message
//                         $("#general_error").html("Invalid credentials, please try again.").css("color", "red");
//                     } else {
//                         // Show validation errors
//                         if (response.error['username'] != null) {
//                             $("#username_error").html(response.error['username'][0])
//                         } else {
//                             $("#username_error").html('');
//                         }
//                         if (response.error['password'] != null) {
//                             $("#password_error").html(response.error['password'][0])
//                         } else {
//                             $("#password_error").html('');
//                         }
//                         if (response.error['captcha'] != null) {
//                             $("#captcha_error").html(response.error['captcha'][0])
//                         } else {
//                             $("#captcha_error").html('');
//                         }
//                     }
//                 }
//             },
//             error: function (xhr, status, error) {
//                 reloadCaptcha();
//                 let response = xhr.responseJSON;
//                 if (response && response.errors) {
//                     if (response.errors.username) {
//                         $("#username_error").html(response.errors.username[0]);
//                     } else {
//                         $("#username_error").html('');
//                     }
//                     if (response.errors.password) {
//                         $("#password_error").html(response.errors.password[0]);
//                     } else {
//                         $("#password_error").html('');
//                     }
//                     if (response.errors.captcha) {
//                         $("#captcha_error").html(response.errors.captcha[0]);
//                     } else {
//                         $("#captcha_error").html('');
//                     }
//                 }
//             }
//         });
//     });
// });

$(document).ready(function () {
    $('#office-login-form').submit(function (event) {
        event.preventDefault();

        // Clear previous messages
        $("#general_error").html('').hide();

        $.ajax({
            type: 'POST',
            url: $(this).attr('action'),
            data: $(this).serialize(),
            success: function (response) {
                if (response.status === true) {

                    // Successful login - show OTP form
                    $('#officialLogin_form').fadeOut(800);
                    setTimeout(() => {
                        $("#otp_form_official").fadeIn(800);
                    }, 600);

                    $("#username").html(response.username);
                    $("#mobile").html(response.phone);
                    startTimerOffice();

                } else {
                    reloadCaptcha();

                    if (response.results === 0) {
                        // Invalid credentials — show professional message
                        $("#general_error")
                            .html('<div class="alert alert-danger mb-2" role="alert">Invalid username or password. Please verify your credentials and try again.</div>')
                            .fadeIn();
                    }

                    // Validation errors
                    $("#username_error").html(response.error?.username ? response.error.username[0] : '');
                    $("#password_error").html(response.error?.password ? response.error.password[0] : '');
                    $("#captcha_error").html(response.error?.captcha ? response.error.captcha[0] : '');
                }
            },
            error: function (xhr) {
                reloadCaptcha();
                const response = xhr.responseJSON;

                $("#general_error")
                    .html('<div class="alert alert-warning mb-2" role="alert">An unexpected error occurred. Please try again later.</div>')
                    .fadeIn();

                if (response && response.errors) {
                    $("#username_error").html(response.errors.username ? response.errors.username[0] : '');
                    $("#password_error").html(response.errors.password ? response.errors.password[0] : '');
                    $("#captcha_error").html(response.errors.captcha ? response.errors.captcha[0] : '');
                }
            }
        });
    });
});




function startTimerOffice() {
    var timeleft = 240;
    var downloadTimer = setInterval(function () {
        timeleft--;
        document.getElementById("timer_office_1").textContent = timeleft;
        if (timeleft == 0) {
            $("#resend_timer_office").hide();
            $("#resend_otp_office").show();
            $otpButton = document.getElementById("resend_otp_office");
            $otpButton.removeAttribute('disabled');
        } else if (timeleft < 0)
            clearInterval(downloadTimer);
    }, 1000);

}

// Office otp start

const inputs_office = document.querySelectorAll(".input-field-otp-office input"),
    button_office = document.getElementById("verify_otp_office");

// iterate over all inputs
inputs_office.forEach((input, index1) => {
    input.addEventListener("keyup", (e) => {
        const currentInput = input,
            nextInput = input.nextElementSibling,
            prevInput = input.previousElementSibling;

        if (currentInput.value.length > 1) {
            currentInput.value = "";
            return;
        }

        if (nextInput && nextInput.hasAttribute("disabled") && currentInput.value !== "") {
            nextInput.removeAttribute("disabled");
            nextInput.focus();
        }

        if (e.key === "Backspace") {
            inputs_office.forEach((input, index2) => {
                if (index1 <= index2 && prevInput) {
                    input.setAttribute("disabled", true);
                    input.value = "";
                    prevInput.focus();
                }
            });
        }

        if (!inputs_office[5].disabled && inputs_office[5].value !== "") {
            button_office.classList.add("active");
            return;
        }
        button_office.classList.remove("active");
    });
});

//focus the first input which index is 0 on window load
window.addEventListener("load", () => inputs_office[0].focus());





$("#resend_otp_office").on('click', function () {

    const username = $("#username").html();
    sendOfficeorAdminOtp(username);
    startTimerOffice();
    $("#resent_msg_office").addClass('text-success');
    $("#resent_msg_office").html("OTP Resent Successfully");
    setTimeout(() => {
        $("#resent_msg_office").fadeOut(2000);
    }, 5000);
    $("#resend_timer_office").show();
    $("#resend_otp_office").hide();
    $otpButton = document.getElementById("resend_otp_office");
    $otpButton.setAttribute('disabled', true);
})




const otpInputsOffice = document.querySelectorAll('.input-field-otp-office input');

// Function to collect enabled OTP input values into a string
function collectOfficeOTPValues() {
    let otpValue = '';
    otpInputsOffice.forEach(input => {
        if (!input.disabled) {
            otpValue += input.value;
        }
    });
    return otpValue;
}

$("#verify_otp_office").on('click', function () {
    const otpCode = collectOfficeOTPValues();

    verify_otp = document.getElementById('verify_otp_office');
    verify_otp.setAttribute('disabled', true);
    console.log(host)
    $.ajax({
        "url": host + 'auth/verify-otp',
        "method": 'POST',
        "data": {
            "_token": $('meta[name="csrf-token"]').attr('content'),
            "username": $("#username").html(),
            "otp": otpCode,
            "role": "office"
        },
        "cache": false,
        "dataType": 'JSON',
        "processing": true,
        "serverside": true,
        success: function (res) {

            if (res.status == false) {

                verify_otp.removeAttribute('disabled');
                Swal.fire({
                    title: 'Verification Failed',
                    text: res.msg,
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
            } else {
                Swal.fire({
                    title: 'Login Successfull!',
                    text: 'OTP Verified',
                    icon: 'success',
                    showConfirmButton: false
                });
                setTimeout(() => {
                    // Replace 'your_redirect_url' with the URL where you want to redirect
                    window.location.href = res.redirect;
                }, 2000);
            }

        },
        error: function (res) {
            console.log(res)
        }

    })
})
// =============================END OFFICE AUTH=============================

// ===============================WORKER AUTH===============================

const inputs = document.querySelectorAll(".input-field-otp input"),
    button = document.getElementById("verify_otp");
// iterate over all inputs
inputs.forEach((input, index1) => {
    input.addEventListener("keyup", (e) => {
        const currentInput = input,
            nextInput = input.nextElementSibling,
            prevInput = input.previousElementSibling;

        if (currentInput.value.length > 1) {
            currentInput.value = "";
            return;
        }

        if (nextInput && nextInput.hasAttribute("disabled") && currentInput.value !== "") {
            nextInput.removeAttribute("disabled");
            nextInput.focus();
        }

        if (e.key === "Backspace") {
            inputs.forEach((input, index2) => {
                if (index1 <= index2 && prevInput) {
                    input.setAttribute("disabled", true);
                    input.value = "";
                    prevInput.focus();
                }
            });
        }

        if (!inputs[5].disabled && inputs[5].value !== "") {
            button.classList.add("active");
            return;
        }
        button.classList.remove("active");
    });
});

//focus the first input which index is 0 on window load
window.addEventListener("load", () => inputs[0].focus());


// Worker Renewal OTP
$(document).ready(function () {

    $('#worker-renewal-form').submit(function (event) {
        event.preventDefault();
        $.ajax({
            type: 'POST',
            url: $(this).attr('action'),
            data: {
                "_token": $('meta[name="csrf-token"]').attr('content'),
                id_card: $('#worker_id_renew').val(),
            },
            success: function (res) {
                if (res.status === false) {

                    $("#otp_sent_message_renwal").addClass('text-danger');
                    $("#otp_sent_message_renwal").html(res.error.id_card[0]);
                    setTimeout(() => {
                        $("#otp_sent_message_renwal").fadeOut(2000);
                    }, 10000);
                } else {
                    // window.location.href = res.url;
                    id_card.setAttribute('disabled', true);
                    $("#otp_sent_message_renwal").addClass('text-success');
                    $("#otp_sent_message_renwal").html(res.message);
                    $("#resend_timer_renewal").show();
                    $("#resend_otp_renewal").hide();
                    $otpButton = document.getElementById("resend_otp_renewal");
                    $otpButton.setAttribute('disabled', true);
                    startTimerRenewal();
                    $("#get_otp_renewal").hide();
                    $("#otp_form_renewal").show();

                    setTimeout(() => {
                        $("#otp_sent_message_renwal").fadeOut(2000);
                    }, 10000);
                    // alert(res.otp)
                }

            },
            error: function (xhr) {
                $('#workerregistermsg').html('');
                $.each(xhr.responseJSON.errors, function (key, value) {
                    $('#workerregistermsg').append('<div class="alert alert-danger">' + value + '</div>');
                });
            },
        });
    });
});

const inputs_renewal = document.querySelectorAll(".input-field-otp-renewal input"),
    button1 = document.getElementById("verify_otp_renewal_index");
// iterate over all inputs
inputs_renewal.forEach((input, index1) => {
    input.addEventListener("keyup", (e) => {
        const currentInput = input,
            nextInput = input.nextElementSibling,
            prevInput = input.previousElementSibling;

        if (currentInput.value.length > 1) {
            currentInput.value = "";
            return;
        }

        if (nextInput && nextInput.hasAttribute("disabled") && currentInput.value !== "") {
            nextInput.removeAttribute("disabled");
            nextInput.focus();
        }

        if (e.key === "Backspace") {
            inputs_renewal.forEach((input, index2) => {
                if (index1 <= index2 && prevInput) {
                    input.setAttribute("disabled", true);
                    input.value = "";
                    prevInput.focus();
                }
            });
        }

        if (!inputs_renewal[5].disabled && inputs_renewal[5].value !== "") {
            button1.classList.add("active");
            return;
        }
        button1.classList.remove("active");
    });
});

//focus the first input which index is 0 on window load
window.addEventListener("load", () => inputs_renewal[0].focus());

$(document).ready(function () {

    $('#worker-login-form').submit(function (event) {
        event.preventDefault();
        $.ajax({
            type: 'POST',
            url: $(this).attr('action'),
            data: {
                "_token": $('meta[name="csrf-token"]').attr('content'),
                id_card: $('#id_card').val(),
            },
            success: function (res) {
                if (res.status === false) {

                    $("#otp_sent_message").addClass('text-danger');
                    $("#otp_sent_message").html(res.error.id_card[0]);
                    setTimeout(() => {
                        $("#otp_sent_message").fadeOut(2000);
                    }, 10000);
                } else {
                    // window.location.href = res.url;
                    id_card.setAttribute('disabled', true);
                    $("#otp_sent_message").addClass('text-success');
                    $("#otp_sent_message").html(res.message);
                    $("#resend_timer").show();
                    $("#resend_otp").hide();
                    $otpButton = document.getElementById("resend_otp");
                    $otpButton.setAttribute('disabled', true);
                    startTimer();
                    $("#get_otp").hide();
                    $("#otp_form").show();

                    setTimeout(() => {
                        $("#otp_sent_message").fadeOut(2000);
                    }, 10000);
                    // alert(res.otp)
                }

            },
            error: function (xhr) {
                $('#workerregistermsg').html('');
                $.each(xhr.responseJSON.errors, function (key, value) {
                    $('#workerregistermsg').append('<div class="alert alert-danger">' + value + '</div>');
                });
            },
        });
    });
});




function verifyOtpSubscription() {
    console.log('kj')
    const otpCode = collectOTPValuesSubscription();
    var idCard = $("#id_card_no_to_display").val();
    verify_otp = document.getElementById('verify_otp_subscription');
    verify_otp.setAttribute('disabled', true);
    $.ajax({
        "url": host + 'auth/verify-worker-otp',
        "method": 'POST',
        "data": {
            "_token": $('meta[name="csrf-token"]').attr('content'),
            "id_card": idCard,
            "otp": otpCode
        },
        "cache": false,
        "dataType": 'JSON',
        "processing": true,
        "serverside": true,
        success: function (res) {

            if (res.status == false) {

                verify_otp.removeAttribute('disabled');
                Swal.fire({
                    title: 'Verification Failed',
                    text: res.message,
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
            } else {
                Swal.fire({
                    title: 'Login Successfull!',
                    text: 'OTP Verified',
                    icon: 'success',
                    showConfirmButton: false
                });
                setTimeout(() => {
                    // Replace 'your_redirect_url' with the URL where you want to redirect
                    window.location.href = res.redirect;
                }, 2000);
            }

        },
        error: function (xhr) {
            $('#workerregistermsg').html('');
            $.each(xhr.responseJSON.errors, function (key, value) {
                $('#workerregistermsg').append('<div class="alert alert-danger">' + value + '</div>');
            });
        },


    });


}




//
function startTimerSubscription() {
    var timeleft = 120;
    var downloadTimer = setInterval(function () {
        timeleft--;
        document.getElementById("timer_subscription").textContent = timeleft;
        if (timeleft == 0) {
            $("#resend_timer_subscription").hide();
            $("#resend_otp_subscription").show();
            $otpButton = document.getElementById("resend_otp_subscription");
            $otpButton.removeAttribute('disabled');
        } else if (timeleft < 0)
            clearInterval(downloadTimer);
    }, 1000);

}


// $("#resend_otp").on('click', function () {
//     const username = $("#id_card_no_to_display").val();
//     sendOfficeorAdminOtp(username);
// })

// $("#resend_otp_renewal").on('click', function () {
//     const username = $("#id_card_no_to_display").val();
//     sendOfficeorAdminOtp(username);
// })

const otpInputsSubscription = document.querySelectorAll('.input-field-otp input');
// Function to collect enabled OTP input values into a string
function collectOTPValuesSubscription() {
    let otpValue = '';
    otpInputsSubscription.forEach(input => {
        if (!input.disabled) {
            otpValue += input.value;
        }
    });
    return otpValue;
}
//
function startTimerRenewal() {
    var timeleft = 120;
    var downloadTimer = setInterval(function () {
        timeleft--;
        document.getElementById("timer_renewal").textContent = timeleft;
        if (timeleft == 0) {
            $("#resend_timer_renewal").hide();
            $("#resend_otp_renewal").show();
            $otpButton = document.getElementById("resend_otp_renewal");
            $otpButton.removeAttribute('disabled');
        } else if (timeleft < 0)
            clearInterval(downloadTimer);
    }, 1000);

}



function startTimer() {
    var timeleft = 120;
    var downloadTimer = setInterval(function () {
        timeleft--;
        document.getElementById("timer_1").textContent = timeleft;
        if (timeleft == 0) {
            $("#resend_timer").hide();
            $("#resend_otp").show();
            $otpButton = document.getElementById("resend_otp");
            $otpButton.removeAttribute('disabled');
        } else if (timeleft < 0)
            clearInterval(downloadTimer);
    }, 1000);

}


$("#resend_otp").on('click', function () {
    const username = $("#id_card").val();
    sendOfficeorAdminOtp(username);
})


const otpInputsRenewal = document.querySelectorAll('.input-field-otp-renewal input');
// Function to collect enabled OTP input values into a string
function collectOTPValuesRenewal() {
    let otpValue = '';
    otpInputsRenewal.forEach(input => {
        if (!input.disabled) {
            otpValue += input.value;
        }
    });
    return otpValue;
}

const otpInputs = document.querySelectorAll('.input-field-otp input');
// Function to collect enabled OTP input values into a string
function collectOTPValues() {
    let otpValue = '';
    otpInputs.forEach(input => {
        if (!input.disabled) {
            otpValue += input.value;
        }
    });
    return otpValue;
}

$("#verify_otp_renewal_index").on('click', function () {
    const otpCode = collectOTPValuesRenewal();
    verify_otp = document.getElementById('verify_otp_renewal_index');
    verify_otp.setAttribute('disabled', true);
    id_card = document.getElementById('worker_id_renew');
    $.ajax({
        "url": host + 'auth/verify-worker-otp',
        "method": 'POST',
        "data": {
            "_token": $('meta[name="csrf-token"]').attr('content'),
            "id_card": id_card.value,
            "otp": otpCode
        },
        "cache": false,
        "dataType": 'JSON',
        "processing": true,
        "serverside": true,
        success: function (res) {

            if (res.status == false) {

                verify_otp.removeAttribute('disabled');
                Swal.fire({
                    title: 'Verification Failed',
                    text: res.message,
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
            } else {
                Swal.fire({
                    title: 'Login Successfull!',
                    text: 'OTP Verified',
                    icon: 'success',
                    showConfirmButton: false
                });
                setTimeout(() => {
                    // Replace 'your_redirect_url' with the URL where you want to redirect
                    window.location.href = host + 'renewal/view-worker-data';
                }, 2000);
            }

        },
        error: function (xhr) {
            $('#workerregistermsg').html('');
            $.each(xhr.responseJSON.errors, function (key, value) {
                $('#workerregistermsg').append('<div class="alert alert-danger">' + value + '</div>');
            });
        },


    });


});



$("#verify_otp").on('click', function () {
    const otpCode = collectOTPValues();
    verify_otp = document.getElementById('verify_otp');
    verify_otp.setAttribute('disabled', true);
    $.ajax({
        "url": host + 'auth/verify-worker-otp',
        "method": 'POST',
        "data": {
            "_token": $('meta[name="csrf-token"]').attr('content'),
            "id_card": id_card.value,
            "otp": otpCode
        },
        "cache": false,
        "dataType": 'JSON',
        "processing": true,
        "serverside": true,
        success: function (res) {

            if (res.status == false) {

                verify_otp.removeAttribute('disabled');
                Swal.fire({
                    title: 'Verification Failed',
                    text: res.message,
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
            } else {
                Swal.fire({
                    title: 'Login Successfull!',
                    text: 'OTP Verified',
                    icon: 'success',
                    showConfirmButton: false
                });
                setTimeout(() => {
                    // Replace 'your_redirect_url' with the URL where you want to redirect
                    window.location.href = res.redirect;
                }, 2000);
            }

        },
        error: function (xhr) {
            $('#workerregistermsg').html('');
            $.each(xhr.responseJSON.errors, function (key, value) {
                $('#workerregistermsg').append('<div class="alert alert-danger">' + value + '</div>');
            });
        },


    });


});
// ===============================END WORKER AUTH===============================

// ==============================CAPTCHA==============================
function reloadCaptcha() {
    $.ajax({
        type: 'GET',
        url: 'reload-captcha',
        success: function (data) {
            $(".captcha span").html(data.captcha);
        }
    });
}

$("#login_modal_open").on('click', function () {
    reloadCaptcha();
})

$('.reload-captcha').click(function () {
    reloadCaptcha();
});
// ==============================END CAPTCHA==============================
// ===============================END AUTH===============================


// ==========================WORKER REGISTRATION==========================

// Get Offices by District Code
$(document).ready(function () {

    $('#district_code').on('change', function () {
        // ajaxStart();
        var office_id = $(this).val();
        // console.log(cState);return
        var district_code = $(this).val();

        if (district_code) {
            $.ajax({
                url: host + 'worker/get-office',
                type: 'GET',
                data: {
                    district_code: district_code,
                    _token: '{{csrf_token()}}'
                },
                dataType: 'json',
                success: function (data) {
                    var dis = '#office_id';
                    console.log(data);
                    $(dis).html('<option value="">--Select Office--</option>');
                    $.each(data.office, function (key, value) {
                        $(dis).append('<option value="' + value.office_id + '">' + value.office_name + '</option>');
                    });

                }
            });
        } else {
            $('#office_id').empty();
            // $('#subdistrict').empty();
        }
    });
});

// Verify Registration
// $(document).ready(function () {
//
//     $('#register-btn-worker').hide();
//
//     $('.checkPhone').on('click', function () {
//
//         var phone_no = $('#phone_no').val();
//         if (!phone_no) {
//             alert('Please enter a phone number.');
//             return; // Stop further execution if phone number is not entered
//         }
//         if (phone_no.length !== 10 || !/^\d{10}$/.test(phone_no)) {
//             alert('Please enter a valid 10-digit phone number.');
//             return; // Stop further execution if phone number is not valid
//         }
//
//         if (phone_no.length === 10) {
//             // Make an AJAX call to check if the phone number exists
//             $.ajax({
//                 headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
//                 url: host + 'existing-worker/check-worker-phone',
//                 method: 'POST',
//                 data: {
//                     _token: $('meta[name="csrf-token"]').attr('content'),
//                     phone_no: phone_no,
//                 },
//                 dataType: 'JSON',
//                 success: function (response) {
//                     if (response.exists === true) {
//                         Toastify({
//                             text: response.msg,
//                             duration: 3000, // Duration in milliseconds
//                             close: true, // Show close button
//                             gravity: "top", // Position of the toast (top or bottom)
//                             position: "right", // Position on the screen (left, right, center)
//                             style: {
//                                 background: "green" // Error color (e.g., red)
//                             },
//                         }).showToast();
//
//                         $('#aadhaarSection').hide();
//                         $('#register-btn-text').text('Login Now');
//                         $('#register-btn-worker').show();
//                     } else {
//                         Toastify({
//                             text: response.msg,
//                             duration: 3000, // Duration in milliseconds
//                             close: true, // Show close button
//                             gravity: "top", // Position of the toast (top or bottom)
//                             position: "right", // Position on the screen (left, right, center)
//                             style: {
//                                 background: "green" // Error color (e.g., red)
//                             },
//                         }).showToast();
//
//                         $('#aadhaarSection').show();
//                         $('#register-btn-text').text('Register Now');
//                         $('#register-btn-worker').hide();
//                     }
//                 },
//
//                 error: function (xhr) {
//                     var errors = xhr.responseJSON.errors;
//                     if (errors && errors.phone_no) {
//                         $('#phone_noError').text(errors.phone_no[0]);
//                     }
//                 }
//             });
//         } else {
//             $('#aadhaarSection').hide();
//             $('#register-btn-worker').hide();
//         }
//     });
//     $('.worker-status').on('input', function () {
//         $('#aadhaarSection').hide();
//         $('#register-btn-worker').hide();
//     });
// });

$('#register-btn-worker').on('click', function () {
    var district_code = $("#district_code").val();
    var phone_no = $('#phone_no').val();
    var office_id = $('#office_id').val();
    var uid = $('#uid').val();
    // sessionStorage.setItem('adhaarno', adhaarno);
    $.ajax({
        "url": host + 'worker/worker-registration',
        "method": 'POST',
        "data": {
            "_token": $('meta[name="csrf-token"]').attr('content'),
            "district": district_code,
            "phone_no": phone_no,
            "uid": uid,
            "office_id": office_id,
        },
        "cache": false,
        "dataType": 'JSON',
        "processing": true,
        "serverside": true,
        success: function (res) {
            console.log(res);
            $('#workerregistermsg').html(''); // Clear previous messages
            if (res.redirect) {
                window.location.href = res.redirect; // Redirect if needed
            } else {
                // $('#workerregistermsg').append('<div class="alert alert-danger">' + res.msg + '</div>');
                if (res.msg) {
                    toastr.error(res.msg);
                }
            }
        },
        error: function (xhr) {
            $('#workerregistermsg').html('');
            $.each(xhr.responseJSON.errors, function (key, value) {
                $('#workerregistermsg').append('<div class="alert alert-danger">' + value + '</div>'); // Show error messages

            });
        }



    });
});






// $('#submit-form').on('click', function (e) {
//     e.preventDefault();
//     if ($('#id_card').val().trim() === '') {
//         toastr.error('Please enter ID Card');
//         return; // Do not proceed with the AJAX request
//     }
//     $('#loading-spinner').removeClass('d-none');
//     $.ajax({
//         url: "{{ route('existing-worker') }}",
//         type: 'POST',
//         data: {
//             '_token': $('meta[name="csrf-token"]').attr('content'),
//             'worker_id': $("#id_card").val(),
//         },
//         dataType: 'json',
//         success: function (response) {
//             $('#loading-spinner').addClass('d-none');
//             console.log(response);
//             // window.location.href = response.redirect;
//         },
//         error: function (error) {
//             console.log('AJAX Error:', error);
//
//             if (error.status === 200) {
//                 console.log('Successful response (status code 200)');
//                 // You might want to process the response here if needed
//             } else {
//                 // Handle other error cases
//
//                 console.log('Status Code:', error.status);
//                 console.log('Status Text:', error.statusText);
//                 console.log('Server Response:', error.responseJSON || error.responseText);
//             }
//         }
//
//     });
// });

