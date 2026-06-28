@extends('layouts.user-app')


@section('title', 'Checklist for PFC operators')

@section('style')

    {{-- <link rel="stylesheet" href="{{ URL::asset('assets/template/css/actandrules.css') }}" /> --}}

    <style>
   .col-md-3 {
    display: flex;
    justify-content: flex-start; /* Aligns content to the right */
    align-items: center; /* Vertically centers the content */
}

     section.pfcpage{
        width:100%;padding:50px 0px;background:linear-gradient(45deg, #faf7db, #0ae1fd1c);position: relative;
    }
    section.pfcpage .box{
    margin: 0 auto;
    width: 50%;
    display: block;
    background: white;
    padding: 20px;
    box-sizing: border-box;
    box-shadow: rgba(149, 157, 165, 0.2) 0px 8px 24px;
}
@media(min-width:1600px){
    section.pfcpage .box{width:60%;display: block;}
}
section.pfcpage .box ul{padding: 0px;margin: 0px;list-style:none;counter-reset: list-counter;}

section.pfcpage .box ul li {
    counter-increment: list-counter;
    display: flex;
    justify-content: left;
    align-items: center;
    padding: 10px;
    background: #f9f9f9;
    margin-bottom: 12px;
    border: 1px solid #ddd;
    border-radius: 5px;
    transition:0.4s linear;
}
section.pfcpage .box ul li:hover{background: #dddddd;}</style>
@endsection

@section('content')




    <section class="pfcpage">
        <div class="pagination">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">E-Services</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Checklist for PFC Operators</li>
                </ol>
            </nav>
        </div>

        <div class="heading">
            <h2>Checklist for New Registration</h2>
            <div class="centerHeading"></div>
        </div>
        <div class="box">
            <ul>
                <li>

                    <div class="col-md-9 text-align-left  " style="text-align: left;">Active mobile number for
                        registration
                        (preferably the mobile number registered on
                        the applicant’s name) available?</div>

                    <div class="col-md-3" >
                       <label>
                                <input type="radio" name="choice1" value="yes"> Yes
                            </label> <label>
                                <input type="radio" name="choice1" value="yes"> No
                            </label>
                    </div>

                </li>
                <li >

                    <span class="col-md-9   eligibility"
                    style="text-align: left;">Aadhaar card available?</span>

                    <div class="col-md-3" style="text-align: right;">
                        <label>
                            <input type="radio" name="choice1" value="yes"> Yes
                        </label>
                        <label>
                            <input type="radio" name="choice1" value="no"> No
                        </label>
                    </div>


                </li>

                <li>
                    <div class="col-md-9 p-3  align-middle eligibility"
                        data-label="Eligibility criteria & documents required">Is mobile number linked to Aadhaar number for
                        receiving otp?</div>
                    <div class="col-md-3">
                        <div> <label>
                                <input type="radio" name="choice3" value="yes"> Yes
                            </label> <label>
                                <input type="radio" name="choice3" value="yes"> No
                            </label></div>
                    </div>

                </li>
                <li>
                    <div class="col-md-9 p-3  " data-label="">eShram UAN no available?</div>
                    <div class="col-md-3">
                        <div> <label>
                                <input type="radio" name="choice4" value="yes"> Yes
                            </label> <label>
                                <input type="radio" name="choice4" value="yes"> No
                            </label></div>
                    </div>

                </li>
                <li>
                    <div class="col-md-9 p-3  " data-label="">Age as per the Aadhaar card is not more than 55 years?</div>
                    <div class="col-md-3">
                        <div> <label>
                                <input type="radio" name="choice5" value="yes"> Yes
                            </label> <label>
                                <input type="radio" name="choice5" value="yes"> No
                            </label></div>
                    </div>

                </li>
                <li>
                    <div class="col-md-9 p-3    " data-label="">Present address proof (Aadhaar/Ration card/Gas
                        bill/Telephone bill/Driving
                        license/Bank or Post office passbook) available?</div>
                    <div class="col-md-3">
                        <div> <label>
                                <input type="radio" name="choice6" value="yes"> Yes
                            </label> <label>
                                <input type="radio" name="choice6" value="yes"> No
                            </label></div>
                    </div>

                </li>
                <li>
                    <div class="col-md-9 p-3 align-middle " data-label="">The present address (as per the present address
                        proof) shall be in Assam?</div>
                    <div class="col-md-3">
                        <div> <label>
                                <input type="radio" name="choice7" value="yes"> Yes
                            </label> <label>
                                <input type="radio" name="choice7" value="yes"> No
                            </label></div>
                    </div>

                </li>

                <li>
                    <div class="col-md-9 p-3 align-middle " data-label="">Work certificate(s) available?</div>
                    <div class="col-md-3">
                        <div> <label>
                                <input type="radio" name="choice8" value="yes"> Yes
                            </label> <label>
                                <input type="radio" name="choice8" value="yes"> No
                            </label></div>
                    </div>

                </li>
                <li>
                    <div class="col-md-9 p-3 align-middle " data-label="">Working period mentioned in the certificate(s)
                        falls under the preceding year (last 12
                        months)?</div>
                    <div class="col-md-3">
                        <div> <label>
                                <input type="radio" name="choice9" value="yes"> Yes
                            </label> <label>
                                <input type="radio" name="choice9" value="yes"> No
                            </label></div>
                    </div>

                </li>
                <li>
                    <div class="col-md-9 p-3 align-middle " data-label="">The combined no of employment days shall not be
                        less than 90 days.</div>
                    <div class="col-md-3">
                        <div> <label>
                                <input type="radio" name="choice10" value="yes"> Yes
                            </label> <label>
                                <input type="radio" name="choice10" value="yes"> No
                            </label></div>
                    </div>

                </li>
                <li>
                    <div class="col-md-9 p-3 align-middle " data-label="">Any asterisk marked field in the work
                        certificate(s) shall not be blank.</div>
                    <div class="col-md-3">
                        <div> <label>
                                <input type="radio" name="choice11" value="yes"> Yes
                            </label> <label>
                                <input type="radio" name="choice11" value="yes"> No
                            </label></div>
                    </div>

                </li>
                <li>
                    <div class="col-md-9 p-3 align-middle " data-label="">Aadhaar linked Bank passbook (for DBT transfer)
                        available?</div>
                    <div class="col-md-3">
                        <div> <label>
                                <input type="radio" name="choice12" value="yes"> Yes
                            </label> <label>
                                <input type="radio" name="choice12" value="yes"> No
                            </label></div>
                    </div>

                </li>

            </ul>
        </div>


        <div class="heading mt-5">
            <h2>Checklist for Onboarding (registered workers)</h2>
            <div class="centerHeading"></div>
        </div>
        <div class="box">
            <ul>
                <li>

                    <div class="col-md-9   " data-label="Eligibility criteria & documents required">Active mobile number
                        for registration (preferably the mobile number registered on
                        the applicant’s name)?</div>

                    <div class="col-md-3">
                        <div> <label>
                                <input type="radio" name="choice13" value="yes"> Yes
                            </label> <label>
                                <input type="radio" name="choice13" value="yes"> No
                            </label></div>
                    </div>

                </li>
                <li>

                    <div class="col-md-9 p-3  align-middle eligibility"
                        data-label="Eligibility criteria & documents required">ABOCWWB ID card available?</div>

                    <div class="col-md-3">
                        <div> <label>
                                <input type="radio" name="choice14" value="yes"> Yes
                            </label> <label>
                                <input type="radio" name="choice14" value="yes"> No
                            </label></div>
                    </div>

                </li>

                <li>
                    <div class="col-md-9 p-3  align-middle eligibility"
                        data-label="Eligibility criteria & documents required">Aadhaar card available?</div>
                    <div class="col-md-3">
                        <div> <label>
                                <input type="radio" name="choice15" value="yes"> Yes
                            </label> <label>
                                <input type="radio" name="choice15" value="yes"> No
                            </label></div>
                    </div>

                </li>
                <li>
                    <div class="col-md-9 p-3  " data-label="">Is the DoB on BOCW ID card same as DoB on Aadhaar?</div>
                    <div class="col-md-3">
                        <div> <label>
                                <input type="radio" name="choice16" value="yes"> Yes
                            </label> <label>
                                <input type="radio" name="choice16" value="yes"> No
                            </label></div>
                    </div>

                </li>
                <li>
                    <div class="col-md-9 p-3  " data-label="">Is mobile number linked to Aadhaar number for receiving
                        otp?</div>
                    <div class="col-md-3">
                        <div> <label>
                                <input type="radio" name="choice17" value="yes"> Yes
                            </label> <label>
                                <input type="radio" name="choice17" value="yes"> No
                            </label></div>
                    </div>

                </li>
                <li>
                    <div class="col-md-9 p-3    " data-label="">eShram UAN number available?</div>
                    <div class="col-md-3">
                        <div> <label>
                                <input type="radio" name="choice18" value="yes"> Yes
                            </label> <label>
                                <input type="radio" name="choice18" value="yes"> No
                            </label></div>
                    </div>

                </li>
                <li>
                    <div class="col-md-9 p-3 align-middle " data-label="">Subscription payment receipt available?</div>
                    <div class="col-md-3">
                        <div> <label>
                                <input type="radio" name="choice19" value="yes"> Yes
                            </label> <label>
                                <input type="radio" name="choice19" value="yes"> No
                            </label></div>
                    </div>

                </li>

                <li>
                    <div class="col-md-9 p-3 align-middle " data-label="">Present address proof (Aadhaar/Ration card/Gas
                        bill/Telephone bill/Driving
                        license/Bank or Post office passbook) available?</div>
                    <div class="col-md-3">
                        <div> <label>
                                <input type="radio" name="choice20" value="yes"> Yes
                            </label> <label>
                                <input type="radio" name="choice20" value="yes"> No
                            </label></div>
                    </div>

                </li>
                <li>
                    <div class="col-md-9 p-3 align-middle " data-label="">Work certificate(s) / Workbook (Optional-
                        required only if the worker’s latest
                        employment in the preceding year, else not required) available?</div>
                    <div class="col-md-3">
                        <div> <label>
                                <input type="radio" name="choice21" value="yes"> Yes
                            </label> <label>
                                <input type="radio" name="choice21" value="yes"> No
                            </label></div>
                    </div>

                </li>
                <li>
                    <div class="col-md-9 p-3 align-middle " data-label="">In the above case- Calculate the number of
                        employment days in the preceding year
                        (last 12 months)? The number of employment days shall not be less than 90 days.</div>
                    <div class="col-md-3">
                        <div> <label>
                                <input type="radio" name="choice22" value="yes"> Yes
                            </label> <label>
                                <input type="radio" name="choice22" value="yes"> No
                            </label></div>
                    </div>

                </li>
                <li>
                    <div class="col-md-9 p-3 align-middle " data-label="">Aadhaar linked Bank passbook (for DBT transfer)
                        available?</div>
                    <div class="col-md-3">
                        <div> <label>
                                <input type="radio" name="choice23" value="yes"> Yes
                            </label> <label>
                                <input type="radio" name="choice23" value="yes"> No
                            </label></div>
                    </div>

                </li>


            </ul>
            <p><strong>Note:</strong> In the onboarding process of existing beneficiaries, select the district and office as
                mentioned in the BOCW ID card.</p>
        </div>

        <div class="heading mt-5">
            <h2>Checklist for Renewal</h2>
            <div class="centerHeading"></div>
        </div>
        <div class="box">
            <ul>
                <li>

                    <div class="col-md-9   " data-label="Eligibility criteria & documents required">ABOCWWB ID card
                        available?</div>

                    <div class="col-md-3">
                        <div> <label>
                                <input type="radio" name="choice24" value="yes"> Yes
                            </label> <label>
                                <input type="radio" name="choice24" value="yes"> No
                            </label></div>
                    </div>

                </li>
                <li>

                    <div class="col-md-9 p-3  align-middle eligibility"
                        data-label="Eligibility criteria & documents required">Updated subscription payment receipt
                        available?</div>

                    <div class="col-md-3">
                        <div> <label>
                                <input type="radio" name="choice25" value="yes"> Yes
                            </label> <label>
                                <input type="radio" name="choice25" value="yes"> No
                            </label></div>
                    </div>

                </li>

                <li>
                    <div class="col-md-9 p-3  align-middle eligibility"
                        data-label="Eligibility criteria & documents required">Work certificate(s) / Workbook available?
                    </div>
                    <div class="col-md-3">
                        <div> <label>
                                <input type="radio" name="choice26" value="yes"> Yes
                            </label> <label>
                                <input type="radio" name="choice26" value="yes"> No
                            </label></div>
                    </div>

                </li>
                <li>
                    <div class="col-md-9 p-3  " data-label="">If workbook is signed by the issuer, calculate the number
                        of days of employment in the
                        preceding year (last 12 months)?</div>
                    <div class="col-md-3">
                        <div> <label>
                                <input type="radio" name="choice27" value="yes"> Yes
                            </label> <label>
                                <input type="radio" name="choice27" value="yes"> No
                            </label></div>
                    </div>

                </li>
                <li>
                    <div class="col-md-9 p-3  " data-label="">The number of days of employment in the above calculation
                        shall not be less than 90
                        days?</div>
                    <div class="col-md-3">
                        <div> <label>
                                <input type="radio" name="choice28" value="yes"> Yes
                            </label> <label>
                                <input type="radio" name="choice28" value="yes"> No
                            </label></div>
                    </div>




            </ul>

        </div>
    </section>



@endsection

@section('footer')


@endsection
