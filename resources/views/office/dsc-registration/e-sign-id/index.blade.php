@extends('layouts.admin-app')

@section('title', 'Office | Application | ' . ucfirst('Digital Signature'))
@section('breadcrumb_item_1', 'Applications')
@section('breadcrumb_item_2', 'Digital Signature')

@section('header')
    <script src="{{ asset('dsc/resources/js/jquery.js') }}"></script>
    <script src="{{ asset('dsc/resources/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('dsc/resources/js/dsc-signer.js') }}" type="text/javascript"></script>
    <script src="{{ asset('dsc/resources/js/dscapi-conf.js') }}" type="text/javascript"></script>
    <script src="{{ asset('dsc/resources//js/jquery.blockUI.js') }}" type="text/javascript"></script>
@endsection

@section('content')

    <div class="container">
        <div>
            <div>
                <div>
                    <h6 class="fw-bold">Digital Signature :</h6>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="well-sm">
                                <form id="pdfForm">
                                    <div class="container mt-4">

                                        <div class="ratio ratio-16x9 mb-3 loader-container"
                                            style="height: 500px; background-color: white;">
                                            <div class="loader"></div>
                                            <iframe id="iframe-id" frameborder="0" onload="hideLoader()"
                                                class="rounded shadow-sm border"
                                                src="{{ route('office.dsc.idCard', ['id' => encrypt($id)]) }}#toolbar=0&navpanes=0&scrollbar=0"
                                                style="width: 100%; height: 100%; border: none; background-color: transparent;">
                                            </iframe>
                                        </div>

                                        <div class="d-flex justify-content-center mb-3">
                                            <a href="{{ route('office.dsc.applications') }}"
                                                class="btn btn-danger btn-sm  mr-2"><i class="fa fa-arrow-left"
                                                    aria-hidden="true"></i> Go Back</a>
                                            <button id="signPdf" class="btn btn-info btn-sm"><i class="fa fa-file-signature"
                                                    aria-hidden="true"></i> Sign Worker ID
                                                Card</button>
                                            <input id="submitPdf" type="submit" class="btn btn-primary d-none">
                                        </div>

                                        <div class="d-flex justify-content-start">
                                            <button id="btnDecryptVerify" class="btn btn-danger mr-2 d-none">Decrypt
                                                Verify</button>
                                            <button id="btnDecryptVerifyWithCrt" class="btn btn-danger d-none">Decrypt &amp;
                                                Verify</button>
                                        </div>
                                    </div>

                                    <span class="d-none">
                                        <label for="data">Choose Local File : </label><br> <input type="file"
                                            name="pdfFile" id="pdfFile" accept="application/pdf">
                                        <label for="pdfData">Pdf Data(Base64):</label> <br>
                                        <textarea id="pdfData" placeholder="Choose pdf file above to show pdf data..." cols="60" rows="4"
                                            readonly="readonly"></textarea>
                                        <br> <label for="cert">Certificate for Signing:</label><br>
                                        <textarea placeholder="Paste the Base64 encoded certificate from registration here..." id="cert" cols="60"
                                            rows="4" required="">{{ Auth::user()->dscData->certificate }}</textarea>
                                    </span>

                                    <div class="d-none">
                                        <br> Reason : <input type="text" id="signingReason" name="signingReason"
                                            maxlength="20">
                                        <br>
                                    </div>
                                    <span class="d-none">
                                        Location : <input type="text" id="signingLocation" name="signingLocation"
                                            maxlength="20">
                                        <br>
                                        stampingX : <input type="text" id="stampingX" name="stampingX" maxlength="20"
                                            value="170">
                                        <br>stampingY
                                        : <input type="text" id="stampingY" name="stampingY" maxlength="20"
                                            value="565"><br>
                                    </span>
                                    <div class="d-none">
                                        Select TSA URL :
                                        <select name="tsaurls" id="tsaurls" onchange="myFunction()">
                                            <option value="0">
                                                --------------------------SELECT---------------------------------</option>
                                            <option value="http://sha256timestamp.ws.symantec.com/sha256/timestamp">
                                                http://sha256timestamp.ws.symantec.com/sha256/timestamp</option>
                                            <option value="http://timestamp.comodoca.com/rfc3161">
                                                http://timestamp.comodoca.com/rfc3161
                                            </option>
                                            <option value="http://tsa.startssl.com/rfc3161">http://tsa.startssl.com/rfc3161
                                            </option>
                                            <option value="http://timestamp.digicert.com">http://timestamp.digicert.com
                                            </option>
                                            <option value="http://tsa.safecreative.org">http://tsa.safecreative.org</option>
                                        </select>
                                    </div>
                                    <br>
                                    <div class="d-none">
                                        TSA URL (Optional) : <input type="text" id="tsaURL" name="tsaURL"
                                            value="" maxlength="100" style="width: 400px;"> <br>
                                        <span class="d-none">
                                            Time
                                            Server URL (Optional) : <input type="text" id="timeServerURL"
                                                name="timeServerURL" maxlength="100" style="width: 400px;"><br>
                                        </span>
                                    </div>
                                    <span style="color: red;display:none">If
                                        the time server URL is not provided, the client time will be used
                                        for signing.</span>

                                    <br>

                                </form>

                            </div>
                        </div>
                        <div class="col-md-6" style="display:none">
                            <div class="well-sm">
                                <label for="signedPdfData">Signed Pdf Data(Base64):</label> <br>
                                <textarea placeholder="After signing, the encrypted signature will be shown here..." id="signedPdfData"
                                    cols="60" rows="8" disabled=""></textarea>
                                <br> <label>Encryption Key:</label>
                                <textarea placeholder="The random key used for encrypting the signature will be shown here..." id="lblEncryptedKey"
                                    cols="60" rows="4" disabled=""></textarea>
                                <br> <label>Verification Response:</label>
                                <textarea placeholder="The signature verification result from DSCAPI server will be shown here..."
                                    id="verificationResponse" cols="60" rows="8" disabled=""></textarea>
                            </div>
                        </div>
                    </div>
                    <div id="panel"></div>

                </div>
            </div>
        </div>
    </div>
