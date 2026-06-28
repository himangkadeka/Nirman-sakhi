<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>

<head>
    <title>Register DSC Demo</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="{{ asset('dsc/resources/js/jquery.js') }}"></script>
    <script src="{{ asset('dsc/resources/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('dsc/resources/js/dsc-signer.js') }}" type="text/javascript"></script>
    <script src="{{ asset('dsc/resources/js/dscapi-conf.js') }}" type="text/javascript"></script>
    <script src="{{ asset('dsc/resources//js/jquery.blockUI.js') }}" type="text/javascript"></script>
    <link type="text/css" rel="stylesheet" href="{{ asset('dsc/resources/css/bootstrap.min.css') }}">
    <link type="text/css" rel="stylesheet" href="{{ asset('dsc/resources/css/dsc-signer.css') }}">
    <link rel="stylesheet" href="{{asset('assets/template/css/sweetAlert.css')}}">
    <script src="{{asset('assets/template/js/sweetAlert.js')}}"></script>







</head>

<body>
    <div id="panel"></div>

    <div id="login-overlay" class="modal-dialog">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <i class="fa fa-id-card" aria-hidden="true"></i> <span>Add/Modify
                    Digital Signature</span>
            </div>
            <div class="panel-body">
                <div class="well">
                    <form method="POST" action="{{ route('office.dsc.register') }}" class="form-horizontal dsc-form"
                        role="form">
                        @csrf
                        <h4>Digital Signature</h4>
                        <div class="form-group" style="padding: 14px;">

                            <div class="row">
                                <div class="input-field col-md-12">
                                    <label for="cname">Name</label> <input type="text" id="cname"
                                        name="cname" class="form-control input-sm" autocomplete="off"
                                        readonly="true" />
                                </div>
                            </div>
                            <div class="row">
                                <div class="input-field col-md-12">
                                    <label for="serialNum">Serial Number</label> <input type="text" id="serialNum"
                                        name="serialNum" class="form-control input-sm" autocomplete="off"
                                        readonly="true" />
                                </div>
                            </div>
                            <div class="row">
                                <div class="input-field col-md-12">
                                    <label for="validFrom">Valid from</label> <input type="text" id="validFrom"
                                        name="validFrom" class="form-control input-sm" autocomplete="off"
                                        readonly="true" />
                                </div>
                            </div>
                            <div class="row">
                                <div class="input-field col-md-12">
                                    <label for="validTo">Valid to</label> <input type="text" id="validTo"
                                        name="validTo" class="form-control input-sm" autocomplete="off"
                                        readonly="true" />
                                </div>
                            </div>
                            <div class="row">
                                <div class="input-field col-md-12">
                                    <label for="cert">Certificate</label>
                                    <textarea type="text" id="cert" name="cert" class="form-control input-sm" autocomplete="off" readonly="true"
                                        rows="5"></textarea>
                                </div>
                            </div>
                            <div class="row">
                                <div class="input-field col-md-12">
                                    <label for="sts">Status</label> <input type="text" id="sts"
                                        name="sts" class="form-control input-sm" autocomplete="off"
                                        readonly="true" /> <input type="hidden" id="pan" name="pan"
                                        class="form-control input-sm" autocomplete="off" readonly="true" />
                                </div>
                            </div>
                            <div class="row">
                                <div class="input-field col-md-12">
                                    <button type="submit"  class="btn btn-primary">Save/Update</button>

                                </div>
                            </div>
                        </div>
                    </form>


                </div>
            </div>
        </div>
    </div>
</body>
<script type="text/javascript">
    // function test() {
    //     var cname = $('#cname').val();
    //     var pan = $('#pan').val();
    //     var serialNum = $('#serialNum').val();
    //     var validFrom = $('#validFrom').val();
    //     var validTo = $('#validTo').val();
    //     var cert = $('#cert').val();
    //     var status = $('#sts').val();
    //     if(status == "ACTIVE"){
    //         var sts = true;
    //     }else{
    //         var sts = false;
    //     }
    // }

    $(document).ready(function () {
    $('.dsc-form').submit(function (event) {
        event.preventDefault();
        $.ajax({
            type: 'POST',
            url: $(this).attr('action'),
            data: $(this).serialize(),
            success: function (response) {
                if (response.status == true) {
                    console.log(response)
                    Swal.fire({
                        title: 'Success!',
                        text: 'Your form has been submitted successfully.',
                        icon: 'success',
                        confirmButtonText: 'OK'
                    })
                } else {
                    // window.location.reload();
                    console.log(response)
                    Swal.fire({
                        title: 'Error!',
                        text: response.results || 'An error occurred while submitting the form.',
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                }
            },
            error: function (xhr, status, error) {
                console.error(response.results);
                Swal.fire({
                        title: 'Error!',
                        text: response.results || 'An error occurred while submitting the form.',
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
            }
        });
    });
});
    $(document).ready(function() {

        $('#loadCert').click(function() {
            var serialNo = $('#serialNum').val();
            var cert = $('#cert').val();
            if (serialNo == "" && cert == "") {
                $.blockUI({
                    message: '<h5><img src="resources/images/please-wait-fb.gif" /> Initializing NICDSign.Please Wait...</h5>'
                });
            }
            setTimeout(
                function() {
                    if (serialNo == "" && cert == "") {
                        $(document).ajaxStop($.unblockUI);
                        getDSCDetails();
                    }
                }, 3000);
        });

        function getDSCDetails() {

            dscSigner.certificate(function(res) {
                $('#cname').val(res.certificates[0].subject);
                $('#pan').val(res.certificates[0].pan);
                $('#serialNum').val(res.certificates[0].serialNumber);
                $('#validFrom').val(res.certificates[0].notBefore);
                $('#validTo').val(res.certificates[0].notAfter);
                $('#cert').val(res.certificates[0].certificate);
                $('#sts').val("ACTIVE");
                $('#panel').hide();
            });
        }

        var serialNo = $('#serialNum').val();
        var cert = $('#cert').val();
        if (serialNo == "" && cert == "") {
            $.blockUI({
                message: '<h5><img src="{{ asset('dsc/resources/images/please-wait-fb.gif') }}" /> Initializing NICDSign.Please Wait...</h5>'
            });
        }
        setTimeout(
            function() {
                if (serialNo == "" && cert == "") {
                    $(document).ajaxStop($.unblockUI);
                    getDSCDetails();
                }
            }, 3000);
    });
</script>

</html>
