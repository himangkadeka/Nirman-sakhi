<style>
    .id-card {
        height: 212.94mm;
        width: 331.8mm;
        border: 2px solid darkblue;
        border-radius: 20px;
        margin: 20px;
    }

    .qr-code {
        width: 100px;
        height: 100px;
        border: 1px solid #000;
    }

    .img-pass {
        width: 200px;
        height: 200px;
        background-color: blue;
        object-position: left top;
        border: 2px solid black;
    }

    @font-face {
            font-family: 'Noto Sans Assamese';
            src: url('{{ public_path('assets/template/fonts/Asomiya_Rohini.ttf') }}') format('truetype');
            font-weight: normal;
            font-style: normal;
        }

        body {
            font-family: 'Noto Sans Assamese', sans-serif;
        }

        




</style>



<div id="print" class="container">
    <div class="row">
        <!-- Front Side -->




        <div id="print" class="container">
            <div class="row">
                <!-- Front Side -->
                <div class="col-md-6">
                    <div class="id-card">
                        <div style="padding-left:8px; padding-right:8px;">
                            <div style="float: left; margin-right: 20px;">
                                <img style="height: 150px; width: 90px; margin-top:6px" src={{ $emblem }} alt="National Emblem of India"
                                    class="emblem">
                            </div>
                            <div style="float: left; margin-left: 40px; margin-top: 10px">
                                <h3
                                    style="font-size:24px;padding-left:12px; padding-right:12px; padding-top:4px; padding-bottom:4px; background-color:#000; color:white">
                                    ASSAM BUILDING & OTHER CONSTRUCTION WORKERS WELFARE BOARD
                                </h3>
                                <h4 style="font-size:24px; margin-left: 120px;">
                                    As per Assam BOCW Rules of RE&CS Act 1996
                                </h4>
                            </div>
                            <div style="float: right; margin-right: 20px;">
                                <img style="height: 150px; width: 120px; margin-top:6px" src={{ $logo }} alt="National Emblem of India"
                                    class="emblem">
                            </div>
                            <div style="clear: both;"></div>
                        </div>
                        <div
                            style="font-size:16px; background-color:#000; color:white; text-align:center; margin-top: 9px">
                            <h3>অসম BOCW কাৰ্ড / Assam BOCW Card </h3>
                        </div>
                        <div style="font-size: 24px; margin-left: 10px; margin-right: 10px;">
                            <div style="margin-top: 12px;">
                                <p class=""><span style="font-weight:bold">নাম / Name:</span>
                                    {{ $wrkr->first_name }} {{ $wrkr->last_name }}</p>
                            </div>
                            <div style="margin-top: 20px; position: absolute; right:0; top:280; margin-right: 30px">
                                <img class="img-pass" src={{ $passport }} alt="passport-photo" style=" margin-left: 25px;">

                                <p style="font-weight:bold; margin-top:150px">Signature, Designation <br> (with date and
                                    seal) <br> of Registering authority </p>

                            </div>
                            <div style="margin-top: 6px; width: 80%;">
                                <p class="card-text"><span style="font-weight:bold">পিতৃৰ নাম / পত্নীৰ নাম Father’s
                                        Name/ Spouse’ Name:</span></p>
                                <div>
                                    <p class="card-text"><span style="font-weight:bold">জন্ম তাৰিখ / DOB:</span>
                                        {{ $wrkr->dob }} </p>
                                </div>
                                <div>
                                    <p class="card-text"><span style="font-weight:bold">লিংগ / Gender:</span>
                                        @foreach ($gender as $g)
                                            @if ($wrkr->gender_id == $g->gender_code)
                                                {{ $g->gender_name }}
                                            @endif
                                        @endforeach
                                    </p>
                                </div>
                                <div style="width: 50%">
                                    <p class="card-text"><span style="font-weight:bold">পঞ্জীয়নৰ তাৰিখ / Registration
                                            Date:</span> {{ $user->created_at }}
                                    </p>
                                </div>
                                <div>
                                    <p class="card-text"><span style="font-weight:bold">টিল বৈধ / Valid till:</span>
                                        {{ $user->renewal_date }}</p>
                                </div>
                                <div style="display: flex; justify-content:space-between; margin-top: 12px">
                                    <div>
                                        <p class="card-text"><span style="font-weight:bold">অৱসৰৰ তাৰিখ / Date of
                                                Retirement:</span> </p>
                                    </div>
                                    <div>
                                        <p class="card-text"><span style="font-weight:bold">চাকৰিৰ প্ৰকৃতি / Nature of
                                                job:</span> </p>
                                    </div>
                                </div>
                                <div style="margin-top: 12px">
                                    <p class="card-text"><span style="font-weight:bold">e-Shram UAN No.:
                                            {{ $wrkr->eshram_no }}</span> </p>
                                </div>
                                <div
                                    style="display: flex; flex-direction:column; justify-content:center; align-items:center; margin-top: -40px; margin-left: 500px;">
                                    <div>
                                        <p style="font-size:20px;">Registration Number: </p>
                                    </div>
                                    <div>
                                        <p style="font-size:22px; margin-left:10px">XXXXXXXXX </p>
                                    </div>
                                </div>
                            </div>
                            <!-- Remaining code remains the same -->
                        </div>
                    </div>
                </div>

                <!-- Back Side -->
                <div class="col-md-6">
                    <div class="id-card" style="display:flex; flex-direction:column; justify-content:flex-end">
                        <div style="padding-left:8px; padding-right:8px;">
                            <div style="float: left; margin-right: 20px;">
                                <img style="height: 150px; width: 90px; margin-top:6px" src={{ $emblem }} alt="National Emblem of India"
                                    class="emblem">
                            </div>
                            <div style="float: left; margin-left: 40px; margin-top: 10px">
                                <h3
                                    style="font-size:24px;padding-left:12px; padding-right:12px; padding-top:4px; padding-bottom:4px; background-color:#000; color:white">
                                    ASSAM BUILDING & OTHER CONSTRUCTION WORKERS WELFARE BOARD
                                </h3>
                                <h4 style="font-size:24px; margin-left: 120px;">
                                    As per Assam BOCW Rules of RE&CS Act 1996
                                </h4>
                            </div>
                            <div style="float: right; margin-right: 20px;">
                                <img style="height: 150px; width: 120px; margin-top:6px" src={{ $logo }} alt="National Emblem of India"
                                    class="emblem">
                            </div>
                            <div style="clear: both;"></div>
                        </div>
                        <div
                            style="font-size:16px; background-color:#000; color:white; text-align:center; margin-top: 9px">
                            <h3>অসম BOCW কাৰ্ড / Assam BOCW Card </h3>
                        </div>
                        <div style="display:flex; font-size: 24px; margin-left: 10px; margin-right: 10px">
                            <div class="card-body" style="width: 100%">
                                <div>
                                    <p class="card-text"><span style="font-weight:bold">স্থায়ী ঠিকনা: / Permanent
                                            Address:</span> </p>
                                </div>
                                <div style="margin-top: 20px">
                                    <p class="card-text"><span style="font-weight:bold">Signature / Thumb
                                            Impression:</span>
                                    </p>
                                </div>
                                <div style="margin-top: 20px">
                                    <p class="card-text"><span style="font-weight:bold">Blood group:</span></p>
                                </div>
                                <div>
                                    <p class="card-text"><span style="font-weight:bold">Contact no.:</span></p>
                                </div>
                            </div>
                            <div style="position: absolute; bottom:260px; margin-right: 40px">
                                <div >
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

                </div>
            </div>

        </div>
    </div>

</div>
