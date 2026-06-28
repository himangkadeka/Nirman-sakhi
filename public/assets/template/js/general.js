$("#menu-toggle").click(function (e) {
    e.preventDefault();
    $("#wrapper").toggleClass("toggled");
});



$(document).ready(function() {
    $('#abaocTable').DataTable({
        dom: '<"dt-top-container"fB<"dt-button-space">l><r>t<"dt-filter-spacer"><ip>',
        buttons: ['copy', 'csv', 'excel', 'pdf', 'print']
    });
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
// ///////////////////////////////////////////////

function proceedForRenewal(ack_no){
    location.href='/';
    setTimeout(
        alert(ack_no)
        ,3000
    )
}

$(function () {
    $("#sortable-menu").sortable();
    $("#sortable-menu").disableSelection();
    $("#sortable-cards").sortable();
    $("#sortable-cards").disableSelection();
});

$(function () {
    $("#one-item-row").on("click", function () {
        $(".b-customize").addClass("col-lg-12", 300);
        $(".b-customize").removeClass("col-lg-4", 300);
        $(".b-customize").removeClass("col-lg-6", 300);
    });
    $("#two-item-row").on("click", function () {
        $(".b-customize").addClass("col-lg-6", 300);
        $(".b-customize").removeClass("col-lg-4", 300);
        $(".b-customize").removeClass("col-lg-12", 300);

    });
    $("#three-item-row").on("click", function () {
        $(".b-customize").addClass("col-lg-4", 300);
        $(".b-customize").removeClass("col-lg-6", 300);
        $(".b-customize").removeClass("col-lg-12", 300);

    });
});



/* AJAX Functions. Author:: Bimol Sarkar Dated:11-10-2023*/
$(document).ready(function () {
    $('#office-table').DataTable();
    $('#user-table').DataTable();
    $('#scheme-table').DataTable();
    //$('.dataTables_length').addClass('bs-select');
});

$(function () {

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $("#state").on("change", function () {
        var statecode = $("#state").val();
        $.ajax
            ({

                url: '/admin/getdistrict',
                method: 'POST',
                data: 'statecode=' + statecode,
                cache: false,
                dataType: 'JSON',
                success: function (response) {
                    $('#district').html(response.districtinfo);
                }

            });

    });
































    function reloadCaptcha() {
        $.ajax({
            type: 'GET',
            url: 'reload-captcha',
            success: function (data) {
                $(".captcha span").html(data.captcha);
            }
        });
    }

    $('#reload').click(function () {
        reloadCaptcha();
    });
    $('#offreload').click(function () {
        reloadCaptcha();
    });

























        $("#confpwd").focusout(function () {
            $('#conf-msg').html('');
            var pwd = $("#pwd").val();
            var conpwd = $("#confpwd").val();
            var msg = 'Password Doesnot Match';
            if (pwd != conpwd) {
                $('#conf-msg').append(msg);
            }

        });














        // Office Otp End

        // $("#officiallogin-btt").on("click", function () {
        //     var username = $("#offusername").val();
        //     var password = $('#off-login-pwd-1').val();
        //     $.ajax({
        //         "url": '/admin/checkofficelogin',
        //         "method": 'POST',
        //         "data": {
        //             "username": username,
        //             "password": password,
        //             "_token": $("input[name=_token]").val(),
        //             "captcha": $("input[name=offcaptcha]").val(),
        //         },
        //         "cache": false,
        //         "dataType": 'JSON',
        //         "processing": true,
        //         "serverside": true,
        //         success: function (res) {
        //             if (res.msg = 'sucess') {
        //                 // window.location.href = location.origin + '/office/officeloginsuccess';
        //                 //alert('Login Sucess');
        //             }
        //         },
        //         error: function (xhr) {
        //             $('#officialuserloginmsg').html('');
        //             $.each(xhr.responseJSON.errors, function (key, value) {
        //                 $('#officialuserloginmsg').append('<div class="alert alert-danger">' + value + '</div>');
        //             });
        //         }

        //     });
        // });



        $("#pwdchngbutt").on("click", function () {
            var oldusrpwd = $("#oldusrpwd").val();
            var newusrpwd = $('#newusrpwd').val();
            var confusrpwd = $('#confusrpwd').val();
            $.ajax({
                "url": '/office/changepassword',
                "method": 'POST',
                "data": {
                    "oldusrpwd": oldusrpwd,
                    "newusrpwd": newusrpwd,
                    "confusrpwd": confusrpwd,
                    "_token": $("input[name=_token]").val()
                },
                "cache": false,
                "dataType": 'JSON',
                "processing": true,
                "serverside": true,
                success: function (res) {
                    $('#changepwd-modal').modal('hide');
                    $('#signoutchngpwd-modal').modal('show');


                },
                error: function (xhr) {
                    $('#chnagepwdmsg').html('');
                    $.each(xhr.responseJSON.errors, function (key, value) {
                        $('#chnagepwdmsg').append('<div class="alert alert-danger">' + value + '</div>');
                    });
                }

            });
        })












    });

    /** Author : Himangka deka **/
    $("#login-btn-worker").on("click", function () {
        var phone_no = $("#login_phone_no").val();
        var otp = $('#otp').val();
        $.ajax({
            "url": '/worker/user-login',
            "method": 'POST',
            "data": {
                "phone_no": phone_no,
                "otp": otp,
                "_token": $('meta[name="csrf-token"]').attr('content')
            },
            "cache": false,
            "dataType": 'JSON',
            "processing": true,
            "serverside": true,

            success: function (res) {
                //$('#adminuserloginmsg').html('');
                //$('#adminuserloginmsg').append('<div class="alert alert-success">'+res.msg+'</div>');
                // console.log(res);
                if (res.status === 'true') {
                    // Redirect to the specified URL
                    window.location.href = res.redirect;
                }
                else if (res.status === 'false') {
                    $('#workeruserloginmsg').html(res.message);
                }
            },
            error: function (xhr) {
                $('#workeruserloginmsg').html('');
                $.each(xhr.responseJSON.errors, function (key, value) {
                    $('#workeruserloginmsg').append('<div class="alert alert-danger">' + value + '</div>');
                });
            }

        });
    });

    // $(document).ready(function () {
    //
    //     $('.state').on('change', function () {
    //         ajaxStart();
    //         var cState = $(this).data('id');
    //         // console.log(cState);return
    //
    //         var state_code = $(this).val();
    //
    //         if (state_code) {
    //             $.ajax({
    //                 url: 'get-districts',
    //                 type: 'GET',
    //                 data: {
    //                     state_code: state_code,
    //                     _token: '{{csrf_token()}}'
    //                 },
    //                 dataType: 'json',
    //                 success: function (data) {
    //                     ajaxStop();
    //                     if (cState == 'c') {
    //                         var dis = '#currentDist';
    //                     } else if (cState == 'p') {
    //                         var dis = '#permanentDist';
    //                     }
    //                     console.log(data)
    //                     $(dis).html('<option value="">--Select District--</option>');
    //                     $.each(data.districts, function (key, value) {
    //                         $(dis).append('<option value="' + value.district_code + '">' + value.district_name + '</option>');
    //                     });
    //
    //                 }
    //             });
    //         } else {
    //             $('#currentDist').empty();
    //             // $('#subdistrict').empty();
    //         }
    //     });
    // });
    // //subdistrict & postoffc
    //
    // $(document).ready(function () {
    //     $('.dist').on('change', function () {
    //         ajaxStart();
    //         var cDist = $(this).data('id');
    //         var district_code = $(this).val();
    //         if (cDist == 'c') {
    //             var state_code = $('#currentState').val();
    //         }
    //         else if (cDist == 'p') {
    //             var state_code = $('#permanentState').val();
    //         }
    //         if (district_code) {
    //             $.ajax({
    //                 url: 'get-subdistricts-postoffc',
    //                 type: 'GET',
    //                 data: {
    //                     state_code: state_code,
    //                     district_code: district_code,
    //                     _token: '{{csrf_token()}}'
    //                 },
    //                 dataType: 'json',
    //                 success: function (data) {
    //                     ajaxStop();
    //                     if (cDist == 'c') {
    //                         var pos = '#currentPost';
    //                         var dis = '#currentCircle';
    //                     } else if (cDist == 'p') {
    //                         var dis = '#permanentCircle';
    //                         var pos = '#permanentPost';
    //                     }
    //                     console.log(data)
    //                     $(dis).html('<option value="">--Select Sub-district--</option>');
    //                     $.each(data.subdist, function (key, value) {
    //                         $(dis).append('<option value="' + value.subdistrict_code + '">' + value.subdistrict_name + '</option>');
    //                     });
    //
    //                     $(pos).html('<option value="">--Select Post-office--</option>');
    //                     $.each(data.postoffice, function (key, value) {
    //                         console.log(value.post_office_name)
    //                         $(pos).append(`<option value="` + value.post_office_id + `">` + value.post_office_name + `</option>`);
    //                     });
    //                 }
    //             });
    //         } else {
    //
    //             $('#currentCircle').empty();
    //         }
    //     });
    // });
    // //postoffice
    // $(document).ready(function () {
    //     $('.post').on('change', function () {
    //         ajaxStart();
    //         var cPost = $(this).data('id');
    //         var post_code = $(this).val();
    //         if (cPost == 'c') {
    //             var state_code = $('#currentState').val();
    //             var district_code = $('#currentDist').val();
    //
    //         }
    //         else if (cPost == 'p') {
    //             var state_code = $('#permanentState').val();
    //             var district_code = $('#permanentDist').val();
    //
    //         }
    //         if (post_code) {
    //             $.ajax({
    //                 url: 'get-pincode',
    //                 type: 'get',
    //                 data: {
    //                     state_code: state_code,
    //                     district_code: district_code,
    //                     poid: post_code,
    //                     _token: '{{csrf_token()}}'
    //                 },
    //                 dataType: 'json',
    //                 success: function (data) {
    //                     ajaxStop();
    //                     if (cPost == 'c') {
    //                         var pin = '#currentPin';
    //                     } else if (cPost == 'p') {
    //                         var pin = '#permanentPin';
    //                     }
    //                     console.log(data.pincode.pin_code)
    //                     $(pin).val(data.pincode.pin_code);
    //
    //                 }
    //             });
    //         } else {
    //
    //             $('#currentCircle').empty();
    //         }
    //     });
    // });
    /** Get office list **/




    /**Real Time Validation Phone no :Himangka deka**/
    document.getElementById('phone_no').addEventListener('input', function () {
        // Get the input value
        var phone_noInput = this.value;

        // Remove non-digit characters
        var phone_no = phone_noInput.replace(/\D/g, '');

        // Check if the phone_no number is exactly 10 digits
        if (phone_no.length === 10) {
            document.getElementById('phone_noError').textContent = '';
        } else {
            document.getElementById('phone_noError').textContent = 'Phone number must be 10 digits';
        }
    });
    document.getElementById('phone_no').addEventListener('keydown', function (event) {
        if (!/[0-9]/.test(event.key) && event.key !== 'Backspace' && event.key !== 'Delete') {
            event.preventDefault();
        }
    });
    /**Real Time Validation aadhaar No : Himangka Deka **/
    const adhaarnoInput = document.getElementById('adhaarno');
    const adhaarnoError = document.getElementById('adhaarnoError');
    const clearButton = document.getElementById('clearButton');

    // Function to validate the input
    function validateInput() {
        const adhaarno = adhaarnoInput.value;
        // Check if the input exceeds the maximum length
        if (adhaarno.length > parseInt(adhaarnoInput.getAttribute('maxlength'), 12)) {
            // Truncate the input value to the maximum length
            adhaarnoInput.value = adhaarno.substring(0, parseInt(adhaarnoInput.getAttribute('maxlength'), 12));
        }

        if (adhaarno.length === 12) {
            // If valid, clear the error message and remove the invalid-input class
            adhaarnoError.textContent = '';
            adhaarnoInput.classList.remove('invalid-input');
        } else {
            // If invalid, display an error message and add the invalid-input class
            adhaarnoError.textContent = 'Aadhaar No must be 12 digits long';
            adhaarnoInput.classList.add('invalid-input');
        }

        // Toggle the visibility of the clear button based on whether the input has a value
        clearButton.style.display = adhaarno.length > 0 ? 'block' : 'none';
    }
    // Function to clear the input
    function clearInput() {
        adhaarnoInput.value = '';
        clearButton.style.display = 'none';
        validateInput(); // Re-run validation after clearing the input
    }

    // Attach an input event listener to the input field
    adhaarnoInput.addEventListener('input', validateInput);

    // Attach a blur event listener to the input field
    adhaarnoInput.addEventListener('blur', validateInput);
    document.getElementById('adhaarno').addEventListener('keydown', function (event) {
        if (!/[0-9]/.test(event.key) && event.key !== 'Backspace' && event.key !== 'Delete') {
            event.preventDefault();
        }
    });






















$(document).ready(function(){
    $('#roleadd-modal').on('hidden.bs.modal', function () {
        location.reload(); // Reload the page when the modal is dismissed
    });
});



