@endsection


@section('footer')
    <script>
        function hideLoader() {
            document.querySelector('.loader').style.display = 'none';
        }
    </script>

    <script>
        $(document).ready(function() {
            var id = '{{ $id }}';
            $.ajax({
                type: "POST",
                url: "{{ route('office.dsc.pdf-string') }}",
                data: {
                    id: id,
                    "_token": "{{ csrf_token() }}"
                },
                success: function(data, status) {
                    //return the string from the certificate generated
                    $("#pdfData").val(data.string);
                    $("#timeServerURL").val(serverTime);
                }
            });
        })
    </script>

    <script type="text/javascript">
        function myFunction() {
            var x = document.getElementById("tsaurls").value;
            if (x != 0) {
                document.getElementById("tsaURL").value = x;
            } else {
                document.getElementById("tsaURL").value = "";
            }
        }
        // $(document).ready(function() {

        //     $('#btnDecryptVerify').hide();
        //     $('#btnDecryptVerifyWithCrt').hide();

        //     var initConfig = {
        //         "preSignCallback": function() {
        //             // do something
        //             // based on the return sign will be invoked
        //             return true;
        //         },
        //         "postSignCallback": function(alias, sign, key) {
        //             $('#signedPdfData').val(sign);
        //             $('#lblEncryptedKey').val(key);

        //             //									$('#btnDecryptVerify').show();
        //             // $('#btnDecryptVerifyWithCrt').show();

        //             var requestData = {
        //                 action: "DECRYPT",
        //                 en_sig: sign,
        //                 ek: key
        //             };

        //             $.ajax({
        //                 url: dscapibaseurl +
        //                     "/pdfsignature",
        //                 type: "post",
        //                 dataType: "json",
        //                 contentType: 'application/json',
        //                 data: JSON
        //                     .stringify(requestData),
        //                 async: false
        //             }).done(
        //                 function(data) {
        //                     if (data.status_cd == 1) {
        //                         //get data.data -> decode base64 -> get json->check status == SUCCESS
        //                         //get data.data.sig -> add pdf header and append to link
        //                         var jsonData = JSON.parse(atob(data.data));
        //                         if (jsonData.status === "SUCCESS") {

        //                             //get pdf data
        //                             var pdfData = jsonData.sig;
        //                             // **************************************************
        //                             var id = '{{ $id }}';
        //                             var reqData = {
        //                                 "_token": $('meta[name="csrf-token"]').attr('content'),
        //                                 id: id,
        //                                 string: pdfData,
        //                             }
        //                             console.log(pdfData);
        //                             $.ajax({
        //                                 url: "{{ route('office.dsc.signed-id') }}",
        //                                 type: "post",
        //                                 dataType: "json",
        //                                 contentType: 'application/json',
        //                                 data: JSON.stringify(reqData),
        //                                 async: false
        //                             }).done(function(res) {
        //                                     if (res.status === false) {
        //                                         window.location.href =
        //                                             "{{ route('office.dsc.applications') }}";
        //                                         Swal.fire({
        //                                             title: '<span class="text-danger">Error</span>',
        //                                             icon: 'error',
        //                                             text: 'Failed to save signed PDF!',
        //                                             showCloseButton: false,
        //                                             showCancelButton: false,
        //                                             timer: 2000,
        //                                             timerProgressBar: true,
        //                                         }).then(function() {
        //                                             window.location.href =
        //                                                 "{{ route('office.dsc.applications') }}";
        //                                         });
        //                                     } else {
        //                                         window.location.href =
        //                                             "{{ route('office.dsc.applications') }}";
        //                                         Swal.fire({
        //                                             title: '<span class="text-success">Success</span>',
        //                                             icon: 'success',
        //                                             text: 'Signed Successfully!',
        //                                             showCloseButton: false,
        //                                             showCancelButton: false,
        //                                             timer: 2000,
        //                                             timerProgressBar: true,
        //                                         }).then(function() {
        //                                             window.location.href =
        //                                                 "{{ route('office.dsc.applications') }}";
        //                                         });
        //                                     }
        //                                 });
        //                             };
        //                             // *************
        //                             // (async () => {
        //                             //     try {

        //                             //         const saveSignedPdf = await saveData(pdfData);
        //                             //         console.log("Save status:", saveSignedPdf);

        //                             //         if (saveSignedPdf == true) {
        //                             //             Swal.fire({
        //                             //                 title: '<span class="text-success">Success</span>',
        //                             //                 icon: 'success',
        //                             //                 text: 'Signed Successfully!',
        //                             //                 showCloseButton: false,
        //                             //                 showCancelButton: false,
        //                             //                 timer: 2000,
        //                             //                 timerProgressBar: true,
        //                             //             }).then(function() {
        //                             //                 window.location.href =
        //                             //                     "{{ route('office.dsc.applications') }}";
        //                             //             });
        //                             //         } else {
        //                             //             Swal.fire({
        //                             //                 title: '<span class="text-danger">Error</span>',
        //                             //                 icon: 'error',
        //                             //                 text: 'Failed to save signed PDF!',
        //                             //                 showCloseButton: false,
        //                             //                 showCancelButton: false,
        //                             //                 timer: 2000,
        //                             //                 timerProgressBar: true,
        //                             //             }).then(function() {
        //                             //                 window.location.href =
        //                             //                     "{{ route('office.dsc.applications') }}";
        //                             //             });
        //                             //         }

        //                             //     } catch (error) {
        //                             //         console.error("Failed to save signed PDF:", error);
        //                             //     }
        //                             // })();
        //                             // var saveSignedPdf = saveData(pdfData);
        //                             // console.log(saveSignedPdf)

        //                             // $('#verifyPdfBtn').show();

        //                             // //Set Class to download link
        //                             // $('#downloadDiv').addClass('btn btn-sm btn-success mt-3');

        //                             // var dlnk = document.getElementById('downloadDiv');
        //                             // dlnk.href = 'data:application/pdf;base64,' + pdfData;

        //                             // $("#downloadDiv").text("Download Certificate");

        //                             $("#displayDiv").show();


        //                         }

        //                     } else {
        //                         if (data.error.error_cd == 1002) {
        //                             console.log(data.error.message);
        //                             window.location.href =
        //                                 "{{ route('office.dsc.applications') }}";
        //                             // return false;
        //                         } else {
        //                             console.log("Decryption Failed for Signed PDF File");
        //                             window.location.href =
        //                                 "{{ route('office.dsc.applications') }}";
        //                             // return false;
        //                         }

        //                     }
        //                 }).fail(
        //                 function(jqXHR, textStatus,
        //                     errorThrown) {
        //                     console.log(textStatus);
        //                     window.location.href =
        //                         "{{ route('office.dsc.applications') }}";
        //                 }
        //             );

        //         },
        //         signType: 'pdf',
        //         mode: 'nostampingv2',
        //         certificateData: $('#cert').val()
        //         //"certificateSno" : 13705892,
        //     };
        //     dscSigner.configure(initConfig);

        //     $('#cert').bind('input propertychange', function() {
        //         var initConfig = {
        //             "preSignCallback": function() {
        //                 // do something before signing
        //                 alert("Pre-sign event fired");
        //                 return true;
        //             },
        //             "postSignCallback": function(alias, sign, key) {
        //                 //do something after signing
        //                 $('#signedPdfData').val(sign);
        //                 $('#lblEncryptedKey').val(key);

        //                 //											$('#btnDecryptVerify').show();
        //                 $('#btnDecryptVerifyWithCrt').show();

        //             },
        //             signType: 'pdf',
        //             mode: 'nostampingv2',
        //             certificateData: $('#cert').val()
        //             //Set the cerificate serial number to skip certificate selection
        //             //"certificateSno" : 13705892,
        //         };
        //         dscSigner.configure(initConfig);
        //     });

        //     $('#signPdf').click(function() {
        //         var data = $("#pdfData").val();

        //         if (data != null || data != '') {
        //             dscSigner.sign(data);
        //         }
        //     });

        //     $('#btnDecryptVerify').click(function() {

        //         var sign = $('#signedPdfData').val();
        //         var key = $('#lblEncryptedKey').val();

        //         // Implement Decrypt Verify here
        //         var requestData = {
        //             action: "DECRYPT_VERIFY",
        //             en_sig: sign,
        //             ek: key
        //         };

        //         $.ajax({
        //             url: dscapibaseurl + "/pdfsignature",
        //             type: "post",
        //             dataType: "json",
        //             contentType: 'application/json',
        //             data: JSON.stringify(requestData),
        //             async: false
        //         }).done(function(data) {
        //             if (data.status_cd == 1) {
        //                 var jsonData = JSON.parse(atob(data.data));
        //                 $('#decryptedSignature').val(jsonData.sig);
        //                 $('#decodedSignedXML').val(atob(jsonData.sig));
        //                 $('#verifiedSignature').val(atob(data.data));
        //                 $('#verificationResponse').val(atob(data.data));

        //                 //Set Class to download link
        //                 $('#downloadDiv').addClass('btn btn-info');
        //                 //get pdf data
        //                 var pdfData = jsonData.sig;
        //                 var dlnk = document.getElementById('downloadDiv');
        //                 dlnk.href = 'data:application/pdf;base64,' + pdfData;
        //                 $("#downloadDiv").text("Download Signed PDF File");

        //                 $('#btnDecryptVerify').hide();
        //                 $('#btnDecryptVerifyWithCrt').hide();
        //             } else {
        //                 alert("Verification Failed");
        //             }

        //         }).fail(function(jqXHR, textStatus, errorThrown) {
        //             alert(textStatus);
        //         });
        //     });

        //     $('#btnDecryptVerifyWithCrt').click(function() {

        //         $('#verificationResponse').val('');

        //         var sign = $('#signedPdfData').val();
        //         var key = $('#lblEncryptedKey').val();

        //         // Implement Verify here
        //         var requestData = {
        //             action: "DECRYPT_VERIFY_WITH_CERT",
        //             en_sig: sign,
        //             ek: key,
        //             certificate: $('#cert').val()
        //         };
        //         $.ajax({
        //             url: dscapibaseurl + "/pdfsignature",
        //             type: "post",
        //             dataType: "json",
        //             contentType: 'application/json',
        //             data: JSON.stringify(requestData),
        //             async: false
        //         }).done(function(data) {
        //             if (data.status_cd == 1) {
        //                 var jsonData = JSON.parse(atob(data.data));
        //                 $('#decryptedSignature').val(jsonData.sig);
        //                 $('#decodedSignedXML').val(atob(jsonData.sig));
        //                 $('#verifiedSignature').val(atob(data.data));
        //                 $('#verificationResponse').val(atob(data.data));

        //                 //Set Class to download link
        //                 $('#downloadDiv').addClass('btn btn-info');
        //                 //get pdf data
        //                 var pdfData = jsonData.sig;
        //                 var dlnk = document.getElementById('downloadDiv');
        //                 dlnk.href = 'data:application/pdf;base64,' + pdfData;
        //                 $("#downloadDiv").text("Download Signed PDF File");

        //                 //										$('#btnDecryptVerify').hide();
        //                 //										$('#btnDecryptVerifyWithCrt').hide();
        //             } else {
        //                 $('#verificationResponse').val(JSON.stringify(data));
        //                 alert("Verification Failed");
        //             }

        //         }).fail(function(jqXHR, textStatus, errorThrown) {
        //             alert(textStatus);
        //         });
        //     });

        //     function readURL(input) {
        //         if (input.files && input.files[0]) {
        //             var reader = new FileReader();

        //             reader.onload = function(e) {
        //                 var data = e.target.result;
        //                 var base64 = data.replace(/^[^,]*,/, '');
        //                 $("#pdfData").val(base64);
        //             }

        //             reader.readAsDataURL(input.files[0]);
        //         }
        //     }

        //     $("#pdfFile").change(function() {
        //         readURL(this);
        //     });

        // });

        $(document).ready(function() {
            $('#btnDecryptVerify').hide();
            $('#btnDecryptVerifyWithCrt').hide();

            var initConfig = {
                preSignCallback: function() {
                    // Callback before signing
                    return true;
                },
                postSignCallback: function(alias, sign, key) {
                    $('#signedPdfData').val(sign);
                    $('#lblEncryptedKey').val(key);

                    var requestData = {
                        action: "DECRYPT",
                        en_sig: sign,
                        ek: key,
                    };

                    $.ajax({
                            url: dscapibaseurl + "/pdfsignature",
                            type: "POST",
                            dataType: "json",
                            contentType: "application/json",
                            data: JSON.stringify(requestData),
                            async: false,
                        })
                        .done(function(data) {
                            if (data.status_cd === 1) {
                                var jsonData = JSON.parse(atob(data.data));
                                if (jsonData.status === "SUCCESS") {
                                    var pdfData = jsonData.sig;
                                    var id = "{{ $id }}";
                                    var reqData = {
                                        _token: $('meta[name="csrf-token"]').attr('content'),
                                        id: id,
                                        string: pdfData,
                                    };

                                    $.ajax({
                                            url: "{{ route('office.dsc.signed-id') }}",
                                            type: "POST",
                                            dataType: "json",
                                            contentType: "application/json",
                                            data: JSON.stringify(reqData),
                                            async: false,
                                        })
                                        .done(function(res) {
                                            console.log("Starting redirection...");
                                            console.log("Response status:", res.results);
                                            console.log("Redirect URL:",
                                                "{{ route('office.dsc.applications') }}");
                                            redirectToApplications();
                                            if (res.status === false) {
                                                handleFailure();
                                            } else {
                                                handleSuccess();
                                            }
                                        });
                                }
                            } else {
                                redirectToApplications();
                                handleDecryptionError(data);
                            }
                        })
                        .fail(function(jqXHR, textStatus) {
                            console.error(textStatus);
                            redirectToApplications();
                        });
                },
                signType: "pdf",
                mode: "nostampingv2",
                certificateData: $("#cert").val(),
            };

            dscSigner.configure(initConfig);

            $("#cert").on("input propertychange", function() {
                initConfig.certificateData = $(this).val();
                dscSigner.configure(initConfig);
            });

            $("#signPdf").click(function() {
                var data = $("#pdfData").val();
                if (data) {
                    dscSigner.sign(data);
                }
            });

            $("#btnDecryptVerify").click(function() {
                decryptAndVerify();
            });

            $("#btnDecryptVerifyWithCrt").click(function() {
                verifyWithCertificate();
            });

            $("#pdfFile").change(function() {
                readURL(this);
            });

            function readURL(input) {
                if (input.files && input.files[0]) {
                    var reader = new FileReader();
                    reader.onload = function(e) {
                        var data = e.target.result;
                        var base64 = data.replace(/^[^,]*,/, "");
                        $("#pdfData").val(base64);
                    };
                    reader.readAsDataURL(input.files[0]);
                }
            }

            function handleFailure() {
                console.log('hjk')
                Swal.fire({
                    title: '<span class="text-danger">Error</span>',
                    icon: "error",
                    text: "Failed to save signed PDF!",
                    showCloseButton: false,
                    timer: 2000,
                    timerProgressBar: true,
                }).then(function() {
                    redirectToApplications();
                });
            }

            function handleSuccess() {
                console.log('success');
            }

            function redirectToApplications() {
                console.log('dsa')
                window.location.href = "{{ route('office.dsc.applications') }}";
            }

            function handleDecryptionError(data) {
                console.error("Decryption failed:", data.error.message || "Unknown error");
                redirectToApplications();
            }

            function decryptAndVerify() {
                var sign = $("#signedPdfData").val();
                var key = $("#lblEncryptedKey").val();

                var requestData = {
                    action: "DECRYPT_VERIFY",
                    en_sig: sign,
                    ek: key,
                };

                $.ajax({
                        url: dscapibaseurl + "/pdfsignature",
                        type: "POST",
                        dataType: "json",
                        contentType: "application/json",
                        data: JSON.stringify(requestData),
                        async: false,
                    })
                    .done(function(data) {
                        if (data.status_cd === 1) {
                            var jsonData = JSON.parse(atob(data.data));
                            var pdfData = jsonData.sig;
                            setupDownloadLink(pdfData);
                            $("#btnDecryptVerify").hide();
                            $("#btnDecryptVerifyWithCrt").hide();
                        } else {
                            alert("Verification Failed");
                        }
                    })
                    .fail(function(jqXHR, textStatus) {
                        alert(textStatus);
                    });
            }

            function verifyWithCertificate() {
                var sign = $("#signedPdfData").val();
                var key = $("#lblEncryptedKey").val();

                var requestData = {
                    action: "DECRYPT_VERIFY_WITH_CERT",
                    en_sig: sign,
                    ek: key,
                    certificate: $("#cert").val(),
                };

                $.ajax({
                        url: dscapibaseurl + "/pdfsignature",
                        type: "POST",
                        dataType: "json",
                        contentType: "application/json",
                        data: JSON.stringify(requestData),
                        async: false,
                    })
                    .done(function(data) {
                        if (data.status_cd === 1) {
                            var jsonData = JSON.parse(atob(data.data));
                            var pdfData = jsonData.sig;
                            setupDownloadLink(pdfData);
                        } else {
                            alert("Verification Failed");
                        }
                    })
                    .fail(function(jqXHR, textStatus) {
                        alert(textStatus);
                    });
            }

            function setupDownloadLink(pdfData) {
                var dlnk = document.getElementById("downloadDiv");
                dlnk.href = "data:application/pdf;base64," + pdfData;
                dlnk.className = "btn btn-info";
                dlnk.textContent = "Download Signed PDF File";
            }
        });


        // async function saveData(string) {
        //     var id = '{{ $id }}';
        //     try {
        //         const response = await $.ajax({
        //             type: "POST",
        //             url: "{{ route('office.dsc.signed-id') }}",

        //             data: {
        //                 id: id,
        //                 string: string,
        //                 "_token": $('meta[name="csrf-token"]').attr('content'),
        //             }
        //         });
        //         console.log(response);
        //         return response.status;
        //     } catch (error) {
        //         console.error("Error:", error);
        //         throw error; // Re-throw error if needed
        //     }
        // }


        async function saveData(string) {
            var id = '{{ $id }}';
            await $.ajax({
                type: 'POST',
                url: "{{ route('office.dsc.signed-id') }}",
                data: {
                    "_token": $('meta[name="csrf-token"]').attr('content'),
                    id: id,
                    string: string,
                },
                success: function(res) {
                    if (res.status === false) {
                        return false;
                    } else {
                        return true;
                    }
                }
            })
        }
    </script>
@endsection
