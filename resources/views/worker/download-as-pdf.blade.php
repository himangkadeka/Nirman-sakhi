{{--@include('worker.workerFormHeader')--}}
{{--<style>--}}
{{--    .alert-info {--}}
{{--        background-color: #0c5460;--}}
{{--    }--}}
{{--    a.href{--}}
{{--        text-decoration: none; /* Remove the default underline */--}}
{{--        color: green; /* Set the link color */--}}
{{--        transition: color 0.2s; /* Smooth color transition on hover */--}}
{{--    }--}}

{{--    /* Define the link hover effect */--}}
{{--    a.href:hover {--}}
{{--        color: #ff6b6b; /* Change the color on hover */--}}
{{--    }--}}

{{--</style>--}}
<div class="container-fluid mb-4">
    <div class="row">
    {{--    <div class="col-md-2"></div>--}}
    <!-- Left side columns -->
        <div class="col-md-12" >
            <div class="card">
                <div class="card-body">
{{--                    @if(session()->has('error'))--}}
{{--                        <div class="alert alert-danger">--}}
{{--                            <i class="bi bi-check-circle me-1"></i>--}}
{{--                            {{session('error')}}--}}
{{--                        </div>--}}
{{--                    @endif--}}
{{--                    @if ($errors->any())--}}
{{--                        <div class="alert alert-danger">--}}
{{--                            <ul>--}}
{{--                                @foreach ($errors->all() as $error)--}}
{{--                                    <li>{{ $error }}</li>--}}
{{--                                @endforeach--}}
{{--                            </ul>--}}
{{--                        </div>--}}
{{--                    @endif--}}
                    <h3 class="card-title alert-info"
                        style="text-align: center; color: white;padding-top: 30px; font-weight: bolder;"><i class="fa fa-tachometer" aria-hidden="true"></i>&nbspPREVIEW WORKER DETAILS</h3>
                    <h5 class="text-center mt-4" style="border-bottom:2px solid #0b0e25;width: 100%;"><i class="fa fa-user" aria-hidden="true"></i>&nbspWorker Basic Details:</h5>
                    <div class="mt-3" style="display: flex; justify-content:center">
                        <img src="{{ route('get-passport', ['id' => mt_rand(1, 1000)]) }}" alt="Applicant Photo" height="150px" width="150px">
                    </div>
                    <div class="mr-5 mt-5" id="applicant-photo-container" style="display: flex">
                        @if($twbd->resident_of_assam)
                            <div class="form-group col-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="resident_of_assam" name="resident_of_assam" checked disabled>
                                    <label class="form-check-label bold ml-2" for="resident_of_assam">Are you a resident of Assam but working in a state other than Assam?/আপুনি অসমৰ বাসিন্দা কিন্তু অসমৰ বাহিৰে আন ৰাজ্যত কৰ্মৰত নেকি?</label>
                                </div>
                                <div class="mt-3" id="roa_statement">
                                    <label for="inputCategory" class="bold">State/ৰাজ্য </label>
                                    <input type="text" class="form-control " id="age" value="{{$twbdjoin->roa_statement}}" placeholder="" disabled>
                                </div>
                            </div>
                        @endif

                        @if($twbd->resident_of_other)
                            <div class="form-group col-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="resident_of_other" name="resident_of_other" checked disabled>
                                    <label class="form-check-label bold ml-2" for="resident_of_other">Are you working in Assam but a resident of a different state?/আপুনি অসমত কাম কৰি আছে কিন্তু বেলেগ ৰাজ্যৰ বাসিন্দা নেকি?</label>
                                </div>
                                <div class="mt-3" id="roo_statement">
                                    <label for="inputCategory" class="bold">Category/শ্ৰেণী </label>
                                    <input type="text" class="form-control " id="age" value="{{$twbdjoin->roo_statement}}" placeholder="" disabled>
                                    </select>
                                </div>
                            </div>
                        @endif
                    </div>
                    <div class="form-row mt-4"><!--start 1-->
                        <div class="form-group col-md-4">
                            <label for="inputFirstName" class="bold">First Name/প্ৰথম নাম</label>
                            <input class="form-control  uc-text-smooth" id="firstname"
                                   value="{{$twbd->first_name}}" name="first_name" readonly>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="inputLastName" class="bold">Last Name/উপাধি</label>
                            <input  class="form-control  uc-text-smooth" id="lastname" value="{{$twbd->last_name}}" name="last_name" placeholder="" readonly>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="inputPassword4" class="bold">Fathers/Husband Name / পিতৃ/স্বামীৰ নাম</label>
                            <input type="text" class="form-control  uc-text-smooth" id="gurdain_name"
                                   value="{{$twbd->gurdain_name}}" name="gurdain_name" placeholder="" readonly>
                        </div>
                    </div><!--end-->
                    <div class="form-row"><!--start 1-->
                        <div class="form-group col-md-4">
                            <label for="gender" class="bold">Gender/লিংগ</label>
                            <input type="text" class="form-control  uc-text-smooth" id="gurdain_name"
                                   value="{{$twbdjoin->gender_name}}" name="gurdain_name" placeholder="" readonly>

                        </div>
                        <div class="form-group col-md-4">
                            <label for="inputAdhaar" class="bold">Aadhaar No/আধাৰ নং</label>
                            <input type="text" class="form-control " id="aadhar"
                                   placeholder="{{session()->get('adhaar_no')}}" disabled>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="mStatus" class="bold">Marital Status/বৈবাহিক অৱস্থা</label>
                            <input type="text" class="form-control " value="{{$twbdjoin->marital_status}}" readonly>
                            {{--                                <select id="inputState" class="form-control" name="maritial_status" disabled>--}}
                            {{--                                    <option value="{{$twbdjoin->maritial_status}}">{{$twbdjoin->marital_status}} </option>--}}
                            {{--                                </select>--}}
                        </div>
                    </div><!--end-->
                    <div class="form-row"><!--start 1-->
                        <div class="form-group col-md-4">
                            <label for="inputDob" class="bold">Date Of Birth/জন্ম তাৰিখ </label>
                            <input type="text" id="dob" class="form-control  datepicker"
                                   name="dob"  value="{{$twbd->dob}}" disabled>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="inputCategory" class="bold">Category/শ্ৰেণী </label>
                            <input type="text" class="form-control " id="age" value="{{$twbdjoin->category_name}}" placeholder="" disabled>
                            {{--                                <select id="inputCategory" class="form-control" name="category" disabled>--}}
                            {{--                                    <option value="{{$twbdjoin->category_code}}">{{$twbdjoin->category_name}} </option>--}}
                            {{--                                </select>--}}
                        </div>
                        <div class="form-group col-md-4">
                            <label for="inputPhone" class="bold">Mobile Phone Number/মোবাইল ফোন নম্বৰ </label>
                            <input type="text" class="form-control " id="phone" value="{{$tfm->phone_no}}"
                                   disabled>
                        </div>
                    </div><!--end-->
                    <div class="form-row"><!--start 1-->

                        <div class="form-group col-md-4">
                            <label for="inputPF">eShram Number/ইশ্ৰম নম্বৰ</label>
                            <input type="text" class="form-control  uc-text-smooth" id="eshram"
                                   value="{{$twbd->eshram_no}}" name="eshram_no" placeholder="" readonly>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="inputPhone" class="bold">Education Details/শিক্ষাৰ সবিশেষ</label>
                            <input type="text" class="form-control  uc-text-smooth" id="eshram"
                                   value="{{$twbdjoin->education_name}}" name="eshram_no" placeholder="" readonly>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="inputCategory" class="bold">Profession/পেছা </label>
                            <input type="text" class="form-control " id="age" value="{{$twbdjoin->skill_name}}" placeholder="" disabled>
                            {{--                                                                <select id="inputCategory" class="form-control" name="category" disabled>--}}
                            {{--                                                                    <option value="{{$twbdjoin->category_code}}">{{$twbdjoin->category_name}} </option>--}}
                            {{--                                                                </select>--}}
                        </div>

                    </div><!--end-->
                    <div class="form-row"><!--start 1-->
                        <div class="form-group col-md-4">
                            <label for="inputEsic" class="bold">Email/ইমেইল (If available) </label>
                            <input type="text" class="form-control  uc-text-smooth" id="email"
                                   value="{{$twbd->email}}" name="email" placeholder=""
                                   readonly>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="inputEsic" class="bold">PF/UAN (If available) </label>
                            <input type="text" class="form-control  uc-text-smooth" id="pf_no" value="{{$twbd->pf_no}}" name="pf_no" placeholder="" readonly>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="inputPhone" class="bold">ESIC Number(If available) </label>
                            <input type="text" class="form-control " value="{{$twbd->esic_no}}" id="esic_no" name="esic_no" readonly>
                        </div>
                    </div><!--end-->
                    <div class="form-row"><!--start 1-->
                        <div class="form-group col-md-4">
                            <label for="inputPhone" class="bold">PAN Number/পেন নম্বৰ</label>
                            <input type="text" class="form-control " value="{{$twbd->pan_no}}" id="pan_no" name="pan_no" readonly>
                        </div>
                    </div><!--end-->
{{--                    <h5 style="border-bottom:2px solid #0b0e25;width: 100%;" class="mt-4 text-center"><i class="fa fa-address-card" aria-hidden="true"></i>&nbspWorker Address Details:</h5>--}}
{{--                    <h5 style="border-bottom:2px solid #0b0e25;width: 25%;"><span class="material-symbols-outlined" >--}}
{{--home--}}
{{--</span>Current Residential Address:</h5>--}}
{{--                    <div class="form-row mt-4"><!--start 1-->--}}
{{--                        <div class="form-group col-md-3">--}}
{{--                            <label for="inputFirstName" class="bold">Type Of Residence </label>--}}
{{--                            <input type="text" class="form-control " value="{{$twamjoin->residence_name}}" id="esic_no" name="esic_no" readonly>--}}
{{--                            --}}{{--                                    <select class="form-control" name="c_residence" id="currentResidence" disabled>--}}
{{--                            --}}{{--                                        <option value="{{$twamjoin->c_residence}}">{{$twamjoin->residence_name}} </option>--}}
{{--                            --}}{{--                                    </select>--}}
{{--                            @if ($errors->has('c_residence'))--}}
{{--                                <span class="text-danger font-weight-normal">{{ $errors->first('c_residence') }}</span>--}}
{{--                            @endif--}}
{{--                        </div>--}}
{{--                        <div class="form-group col-md-3">--}}
{{--                            <label for="inputLastName" class="bold">Type Of House</label>--}}
{{--                            <input type="text" class="form-control " value="{{$twamjoin->house_type}}" id="esic_no" name="esic_no" readonly>--}}
{{--                            --}}{{--                                    <select class="form-control" name="c_house_type" id="currentHouse" disabled>--}}
{{--                            --}}{{--                                        <option value="{{$twamjoin->c_house_type}}">{{$twamjoin->house_type}} </option>--}}
{{--                            --}}{{--                                    </select>--}}
{{--                        </div>--}}
{{--                        <div class="form-group col-md-3">--}}
{{--                            <label for="inputPassword4" class="bold">House No./Building No. </label>--}}
{{--                            <input type="text" class="form-control " value="{{$twam->c_house_no}}" id="currentBuilding" name="c_house_no" placeholder="" readonly>--}}
{{--                        </div>--}}
{{--                        <div class="form-group col-md-3">--}}
{{--                            <label for="gender" class="bold">Area/Village </label>--}}
{{--                            <input type="text" class="form-control uc-text-smooth" value="{{$twam->c_area}}" id="currentArea" name="c_area" readonly>--}}
{{--                        </div>--}}
{{--                    </div><!--end-->--}}
{{--                    <div class="form-row"><!--start 1-->--}}

{{--                        <div class="form-group col-md-3">--}}
{{--                            <label for="inputMstatus" class="bold">City</label>--}}
{{--                            <input type="text" class="form-control uc-text-smooth" value="{{$twam->c_city}}" name="c_city" id="currentCity" disabled>--}}
{{--                        </div>--}}
{{--                        <div class="form-group col-md-3" >--}}
{{--                            <label for="inputAdhaar" class="bold">Road</label>--}}
{{--                            <input type="text" class="form-control uc-text-smooth" value="{{$twam->c_road}}" id="currentRoad" name="c_road" readonly>--}}
{{--                        </div>--}}
{{--                        <div class="form-group col-md-3">--}}
{{--                            <label for="inputDob" class="bold">State </label>--}}
{{--                            <input type="text" class="form-control uc-text-smooth" value="{{$twamjoin->state_name}}" readonly>--}}

{{--                        </div>--}}
{{--                        <div class="form-group col-md-3">--}}
{{--                            <label for="inputAge" class="bold">District</label>--}}
{{--                            <input type="text" class="form-control uc-text-smooth" value="{{$twamjoin->district_name}}" readonly>--}}

{{--                        </div>--}}
{{--                    </div><!--end-->--}}
{{--                    <div class="form-row"><!--start 1-->--}}
{{--                        <div class="form-group col-md-3">--}}
{{--                            <label for="inputAge" class="bold">Revenue Circle </label>--}}
{{--                            <input type="text" class="form-control uc-text-smooth" value="{{$twamjoin->subdistrict_name}}" readonly>--}}
{{--                        </div>--}}
{{--                        <div class="form-group col-md-3">--}}
{{--                            <label for="inputCategory" class="bold">Post Office </label>--}}
{{--                            <select  class="form-control uc-text-smooth" name="c_post_office"  id="currentPost" disabled>--}}
{{--                                <option value="{{$twamjoin->c_post_office}}">{{$twamjoin->poname}} </option>--}}
{{--                            </select>--}}
{{--                        </div>--}}
{{--                        <div class="form-group col-md-3">--}}
{{--                            <label for="inputPhone" class="bold">Pin Code</label>--}}
{{--                            <input type="text" class="form-control" id="currentPin" value="{{$twam->c_pin}}" name="c_pin"   placeholder="" readonly>--}}
{{--                            @if ($errors->has('c_pin'))--}}
{{--                                <span--}}
{{--                                    class="text-danger font-weight-normal">{{ $errors->first('c_pin') }}</span>--}}
{{--                            @endif--}}
{{--                        </div>--}}
{{--                        <div class="form-group col-md-3">--}}
{{--                            <label for="inputPF" class="bold">STD Code</label>--}}
{{--                            <input type="text" class="form-control" id="currentStd" value="{{$twam->c_std}}" name="c_std" placeholder="" readonly>--}}
{{--                        </div>--}}
{{--                    </div><!--end-->--}}
{{--                    <div class="form-row"><!--start 1-->--}}
{{--                        <div class="form-group col-md-3">--}}
{{--                            <label for="inputPhone" class="bold">Landmark</label>--}}
{{--                            <input type="text" class="form-control" name="landmark" value="{{$twam->landmark}}" id="landmark" readonly>--}}
{{--                        </div>--}}
{{--                    </div><!--end-->--}}
{{--                    <div class="form-row mb-4 mt-3"><!--start 1-->--}}
{{--                        <div class="form-check col-md-12" style="text-align: center;">--}}
{{--                            <h5 style="border-bottom:2px solid #0b0e25;width: 27%;"><span class="material-symbols-outlined" >home</span>Permanent Residential Address:</h5>--}}

{{--                        </div>--}}
{{--                    </div><!--end-->--}}
{{--                    <div class="form-row"><!--start 1-->--}}
{{--                        <div class="form-group col-md-3">--}}
{{--                            <label for="inputFirstName" class="bold">Type Of Residence </label>--}}
{{--                            <input type="text" class="form-control" name="landmark" value="{{$twamjoin->residence_name}}" id="landmark" readonly>--}}
{{--                        </div>--}}
{{--                        <div class="form-group col-md-3">--}}
{{--                            <label for="inputLastName" class="bold">Type Of House</label>--}}
{{--                            <input type="text" class="form-control" name="landmark" value="{{$twamjoin->house_type}}" id="landmark" readonly>--}}
{{--                        </div>--}}
{{--                        <div class="form-group col-md-3">--}}
{{--                            <label for="inputPassword4" class="bold">House No./Building No. </label>--}}
{{--                            <input type="text" class="form-control uc-text-smooth" value="{{$twam->p_house_no}}" id="permanentBuilding" name="p_house_no" placeholder="" readonly>--}}
{{--                        </div>--}}

{{--                        <div class="form-group col-md-3">--}}
{{--                            <label for="gender" class="bold">Area/Village </label>--}}
{{--                            <input type="text" class="form-control uc-text-smooth" id="permanentArea" name="p_area" value="{{$twam->p_area}}" readonly>--}}
{{--                        </div>--}}
{{--                    </div><!--end-->--}}
{{--                    <div class="form-row"><!--start 1-->--}}
{{--                        <div class="form-group col-md-3">--}}
{{--                            <label for="inputMstatus" class="bold">City</label>--}}
{{--                            <input type="text"  id="permanentCity" class="form-control " name="p_city" value="{{$twam->p_city}}" readonly>--}}
{{--                        </div>--}}

{{--                        <div class="form-group col-md-3">--}}
{{--                            <label for="inputAdhaar" class="bold">Road</label>--}}
{{--                            <input type="text" class="form-control  uc-text-smooth" id="permanentRoad" name="p_road" value="{{$twam->p_road}}" readonly>--}}
{{--                        </div>--}}

{{--                        <div class="form-group col-md-3">--}}
{{--                            <label for="inputDob" class="bold">State </label>--}}
{{--                            <input type="text" class="form-control" value="{{$twamjoin->state_name}}" readonly>--}}
{{--                        </div>--}}
{{--                        <div class="form-group col-md-3">--}}
{{--                            <label for="inputAge" class="bold">District </label>--}}
{{--                            <input type="text" class="form-control" value="{{$twamjoin->district_name}}" readonly>--}}
{{--                        </div>--}}
{{--                    </div><!--end-->--}}
{{--                    <div class="form-row"><!--start 1-->--}}
{{--                        <div class="form-group col-md-3">--}}
{{--                            <label for="inputAge" class="bold">Revenue Circle</label>--}}
{{--                            <input type="text" class="form-control" value="{{$twamjoin->subdistrict_name}}" readonly>--}}

{{--                        </div>--}}
{{--                        <div class="form-group col-md-3">--}}
{{--                            <label for="inputCategory" class="bold">Post Office </label>--}}
{{--                            <input type="text" class="form-control" value="{{$twamjoin->poname}}" readonly>--}}
{{--                        </div>--}}
{{--                        <div class="form-group col-md-3">--}}
{{--                            <label for="inputPhone" class="bold">Pin Code</label>--}}
{{--                            <input type="text" class="form-control" id="permanentPin" value="{{$twam->p_pin}}" name="p_pin" placeholder="" readonly>--}}
{{--                        </div>--}}
{{--                        <div class="form-group col-md-3">--}}
{{--                            <label for="inputPF" class="bold">STD Code</label>--}}
{{--                            <input type="text" class="form-control" id="permanentStd" value="{{$twam->p_std}}" name="p_std" placeholder="" readonly>--}}
{{--                        </div>--}}
{{--                    </div><!--end-->--}}
{{--                    <div class="form-row"><!--start 1-->--}}
{{--                        --}}{{--                                <div class="form-group col-md-3">--}}
{{--                        --}}{{--                                    <label for="inputPhone" class="bold">Land Line Number</label>--}}
{{--                        --}}{{--                                    <input type="text" class="form-control " id="landline"  name="landline" value="{{$twam->landline}}" placeholder="" readonly>--}}
{{--                        --}}{{--                                </div>--}}
{{--                        <div class="form-group col-md-3">--}}
{{--                            <label for="inputPF" class="bold">Ration Card Number</label>--}}
{{--                            <input type="text" class="form-control" id="ration_no" name="ration_no" value="{{$twam->ration_no}}" placeholder="" readonly>--}}
{{--                        </div>--}}
{{--                        <div class="form-group col-md-3">--}}
{{--                            <label for="inputPF" class="bold">Ration Card Type.</label>--}}
{{--                            <input type="text" class="form-control" id="ration" name="ration_type" value="{{$twam->ration_type}}" placeholder="" readonly>--}}
{{--                        </div>--}}

{{--                    </div><!--end-->--}}
{{--                    <h5 style="border-bottom:2px solid #0b0e25;width: 100%;" class="mt-4 text-center"><i class="fa fa-university" aria-hidden="true"></i>&nbspWorker Bank Details:</h5>--}}

{{--                    <div class="form-row mt-4"><!--start 1-->--}}
{{--                        <div class="form-group col-md-4">--}}
{{--                            <label for="inputBank" class="bold">Bank Name</label>--}}
{{--                            <input type="text" class="form-control uc-text-smooth" value="{{$twbm->bank_name}}" id="bank_name" name="bank_name" placeholder="" readonly>--}}
{{--                            @if ($errors->has('bank_name'))--}}
{{--                                <span class="text-danger font-weight-normal">{{ $errors->first('bank_name') }}</span>--}}
{{--                            @endif--}}
{{--                        </div>--}}
{{--                        <div class="form-group col-md-4">--}}
{{--                            <label for="inputBranch" class="bold">Branch Name</label>--}}
{{--                            <input type="text" class="form-control uc-text-smooth" id="branch_name" value="{{$twbm->branch_name}}" name="branch_name" readonly>--}}
{{--                            @if ($errors->has('branch_name'))--}}
{{--                                <span class="text-danger font-weight-normal">{{ $errors->first('branch_name') }}</span>--}}
{{--                            @endif--}}
{{--                        </div>--}}
{{--                        <div class="form-group col-md-4">--}}
{{--                            <label for="inputBankAddress" class="bold">Bank Address</label>--}}
{{--                            <input type="text" class="form-control uc-text-smooth" value="{{$twbm->bank_address}}" name="bank_address" readonly>--}}
{{--                            @if ($errors->has('bank_address'))--}}
{{--                                <span class="text-danger font-weight-normal">{{ $errors->first('bank_address') }}</span>--}}
{{--                            @endif--}}
{{--                        </div>--}}
{{--                    </div><!--end-->--}}
{{--                    <div class="form-row"><!--start 1-->--}}

{{--                        <div class="form-group col-md-4">--}}
{{--                            <label for="inputAcc" class="bold">Account Number</label>--}}
{{--                            <input type="text" class="form-control " id="account_no" name="account_no" value="{{$twbm->account_no}}" placeholder="" readonly>--}}
{{--                        </div>--}}

{{--                    </div><!--end-->--}}
{{--                    <h5 class="mt-4 text-center" style="border-bottom:2px solid #0b0e25;width: 100%;"><i class="fa fa-users" aria-hidden="true"></i>&nbspWorker Family Details:</h5>--}}
{{--                    <div class="table-responsive mt-4">--}}
{{--                        <table class="table table-bordered table-active">--}}
{{--                            <thead>--}}
{{--                            <tr  style="background-color: #c0dbdc;">--}}
{{--                                <th>First Name</th>--}}
{{--                                <th >Last Name</th>--}}
{{--                                <th >Guardian Name</th>--}}
{{--                                <th >DOB</th>--}}
{{--                                <th >Age</th>--}}
{{--                                <th >Relation</th>--}}
{{--                                <th >Profession</th>--}}
{{--                                <th >Education</th>--}}
{{--                                <th >Nominee</th>--}}
{{--                                <th>Already Registered?</th>--}}
{{--                                <th>BOCCW ID</th>--}}
{{--                            </tr>--}}
{{--                            <tr>--}}
{{--                                @foreach ($twfm as $key=>$familyMember)--}}

{{--                                    <td>{{$familyMember->first_name}}</td>--}}
{{--                                    <td>{{$familyMember->last_name}}</td>--}}
{{--                                    <td>{{$familyMember->gurdain_name}}</td>--}}
{{--                                    <td>{{$familyMember->dob}}</td>--}}
{{--                                    <td></td>--}}
{{--                                    <td>{{$familyMember->relation}}</td>--}}
{{--                                    <td>{{$familyMember->profession}}</td>--}}
{{--                                    <td>{{$familyMember->profession}}</td>--}}
{{--                                    <td><input type="checkbox"  class="form-control checkboxDisable" @if($familyMember->nominee == 1) checked @endif disabled/></td>--}}
{{--                                    <td><input type="checkbox" value="{{$familyMember->already_registered}}"  class="form-control regDisable" @if($familyMember->already_registered == 1) checked @endif disabled /></td>--}}
{{--                                    <td>{{ $familyMember->bocwwb_id ?? '' }}</td>--}}
{{--                            </tr>--}}
{{--                            @endforeach--}}
{{--                            </thead>--}}
{{--                        </table>--}}
{{--                    </div>--}}
{{--                    <h5 style="border-bottom:2px solid #0b0e25;width: 100%;text-align: center;" class="mt-4"><i class="fa fa-briefcase" aria-hidden="true"></i>&nbspWorker Employer Details:</h5>--}}
{{--                    <div class="form-row mt-4"><!--start 1-->--}}
{{--                        <div class="form-group col-md-4">--}}
{{--                            <label for="inputEmpName" class="bold">Employer Name</label>--}}
{{--                            <input type="text" class="form-control uc-text-smooth" id="emp_name"--}}
{{--                                   value="{{$twed->employer_name}}" name="employer_name" disabled>--}}
{{--                        </div>--}}
{{--                        <div class="form-group col-md-4">--}}
{{--                            <label for="inputContractor"class="bold">Contractor--}}
{{--                                Company/Individual--}}
{{--                                Employer/ Municipal--}}
{{--                                Board Name--}}
{{--                            </label>--}}
{{--                            <input type="text" class="form-control" value="{{$twed->board}}" readonly>--}}
{{--                        </div>--}}
{{--                        <div class="form-group col-md-4">--}}
{{--                            <label for="inputWork" class="bold">Type of Work</label>--}}
{{--                            <input type="text" class="form-control" value="{{$twedjoin->work_type_name}}" readonly>--}}
{{--                        </div>--}}
{{--                    </div><!--end-->--}}
{{--                    <div class="form-row"><!--start 1-->--}}
{{--                        <div class="form-group col-md-4">--}}
{{--                            <label for="workplace" class="bold">Workplace</label>--}}
{{--                            <input type="text" id="" name="workplace" class="form-control" value="{{$twed->workplace}}" readonly>--}}
{{--                        </div>--}}
{{--                        <div class="form-group col-md-4">--}}
{{--                            <label for="inputMobile" class="bold">Mobile</label>--}}
{{--                            <input type="text" class="form-control" id="mobile_no" name="mobile" value="{{$twed->mobile_no}}" readonly>--}}
{{--                        </div>--}}
{{--                        <div class="form-group col-md-4">--}}
{{--                            <label for="mStatus" class="bold">District</label>--}}
{{--                            <input type="text" class="form-control"  value="{{$twedjoin->district_name}}" readonly>--}}
{{--                        </div>--}}
{{--                    </div><!--end-->--}}
{{--                    <div class="form-row"><!--start 1-->--}}
{{--                        <div class="form-group col-md-4">--}}
{{--                            <label for="inputDob" class="bold">Sub-District of your workplace</label>--}}
{{--                            <input type="text" class="form-control"  value="{{$twedjoin->subdistrict_name}}" readonly>--}}
{{--                        </div>--}}
{{--                        <div class="form-group col-md-4">--}}
{{--                            <label for="inputAge" class="bold">Town/city</label>--}}
{{--                            <input type="text" class="form-control" id="city" name="city" placeholder="" value="{{$twed->city}}" readonly>--}}
{{--                        </div>--}}
{{--                        <div class="form-group col-md-4">--}}
{{--                            <label for="inputCategory" class="bold">Pin code </label>--}}
{{--                            <input type="text" class="form-control" name="pin_code" value="{{$twed->pin_code}}" readonly>--}}
{{--                        </div>--}}
{{--                    </div><!--end-->--}}
{{--                    <div class="form-row"><!--start 1-->--}}
{{--                        <div class="form-group col-md-4 input-container" style="">--}}
{{--                            <label for="inputPhone" class="bold" style="display: flex;--}}
{{--        align-items: center;">Date of Joining work<span class="material-symbols-outlined">calendar_month</span></label>--}}
{{--                            <input type="text" class="form-control" value="{{$twed->doj}}" readonly>--}}
{{--                        </div>--}}
{{--                        <div class="form-group col-md-4">--}}
{{--                            <label for="inputPF" class="bold">Nature of work</label>--}}
{{--                            <input type="text" class="form-control" value="{{$twedjoin->nature_of_work}}" readonly>--}}
{{--                        </div>--}}
{{--                        <div class="form-group col-md-4">--}}
{{--                            <label for="inputPhone" class="bold">MGNREGA Registration--}}
{{--                            </label>--}}
{{--                            <input type="text" class="form-control uc-text-smooth" id="occupation" value="{{$twed->mgnrega_no}}" name="mgnrega_no" placeholder="" readonly>--}}

{{--                        </div>--}}
{{--                    </div><!--end-->--}}
{{--                    <h5 style="border-bottom:2px solid #0b0e25;width: 100%;text-align: center;" class="mt-4"><i class="fa fa-certificate" aria-hidden="true"></i>&nbsp90 Days Working Certificate:</h5>--}}
{{--                    <div class="table-responsive mt-4">--}}
{{--                        <table class="table table-bordered table-active">--}}
{{--                            <thead>--}}
{{--                            <tr  style="background-color: #c0dbdc;">--}}
{{--                                <th >Type of Issuer</th>--}}
{{--                                <th >Issue Date</th>--}}
{{--                                <th >Issue Number</th>--}}
{{--                                <th >Type of Employer</th>--}}
{{--                                <th >Full Name</th>--}}
{{--                                <th >Mobile</th>--}}
{{--                                <th >From Date</th>--}}
{{--                                <th >To Date </th>--}}
{{--                            </tr>--}}
{{--                            <tr>--}}
{{--                                @foreach ($twcjoin as $key=>$certificate)--}}
{{--                                    <td>--}}
{{--                                        {{$certificate->issuer_name}}--}}
{{--                                    </td>--}}
{{--                                    <td>{{$certificate->issue_date}}</td>--}}
{{--                                    <td>{{$certificate->issue_no}}</td>--}}
{{--                                    <td>{{$certificate->issuer_name}}</td>--}}
{{--                                    <td>{{$certificate->name}}</td>--}}
{{--                                    <td>{{$certificate->mobile}}</td>--}}
{{--                                    <td>{{$certificate->from_date}}</td>--}}
{{--                                    <td>{{$certificate->to_date}}</td>--}}
{{--                            </tr>--}}
{{--                            @endforeach--}}
{{--                            </thead>--}}
{{--                        </table>--}}
{{--                    </div>--}}
{{--                    <h5 class="mt-4 text-center bold" style="border-bottom:2px solid #0b0e25; width: 100%;"><i class="fa fa-bookmark" aria-hidden="true"></i>&nbspSchemes Availing Already:</h5>--}}
{{--                    <div class="table-responsive mt-4">--}}
{{--                        <table class="table table-bordered table-active">--}}
{{--                            <thead>--}}
{{--                            <tr  style="background-color: #c0dbdc;">--}}
{{--                                <th>Schemes</th>--}}
{{--                                <th >Registration No</th>--}}
{{--                                <th >Date of Registration</th>--}}

{{--                            </tr>--}}
{{--                            <tr>--}}
{{--                                @foreach ($twsjoin as $key=>$schemes)--}}
{{--                                    <td>{{$schemes->scheme_name}}</td>--}}
{{--                                    <td>{{$schemes->registration_id}}</td>--}}
{{--                                    <td>{{$schemes->date}}</td>--}}
{{--                            </tr>--}}
{{--                            @endforeach--}}
{{--                            </thead>--}}
{{--                        </table>--}}

{{--                    </div>--}}
{{--                    <h5 style="border-bottom:2px solid #0b0e25;width: 100%;text-align: center;" class="mt-4"><i class="fa fa-folder-open" aria-hidden="true"></i>&nbspUploaded Documents:</h5>--}}
{{--                    <div class="table-responsive mt-4">--}}
{{--                        <table class="table table-active">--}}
{{--                            <thead>--}}
{{--                            <tr  style="background-color: #c0dbdc;">--}}
{{--                                <th scope="col">Sl.No</th>--}}
{{--                                <th scope="col">Type Of Documents</th>--}}
{{--                                <th scope="col">Files</th>--}}
{{--                            </tr>--}}
{{--                            </thead>--}}
{{--                            <tbody>--}}
{{--                            <tr>--}}
{{--                                <th scope="row">1</th>--}}
{{--                                <td>@if ($twd === 1) selected @endif Aadhaar</td>--}}
{{--                                <td><a href="{{ route('get-id-proof',['id'=> mt_rand(1,1000)])}}" class="href" target="_blank" ><i class="fa fa-external-link" aria-hidden="true"></i>&nbspVIEW PHOTO ID PROOF</a></td>--}}

{{--                            </tr>--}}
{{--                            <tr>--}}
{{--                                <th scope="row">2</th>--}}
{{--                                <td>@if ($twd === 1) selected @endif Aadhaar</td>--}}
{{--                                <td><a href="{{route('get-res-proof',['id'=> mt_rand(1,1000)])}}" class="href" target="_blank" ><i class="fa fa-external-link" aria-hidden="true"></i>&nbspVIEW RESIDENTIAL PROOF</a></td>--}}

{{--                            </tr>--}}
{{--                            <tr>--}}
{{--                                <th scope="row">3</th>--}}
{{--                                <td>Age Proof</td>--}}
{{--                                <td><a href="{{route('get-age-proof',['id'=> mt_rand(1,1000)])}}" class="href" target="_blank" ><i class="fa fa-external-link" aria-hidden="true"></i>&nbspVIEW AGE PROOF</a></td>--}}

{{--                            </tr>--}}
{{--                            <tr>--}}
{{--                                <th scope="row">4</th>--}}
{{--                                <td>Photocopy of Bank</td>--}}
{{--                                <td><a href="{{route('get-bank-copy',['id'=> mt_rand(1,1000)])}}" class="href" target="_blank"><i class="fa fa-external-link" aria-hidden="true"></i>&nbspVIEW BANK PHOTOCOPY</a></td>--}}

{{--                            </tr>--}}
{{--                            <tr>--}}
{{--                                <th scope="row">5</th>--}}
{{--                                <td>Certificate of working 90 days or more</td>--}}
{{--                                <td><a href="{{route('get-cert-proof',['id'=> mt_rand(1,1000)])}}" class="href" target="_blank" ><i class="fa fa-external-link" aria-hidden="true"></i>&nbspVIEW CERTIFICATE</a></td>--}}

{{--                            </tr>--}}
{{--                            <tr>--}}
{{--                                <th scope="row">6</th>--}}
{{--                                <td> Applicant Photo</td>--}}
{{--                                <td><a href="{{route('get-passport',['id'=> mt_rand(1,1000)])}}" class="href" target="_blank"><i class="fa fa-external-link" aria-hidden="true"></i>&nbspVIEW APPLICANT PHOTO</a></td>--}}

{{--                            </tr>--}}
{{--                            <tr>--}}
{{--                                <th scope="row">7</th>--}}
{{--                                <td> Applicant Thumb Print</td>--}}
{{--                                <td><a href="{{route('get-thumb',['id'=> mt_rand(1,1000)])}}" class="href" target="_blank"><i class="fa fa-external-link" aria-hidden="true"></i>&nbspVIEW THUMB PRINT</a></td>--}}

{{--                            </tr>--}}
{{--                            <tr>--}}
{{--                                <th scope="row">8</th>--}}
{{--                                <td> Address Proof : Aadhar</td>--}}
{{--                                <td><a href="{{route('get-address-proof',['id'=> mt_rand(1,1000)])}}" class="href" target="_blank" ><i class="fa fa-external-link" aria-hidden="true"></i>&nbspVIEW ADDRESS PROOF</a></td>--}}

{{--                            </tr>--}}
{{--                            <tr>--}}
{{--                                <th scope="row">9</th>--}}
{{--                                <td>Bank Passbook</td>--}}
{{--                                <td><a href="{{route('get-bank-pass',['id'=> mt_rand(1,1000)])}}" class="href" target="_blank" ><i class="fa fa-external-link" aria-hidden="true"></i>&nbspVIEW BANK PASSBOOK</a></td>--}}

{{--                            </tr>--}}
{{--                            </tbody>--}}
{{--                        </table>--}}

                    </div>
{{--                    <a  class="btn btn-outline-info mt-3 float-right margin-left"  href='{{route('save-final-data')}}' ><span class="material-symbols-outlined">check_circle</span>--}}
{{--                        Final Submit--}}
{{--                    </a>--}}
{{--                    <a href="{{route('update-documents')}}" class="btn btn-outline-info mt-3 float-right margin-left mr-2"><span class="material-symbols-outlined">--}}
{{--edit_square--}}
{{--</span>Edit Details--}}
{{--                    </a>--}}
{{--                    <a href="{{route('download-as-pdf')}}" target="_blank" class="btn btn-outline-info mt-3 float-right margin-left mr-2"><span class="material-symbols-outlined">--}}
{{--                                edit_square--}}
{{--                                </span>Download PDF--}}
{{--                    </a>--}}

                </div>
            </div>

        </div>
    </div>
</div>
</div><!-- End Left side columns -->
{{--</div>--}}
{{--<link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">--}}
{{--<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.0/jquery.min.js"></script>--}}
{{--<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>--}}
{{--@include('layout.footer')--}}
