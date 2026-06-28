


    <style>
        .id-card {
            width: 110.60mm;
            height: 70.98mm;
            border: 2px solid darkblue;
            border-radius: 20px;
            margin: 20px;
        }

        .qr-code {
            width: 100px;
            height: 100px;
            border: 1px solid #000;
        }

        .print-btn {
            display: block;
            width: 100px;
            margin: 20px auto;
            padding: 10px;
            background-color: #4caf50;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-align: center;
        }

        @media print {
            .print-btn {
                display: none;
            }
        }
    </style>





    <div id="print" class="container">
        <div class="row">
            <!-- Front Side -->
            <div class="col-md-6">
                <div class="id-card">
                    <div
                        style="padding-left:8px; padding-right:8px; display: flex; justify-content:center; align-items:center">
                        <div style="margin-right: 20px; margin-top: 12px">
                            <img style="height: 50px; width: 30px" src="../../assets/template/images/emblem-dark.png"
                                alt="National Emblem of India" class="emblem">
                        </div>
                        <div style="text-align: center; margin-right: 20px">
                            <h3
                                style="font-size:8px;padding-left:6px; padding-right:6px; padding-top:4px; padding-bottom:4px; background-color:#000; color:white">
                                ASSAM BUILDING & OTHER CONSTRUCTION
                                WORKERS WELFARE BOARD
                            </h3>
                            <h4 style="font-size:8px;">
                                As per Assam BOCW Rules of RE&CS Act 1996
                            </h4>

                        </div>

                    </div>
                    <div style="font-size:8px; background-color:#000; color:white; text-align:center; margin-top: -9px">
                        <h3>অসম BOCW কাৰ্ড / Assam BOCW Card </h3>
                    </div>
                    <div style="display:flex; font-size: 9px; margin-left: 10px; margin-right: 10px">
                        <div class="card-body" style="width: 100%">
                            <div style="margin-top: -12px">
                                <p class="card-text"><span style="font-weight:bold">নাম / Name:</span>
                                    {{ $wrkr->first_name }} {{ $wrkr->last_name }}</p>
                            </div>
                            <div style="margin-top: -6px; width: 80%">
                                <p class="card-text"><span style="font-weight:bold">পিতৃৰ নাম / পত্নীৰ নাম Father’s
                                        Name/ Spouse’ Name:</span>
                                    {{ $wrkr->gurdain_name }}</p>
                            </div>
                            <div style="display: flex; justify-content:space-between; margin-top: -12px">
                                <div>
                                    <p class="card-text"><span style="font-weight:bold">জন্ম তাৰিখ / DOB:</span>
                                        {{ $wrkr->dob }} </p>
                                </div>
                                <div>
                                    <p class="card-text"><span style="font-weight:bold">লিংগ / Gender:</span>
                                        @foreach ($gender as $g)
                                            @if ($wrkr->gender == $g->gender_code)
                                                {{ $g->gender_name }}
                                            @endif
                                        @endforeach
                                    </p>
                                </div>

                            </div>
                            <div style="display: flex; justify-content:space-between; margin-top: -12px">
                                <div style="width: 50%">
                                    <p class="card-text"><span style="font-weight:bold">পঞ্জীয়নৰ তাৰিখ / Registration
                                            Date:</span> {{ $user->created_at }}
                                    </p>
                                </div>
                                <div>
                                    <p class="card-text"><span style="font-weight:bold">টিল বৈধ / Valid till:</span>
                                        {{ $user->expiry_date }}</p>
                                </div>
                            </div>
                            <div style="display: flex; justify-content:space-between; margin-top: -12px">
                                <div>
                                    <p class="card-text"><span style="font-weight:bold">অৱসৰৰ তাৰিখ / Date of
                                            Retirement:</span> </p>
                                </div>
                                <div>
                                    <p class="card-text"><span style="font-weight:bold">চাকৰিৰ প্ৰকৃতি / Nature of
                                            job:</span> </p>
                                </div>
                            </div>
                            <div style="margin-top: -12px">
                                <p class="card-text"><span style="font-weight:bold">e-Shram UAN No.:</span> </p>
                            </div>
                            <div
                                style="display: flex; flex-direction:column; justify-content:center; align-items:center; margin-top: -8px; margin-left: 50px;">
                                <div>
                                    <p style="font-size:12px">Registration Number: </p>
                                </div>
                                <div style="margin-top: -24px">
                                    <p style="font-size:18px">XXXXXXXXXXXX </p>
                                </div>
                            </div>
                        </div>
                        <div class="card-body" style="width: 30%; margin-left: 30px">
                            <div>
                                <img src={{ $passport }} alt="passport-photo">
                            </div>
                            <div>
                                <p class="card-text" style="font-weight:bold">Signature, Designation (with date and
                                    seal) of Registering
                                    authority </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Back Side -->
            <div class="col-md-6">
                <div class="id-card" style="display:flex; flex-direction:column; justify-content:flex-end">
                    <div
                        style="padding-left:8px; padding-right:8px; display: flex; justify-content:center; align-items:center">
                        <div style="margin-right: 20px; margin-top: 12px">
                            <img style="height: 50px; width: 30px" src="../../assets/template/images/emblem-dark.png"
                                alt="National Emblem of India" class="emblem">
                        </div>
                        <div style="text-align: center; margin-right: 20px">
                            <h3
                                style="font-size:8px;padding-left:6px; padding-right:6px; padding-top:4px; padding-bottom:4px; background-color:#000; color:white">
                                ASSAM BUILDING & OTHER CONSTRUCTION
                                WORKERS WELFARE BOARD
                            </h3>
                            <h4 style="font-size:8px;">
                                As per Assam BOCW Rules of RE&CS Act 1996
                            </h4>

                        </div>

                    </div>
                    <div style="font-size:8px; background-color:#000; color:white; text-align:center; margin-top: -9px">
                        <h3>অসম BOCW কাৰ্ড / Assam BOCW Card </h3>
                    </div>
                    <div style="display:flex; font-size: 9px; margin-left: 10px; margin-right: 10px">
                        <div class="card-body" style="width: 100%">
                            <div>
                                <p class="card-text"><span style="font-weight:bold">স্থায়ী ঠিকনা: / Permanent
                                        Address:</span> </p>
                            </div>
                            <div style="margin-top: 20px">
                                <p class="card-text"><span style="font-weight:bold">Signature / Thumb Impression:</span>
                                </p>
                            </div>
                            <div style="margin-top: 20px">
                                <p class="card-text"><span style="font-weight:bold">Blood group:</span></p>
                            </div>
                            <div>
                                <p class="card-text"><span style="font-weight:bold">Contact no.:</span></p>
                            </div>
                        </div>
                        <div class="card-body">
                            <img src="https://api.qrserver.com/v1/create-qr-code/?data=ID%3A123456%0AName%3AJohn%20Doe%0ADepartment%3AIT%0APosition%3ADeveloper%0AAddress%3A123%20Main%20St%2C%20City%2C%20Country&amp;size=100x100"
                                alt="QR Code" class="qr-code">
                        </div>

                    </div>
                    <div style="display: flex; justify-content:end; align-items:flex-end;">
                        <h2 style=" font-size: 9px;">
                            If the card is lost / someone's lost card is found,
                            Please inform / return to:
                            Assam Building & Other Construction Workers Welfare Board
                            Office of the Labour Commissioner, Assam Shram Bhawan,
                            B.K. Kakati Road, Ulubari, Guwahati-781007
                            Phone- 0361-2547406
                        </h2>
                    </div>
                    <div>
                        <div style="background-color: #000; height: 4px;">
                        </div>
                        <div style=" margin-right: 12px; display:flex; justify-content:flex-end">
                            abocwwb.assam.gov.in | bocwassam@gmail.com
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <button class="print-btn" onclick="printIdCard()">Print ID Card</button>
    </div>

    <script>
        function printIdCard() {
            var printContents = document.getElementById('print').innerHTML;
            var originalContents = document.body.innerHTML;
            document.body.innerHTML = printContents;
            window.print();
            document.body.innerHTML = originalContents;
        }
    </script>



