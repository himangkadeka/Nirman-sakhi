@include('layout.officeheader')
<style>
    .alert-info {
        background-color: #0c5460;
    }

    a.href {
        text-decoration: none;
        /* Remove the default underline */
        color: #219fa4;
        /* Set the link color */
        transition: color 0.2s;
        /* Smooth color transition on hover */
    }

    a.href:hover {
        color: #ff6b6b;
        /* Change the color on hover */
    }

    h5 {
        color: #076f6b;
        position: relative;
        display: inline-block;
    }

    h5.preview-color {
        color: #076f6b;
    }

    h5::after {
        content: "";
        display: block;
        width: 100%;
        height: 2px;
        background-color: #ffbf49;
        position: absolute;
        bottom: -5px;
        left: 0;
        transform: scaleX(0);
        transform-origin: bottom right;
        transition: transform 0.3s ease;
    }

    h5:hover::after {
        transform: scaleX(1);
        transform-origin: bottom left;
    }

    i {
        margin-right: 5px;
    }

    .custom-form {
        border: 2px solid rgba(0, 0, 0, .075);
        /* Border color - a shade of blue */
        border-radius: 10px;
        /* Border radius for rounded corners */
        padding: 20px;
        /* Padding inside the form */
        margin-top: 20px;
        /* Margin to separate the form from other elements */
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        /* Add a subtle box shadow */
        background-color: #f4f4f4;
        /* Background color - a light gray */
    }

    .form-group {
        margin-bottom: 15px;
        /* Margin between form groups */
    }

    .table th {
        font-size: 14px;
    }

    .table-container {
        overflow-x: auto;
    }

    .fixed-width {
        min-width: 200px;
        /* Adjust the width as needed */
    }

    .fixed {
        min-width: 100px;
        /* Adjust the width as needed */
    }

    .table thead th {
        border-bottom: 1px solid black;
    }

    .form-control {
        height: 30px;
        /* Adjust the height as needed */
    }

    .bold {
        font-weight: 500;
        font-family: "Montserrat Alternates", "Open Sans", Helvetica, Arial, sans-serif;
        font-size: 14px;
        /*color: #186cb8;*/
        color: #219fa4;
        /*color: #7ea1a2;*/
    }
</style>

<body>
    <div class="d-flex" id="wrapper">
        {{-- @include('office.leftmenu') --}}
        <div id="page-content-wrapper">

            <nav class="navbar navbar-expand-lg navbar-light dashboard-bgcolor border-bottom">
                <button class="btn b-db-color" id="menu-toggle">
                    <span style="display:none;">Menu</span>
                    <span class="fas fa-bars" style="font-size: 1.4rem"></span>
                </button>
                <button class="navbar-toggler b-dropmenubtn" type="button" data-toggle="collapse"
                    data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                    aria-label="Toggle navigation">
                    <span class="far fa-caret-square-down" style="font-size: 30px; color: #FFF"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">

                    <ul class="navbar-nav ml-auto mt-2 mt-lg-0">
                        <!--<li class="nav-item">
                      <a class="nav-link b-db-color" href="#">Notification</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link b-db-color" href="#">Inbox</a>
                    </li>-->
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle b-db-color" href="#" id="navbarDropdown"
                                role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="fas fa-users" style="font-size: 20px; padding-right:10px;"></span>Profile
                            </a>
                            <div class="dropdown-menu dropdown-menu-right text-center b-dropmenu-db"
                                aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="#">My Profile</a>
                                <a class="dropdown-item" href="#">Change Password</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="javascript:void(0);" data-toggle="modal"
                                    data-target="#signout-modal">Sign Out</a>

                            </div>
                        </li>
                    </ul>
                </div>
            </nav>

            <div class="container-fluid mb-4">
                <div class="row">
                    {{--    <div class="col-md-2"></div> --}}
                    <!-- Left side columns -->
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="heading-wrapper">
                                    <h4 class="text-center font-weight-bold" style="color: #076f6b;">APPLICATION DETAILS
                                    </h4>
                                </div>

                                <div class="mt-3" style="display: flex; justify-content:right">
                                    <img src="{{ route('passport', ['worker_id' => encrypt($twam->worker_id)]) }}"
                                        alt="Applicant Photo" height="150px" width="150px">
                                </div>
                                {{--                    <h5 style="border-bottom:2px solid #0b0e25;width: 25%;" class="mt-3"><i class="fa fa-info-circle" aria-hidden="true"></i>Basic Details:</h5> --}}
                                <div class="form-row mt-2"><!--start 1-->
                                    <div class="form-check col-md-12" style="text-align: center;">
                                        <h5 class="preview-color"><i class="fa fa-info-circle"
                                                aria-hidden="true"></i>&nbsp;Basic Details:</h5>
                                    </div>
                                </div>
                                <div class="custom-form">
                                    <div class="form-row">
                                        <div class="form-group col-md-3">
                                            <label class="bold">Worker Status</label>
                                            @if ($twbd->resident_type === 'rao')
                                                <input type="text" class="form-control" value="Migrant Worker"
                                                    readonly>
                                            @else
                                                <input type="text" class="form-control" value="Resident Worker"
                                                    readonly>
                                            @endif
                                        </div>
                                        @if ($twbd->resident_type == 'rao')
                                            <div class="form-group col-md-3">
                                                <label class="bold">State</label>
                                                <input type="text" class="form-control" placeholder=""
                                                    value="{{ $twbdjoin->state_name }}" readonly />
                                            </div>
                                        @endif
                                    </div>


                                    <div class="form-row mt-2"><!--start 1-->
                                        <div class="form-group col-md-3">
                                            <label for="inputFirstName" class="bold">First Name</label>
                                            <input class="form-control uc-text-smooth" value="{{ $twbd->first_name }}"
                                                readonly>
                                        </div>
                                        <div class="form-group col-md-3">
                                            <label for="inputLastName" class="bold">Last Name</label>
                                            <input class="form-control  uc-text-smooth"
                                                value="{{ $twbd->last_name }}"readonly>
                                        </div>
                                        <div class="form-group col-md-3">
                                            <label for="inputPassword4" class="bold">Fathers/Husband Name</label>
                                            <input type="text" class="form-control  uc-text-smooth"
                                                value="{{ $twbd->gurdain_name }}" readonly>
                                        </div>
                                        <div class="form-group col-md-3">
                                            <label for="gender" class="bold">Gender</label>
                                            <input type="text" class="form-control  uc-text-smooth"
                                                value="{{ $twbdjoin->gender_name }}" readonly>

                                        </div>
                                    </div><!--end-->
                                    <div class="form-row"><!--start 1-->

                                        {{--                            <div class="form-group col-md-3"> --}}
                                        {{--                                <label for="inputAdhaar" class="bold">Aadhaar No</label> --}}
                                        {{--                                <input type="text" class="form-control " --}}
                                        {{--                                       placeholder="{{session()->get('adhaar_no')}}" disabled> --}}
                                        {{--                            </div> --}}
                                        <div class="form-group col-md-3">
                                            <label for="mStatus" class="bold">Marital Status</label>
                                            <input type="text" class="form-control "
                                                value="{{ $twbdjoin->marital_status }}" readonly>
                                        </div>

                                        <div class="form-group col-md-3">
                                            <label for="inputDob" class="bold">Date Of Birth </label>
                                            <input type="text" id="dob" class="form-control  datepicker"
                                                name="dob" value="{{ $twbd->dob }}" disabled>
                                        </div>
                                        <div class="form-group col-md-3">
                                            <label for="inputCategory" class="bold">Category </label>
                                            <input type="text" class="form-control " id="age"
                                                value="{{ $twbdjoin->category_name }}" disabled>
                                        </div>
                                    </div><!--end-->

                                    <div class="form-row"><!--start 1-->

                                        <div class="form-group col-md-3">
                                            <label for="inputPhone" class="bold">Mobile Number </label>
                                            <input type="text" class="form-control " value="{{ $tfm->phone_no }}"
                                                disabled>
                                        </div>
                                        <div class="form-group col-md-3">
                                            <label for="inputPF" class="bold">eShram Number</label>
                                            <input type="text" class="form-control  uc-text-smooth"
                                                value="{{ $twbd->eshram_no }}" readonly>
                                        </div>
                                        <div class="form-group col-md-3">
                                            <label for="inputPhone" class="bold">Education Details</label>
                                            <input type="text" class="form-control  uc-text-smooth"
                                                value="{{ $twbdjoin->education_name }}" readonly>
                                        </div>
                                        <div class="form-group col-md-3">
                                            <label for="inputCategory" class="bold">Profession </label>
                                            <input type="text" class="form-control "
                                                value="{{ $twbdjoin->skill_name }}" disabled>

                                        </div>
                                    </div><!--end-->
                                    <div class="form-row"><!--start 1-->

                                    </div><!--end-->
                                    <div class="form-row"><!--start 1-->
                                        <div class="form-group col-md-3">
                                            <label for="inputEsic" class="bold">Email (If available) </label>
                                            <input type="text" class="form-control  uc-text-smooth"
                                                value="{{ $twbd->email ?? __('N/A') }}" readonly>
                                        </div>
                                        <div class="form-group col-md-3">
                                            <label for="inputEsic" class="bold">PF/UAN (If available) </label>
                                            <input type="text" class="form-control  uc-text-smooth"
                                                value="{{ $twbd->pf_no ?? __('N/A') }}"readonly>
                                        </div>
                                        <div class="form-group col-md-3">
                                            <label for="inputPhone" class="bold">ESIC Number(If available) </label>
                                            <input type="text" class="form-control "
                                                value="{{ $twbd->esic_no ?? __('N/A') }}" readonly>
                                        </div>
                                        <div class="form-group col-md-3">
                                            <label for="inputPhone" class="bold">PAN Available</label>
                                            <input type="text" class="form-control "
                                                value="{{ $twbd->pan == 1 ? 'Yes' : 'No' }}" readonly>
                                        </div>

                                    </div><!--end-->
                                    <div class="form-row"><!--start 1-->
                                        @if ($twbd->pan == 1)
                                            <div class="form-group col-md-3">
                                                <label for="inputPhone" class="bold">PAN Number</label>
                                                <input type="text" class="form-control "
                                                    value="{{ $twbd->pan_no }}" readonly>
                                            </div>
                                        @endif

                                        <div class="form-group col-md-3">
                                            <label for="inputPhone" class="bold">Already Registered in Other
                                                BOC</label>
                                            <input type="text" class="form-control "
                                                value="{{ $twbd->boc == 1 ? 'Yes' : 'No' }}" readonly>
                                        </div>
                                        @if ($twbd->boc == '1')
                                            <div class="form-group col-md-3">
                                                <label for="inputPhone" class="bold">BOC Number</label>
                                                <input type="text" class="form-control "
                                                    value="{{ $twbd->boc_no }}" id="pan_no" name="pan_no"
                                                    readonly>
                                            </div>
                                        @endif
                                    </div><!--end-->
                                </div>
                                <div class="form-row  mt-4"><!--start 1-->
                                    <div class="form-check col-md-12" style="text-align: center;">
                                        <h5 class="preview-color"><i class="fa fa-address-card"
                                                aria-hidden="true"></i>&nbsp;Permanent Residential Address:</h5>
                                    </div>
                                </div>
                                <div class="custom-form">
                                    <div class="form-row"><!--start 1-->
                                        <div class="form-group col-md-3">
                                            <label for="inputFirstName" class="bold">Type Of Residence </label>
                                            <input type="text" class="form-control " name="landmark"
                                                value="{{ $twamjoin->residence_name }}" id="landmark" readonly>
                                        </div>
                                        <div class="form-group col-md-3">
                                            <label for="inputLastName" class="bold">Type Of House</label>
                                            <input type="text" class="form-control " name="landmark"
                                                value="{{ $twamjoin->house_type }}" id="landmark" readonly>
                                        </div>
                                        <div class="form-group col-md-3">
                                            <label for="inputPassword4" class="bold">House No./Building No. </label>
                                            <input type="text" class="form-control  uc-text-smooth"
                                                value="{{ $twam->p_house_no }}" id="permanentBuilding"
                                                name="p_house_no" placeholder="" readonly>
                                        </div>

                                        <div class="form-group col-md-3">
                                            <label for="gender" class="bold">Area/Village </label>
                                            <input type="text" class="form-control  uc-text-smooth"
                                                id="permanentArea" name="p_area" value="{{ $twam->p_area }}"
                                                readonly>
                                        </div>
                                    </div><!--end-->
                                    <div class="form-row"><!--start 1-->
                                        <div class="form-group col-md-3">
                                            <label for="inputMstatus" class="bold">City</label>
                                            <input type="text" id="permanentCity" class="form-control "
                                                name="p_city" value="{{ $twam->p_city }}" readonly>
                                        </div>

                                        <div class="form-group col-md-3">
                                            <label for="inputAdhaar" class="bold">Road</label>
                                            <input type="text" class="form-control   uc-text-smooth"
                                                id="permanentRoad" name="p_road" value="{{ $twam->p_road }}"
                                                readonly>
                                        </div>

                                        <div class="form-group col-md-3">
                                            <label for="inputDob" class="bold">State </label>
                                            <input type="text" class="form-control "
                                                value="{{ $twamjoin->state_name }}" readonly>
                                        </div>
                                        <div class="form-group col-md-3">
                                            <label for="inputAge" class="bold">District </label>
                                            <input type="text" class="form-control "
                                                value="{{ $twamjoin->district_name }}" readonly>
                                        </div>
                                    </div><!--end-->
                                    <div class="form-row"><!--start 1-->
                                        <div class="form-group col-md-3">
                                            <label for="inputAge" class="bold">Revenue Circle</label>
                                            <input type="text" class="form-control "
                                                value="{{ $twamjoin->subdistrict_name }}" readonly>

                                        </div>
                                        <div class="form-group col-md-3">
                                            <label for="inputCategory" class="bold">Post Office </label>
                                            <input type="text" class="form-control "
                                                value="{{ $twamjoin->post_office_name }}" readonly>
                                        </div>
                                        <div class="form-group col-md-3">
                                            <label for="inputPhone" class="bold">Pin Code</label>
                                            <input type="text" class="form-control " id="permanentPin"
                                                value="{{ $twam->p_pin }}" name="p_pin" placeholder="" readonly>
                                        </div>
                                        <div class="form-group col-md-3">
                                            <label for="inputPF" class="bold">Ration Card Available?</label>
                                            <input type="text" class="form-control "
                                                value="{{ $twam->has_ration_card == 1 ? 'Yes' : 'No' }}"readonly>
                                        </div>
                                    </div><!--end-->
                                    @if ($twam->has_ration_card == 1)
                                        <div class="form-row"><!--start 1-->
                                            <div class="form-group col-md-3">
                                                <label for="inputPF" class="bold">Ration Card Number</label>
                                                <input type="text" class="form-control " id="ration_no"
                                                    name="ration_no" value="{{ $twam->ration_no }}" placeholder=""
                                                    readonly>
                                            </div>
                                            <div class="form-group col-md-3">
                                                <label for="inputPF" class="bold">Ration Card Type.</label>
                                                <input type="text" class="form-control " id="ration"
                                                    name="ration_type" value="{{ $twamjoin->name }}" placeholder=""
                                                    readonly>
                                            </div>

                                </div><!--end-->
                                @endif
                                <div class="form-row mb-4 mt-3"><!--start 1-->
                                    <div class="form-check col-md-12" style="text-align: center;">
                                        <h5 class="preview-color"><i class="fa fa-address-card"
                                                aria-hidden="true"></i>&nbsp;Current Residential Address:</h5>

                                    </div>
                                </div><!--end-->
                                <div class="custom-form">
                                    <div class="form-row"><!--start 1-->
                                        <div class="form-group col-md-3">
                                            <label for="inputFirstName" class="bold">Type Of Residence </label>
                                            <input type="text" class="form-control "
                                                value="{{ $twamjoin->residence_name ?? '' }}" id="esic_no"
                                                name="esic_no" readonly>
                                        </div>
                                        <div class="form-group col-md-3">
                                            <label for="inputLastName" class="bold">Type Of House</label>
                                            <input type="text" class="form-control "
                                                value="{{ $twamjoin->house_type ?? '' }}" id="esic_no"
                                                name="esic_no" readonly>

                                        </div>
                                        <div class="form-group col-md-3">
                                            <label for="inputPassword4" class="bold">House No./Building No. </label>
                                            <input type="text" class="form-control "
                                                value="{{ $twam->c_house_no }}" id="currentBuilding"
                                                name="c_house_no" placeholder="" readonly>
                                        </div>
                                        <div class="form-group col-md-3">
                                            <label for="gender" class="bold">Area/Village </label>
                                            <input type="text" class="form-control  uc-text-smooth"
                                                value="{{ $twam->c_area }}" id="currentArea" name="c_area"
                                                readonly>
                                        </div>
                                    </div><!--end-->
                                    <div class="form-row"><!--start 1-->

                                        <div class="form-group col-md-3">
                                            <label for="inputMstatus" class="bold">City</label>
                                            <input type="text" class="form-control  uc-text-smooth"
                                                value="{{ $twam->c_city }}" name="c_city" id="currentCity"
                                                disabled>
                                        </div>
                                        <div class="form-group col-md-3">
                                            <label for="inputAdhaar" class="bold">Road</label>
                                            <input type="text" class="form-control  uc-text-smooth"
                                                value="{{ $twam->c_road }}" id="currentRoad" name="c_road"
                                                readonly>
                                        </div>
                                        <div class="form-group col-md-3">
                                            <label for="inputDob" class="bold">State </label>
                                            <input type="text" class="form-control  uc-text-smooth"
                                                value="{{ $twamjoin->state_name ?? '' }}" readonly>

                                        </div>
                                        <div class="form-group col-md-3">
                                            <label for="inputAge" class="bold">District</label>
                                            <input type="text" class="form-control  uc-text-smooth"
                                                value="{{ $twamjoin->district_name ?? '' }}" readonly>

                                        </div>
                                    </div><!--end-->
                                    <div class="form-row"><!--start 1-->
                                        <div class="form-group col-md-3">
                                            <label for="inputAge" class="bold">Revenue Circle </label>
                                            <input type="text" class="form-control  uc-text-smooth"
                                                value="{{ $twamjoin->subdistrict_name ?? '' }}" readonly>
                                        </div>
                                        <div class="form-group col-md-3">
                                            <label for="inputCategory" class="bold">Post Office </label>
                                            <select class="form-control  uc-text-smooth" name="c_post_office"
                                                id="currentPost" disabled>
                                                <option value="{{ $twamjoin->c_post_office }}">
                                                    {{ $twamjoin->post_office_name }} </option>
                                            </select>
                                        </div>
                                        <div class="form-group col-md-3">
                                            <label for="inputPhone" class="bold">Pin Code</label>
                                            <input type="text" class="form-control " id="currentPin"
                                                value="{{ $twam->c_pin }}" name="c_pin" placeholder="" readonly>
                                        </div>
                                        <div class="form-group col-md-3">
                                            <label for="inputPhone" class="bold">Landmark</label>
                                            <input type="text" class="form-control " name="landmark"
                                                value="{{ $twam->landmark ?? __('N/A') }}" id="landmark" readonly>
                                        </div>
                                    </div><!--end-->
                                </div>
                                {{--                    <h5 style="color: #ffbf49;" class="mt-3"><i class="fa fa-credit-card" aria-hidden="true"></i>&nbsp;Bank Details:</h5> --}}
                                <div class="form-row mt-4"><!--start 1-->
                                    <div class="form-check col-md-12" style="text-align: center;">
                                        <h5 class="preview-color"><i class="fa fa-credit-card"
                                                aria-hidden="true"></i>&nbsp;Bank Details:</h5>

                                    </div>
                                </div><!--end-->
                                <div class="custom-form">
                                    <div class="form-row mt-4"><!--start 1-->
                                        <div class="form-group col-md-3">
                                            <label for="inputBank" class="bold">Bank Name</label>
                                            <input type="text" class="form-control  uc-text-smooth"
                                                value="{{ $twbm->bank_name }}" readonly>

                                        </div>
                                        <div class="form-group col-md-3">
                                            <label for="inputBranch" class="bold">Branch Name</label>
                                            <input type="text" class="form-control  uc-text-smooth"
                                                value="{{ $twbm->branch_name }}" readonly>

                                        </div>
                                        <div class="form-group col-md-3">
                                            <label for="inputBankAddress" class="bold">Bank Address</label>
                                            <input type="text" class="form-control  uc-text-smooth"
                                                value="{{ $twbm->bank_address }}" readonly>

                                        </div>
                                        <div class="form-group col-md-3">
                                            <label for="inputAcc" class="bold">Account Number</label>
                                            <input type="text" class="form-control " id="account_no"
                                                name="account_no" value="{{ $twbm->account_no }}" placeholder=""
                                                readonly>
                                        </div>
                                    </div><!--end-->
                                </div>
                                {{--                    <h5 style="color: #ffbf49;" class="mt-3"><i class="fa fa-users" aria-hidden="true"></i>&nbspFamily Details:</h5> --}}
                                <div class="form-row mb-4 mt-4"><!--start 1-->
                                    <div class="form-check col-md-12" style="text-align: center;">
                                        <h5 class="preview-color"><i class="fa fa-users"
                                                aria-hidden="true"></i>&nbspFamily Details:</h5>

                                    </div>
                                </div><!--end-->
                                <div class="custom-form">
                                    <div class="row">
                                        <div class="col">
                                            <div class="table-container">
                                                <table class="table">
                                                    <thead>
                                                        <tr>
                                                            <th scope="col" class="bold">Serial No</th>
                                                            <th scope="col" class="bold">First Name</th>
                                                            <th scope="col" class="bold">Last Name</th>
                                                            <th scope="col" class="bold">DOB</th>
                                                            {{--                                            <th scope="col" class="bold">Age</th> --}}
                                                            <th scope="col" class="bold">Guardian Name</th>
                                                            <th scope="col" class="bold">Relation</th>
                                                            <th scope="col" class="bold">Profession</th>
                                                            <th scope="col" class="bold">Education</th>
                                                            <th scope="col" class="bold">Nominee(Y/N)</th>
                                                            <th scope="col" class="bold">Nominee Share</th>
                                                            <th scope="col" class="bold">Nominee Bank Account
                                                            </th>
                                                            <th scope="col" class="bold">Already Registered?</th>
                                                            <th scope="col" class="bold">BOCW ID</th>
                                                            <!-- Repeat headers as needed -->
                                                        </tr>
                                                        <tr>
                                                            @foreach ($twfjoin as $key => $familyMember)
                                                                <td>{{ $key + 1 }}</td>

                                                                <td class="fixed">{{ $familyMember->first_name }}
                                                                </td>
                                                                <td class="fixed">{{ $familyMember->last_name }}</td>
                                                                <td class="fixed">
                                                                    {{ \Carbon\Carbon::parse($familyMember->dob)->format('d-m-y') }}
                                                                </td>
                                                                <td class="fixed-width">
                                                                    {{ $familyMember->guardian_name ?? __('N/A') }}
                                                                </td>
                                                                <td class="fixed">{{ $familyMember->relation_name }}
                                                                </td>
                                                                <td class="fixed-width">
                                                                    {{ $familyMember->profession_name }}</td>
                                                                <td class="fixed">{{ $familyMember->education_name }}
                                                                </td>
                                                                <td class="fixed">
                                                                    {{ $familyMember->nominee == 1 ? 'Yes' : 'No' }}
                                                                </td>
                                                                <td class="fixed">
                                                                    {{ $familyMember->nominee_percentage ?? __('N/A') }}
                                                                </td>
                                                                <td class="fixed-width">
                                                                    {{ $familyMember->nominee_account ?? __('N/A') }}
                                                                </td>
                                                                <td class="fixed-width">
                                                                    {{ $familyMember->already_registered == 1 ? 'Yes' : 'No' }}
                                                                </td>
                                                                <td class="fixed-width">
                                                                    {{ $familyMember->bocwwb_id ?? __('N/A') }}</td>
                                                        </tr>
                                                        @endforeach
                                                    </thead>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                {{--                    <h5 style="color: #ffbf49;" class="mt-3"><i class="fa fa-gavel" aria-hidden="true"></i>&nbsp;Employer Details:</h5> --}}
                                <div class="form-row mb-4 mt-4"><!--start 1-->
                                    <div class="form-check col-md-12" style="text-align: center;">
                                        <h5 class="preview-color"><i class="fa fa-gavel"
                                                aria-hidden="true"></i>&nbsp;Employer Details:</h5>

                                    </div>
                                </div><!--end-->
                                <div class="custom-form">
                                    <div class="form-row mt-4"><!--start 1-->
                                        <div class="form-group col-md-4">
                                            <label for="inputEmpName" class="bold">Employer Name</label>
                                            <input type="text" class="form-control  uc-text-smooth" id="emp_name"
                                                value="{{ $twed->employer_name }}" name="employer_name" disabled>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="inputContractor"class="bold">Contractor
                                                Company/Individual
                                                Employer/ Municipal
                                                Board/Panchayat
                                            </label>
                                            <input type="text" class="form-control " value="{{ $twed->board }}"
                                                readonly>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="inputWork" class="bold">Type of Work</label>
                                            <input type="text" class="form-control "
                                                value="{{ $twedjoin->work_type_name }}" readonly>
                                        </div>
                                    </div><!--end-->
                                    <div class="form-row"><!--start 1-->
                                        <div class="form-group col-md-4">
                                            <label for="workplace" class="bold">Workplace</label>
                                            <input type="text" id="" name="workplace"
                                                class="form-control " value="{{ $twed->workplace }}" readonly>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="inputMobile" class="bold">Mobile</label>
                                            <input type="text" class="form-control " id="mobile_no"
                                                name="mobile" value="{{ $twed->mobile_no }}" readonly>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="mStatus" class="bold">District</label>
                                            <input type="text" class="form-control"
                                                value="{{ $twedjoin->district_name }}" readonly>
                                        </div>
                                    </div><!--end-->
                                    <div class="form-row"><!--start 1-->
                                        <div class="form-group col-md-4">
                                            <label for="inputDob" class="bold">Sub-District of your
                                                workplace</label>
                                            <input type="text" class="form-control "
                                                value="{{ $twedjoin->subdistrict_name }}" readonly>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="inputAge" class="bold">Town/city</label>
                                            <input type="text" class="form-control " id="city"
                                                name="city" placeholder="" value="{{ $twed->city }}" readonly>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="inputCategory" class="bold">Pin code </label>
                                            <input type="text" class="form-control " name="pin_code"
                                                value="{{ $twed->pin_code }}" readonly>
                                        </div>
                                    </div><!--end-->
                                    <div class="form-row"><!--start 1-->
                                        <div class="form-group col-md-4 input-container" style="">
                                            <label for="inputPhone" class="bold"
                                                style="display: flex; align-items: center;">Date of Joining
                                                work<span
                                                    class="material-symbols-outlined">calendar_month</span></label>
                                            <input type="text" class="form-control " value="{{ $twed->doj }}"
                                                readonly>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="inputPF" class="bold">Nature of work</label>
                                            <input type="text" class="form-control "
                                                value="{{ $twedjoin->nature_of_work }}" readonly>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="inputPhone" class="bold">MGNREGA Registration
                                            </label>
                                            <input type="text" class="form-control  uc-text-smooth"
                                                id="occupation" value="{{ $twed->mgnrega_no }}" name="mgnrega_no"
                                                placeholder="" readonly>

                                        </div>
                                    </div><!--end-->
                                </div>
                                {{--                    <h5 style="color: #ffbf49;" class="mt-3"><i class="fa fa-certificate" aria-hidden="true"></i>&nbsp90 days Certificate Details:</h5> --}}
                                <div class="form-row mb-4 mt-4"><!--start 1-->
                                    <div class="form-check col-md-12" style="text-align: center;">
                                        <h5 class="preview-color"><i class="fa fa-certificate"
                                                aria-hidden="true"></i>&nbsp90 days Certificate Details:</h5>

                                    </div>
                                </div><!--end-->
                                <div class="custom-form">
                                    <div class="row">
                                        <div class="col">
                                            <div class="table-container">
                                                <table class="table">
                                                    <thead>
                                                        <tr>
                                                            <th scope="col" class="bold">Type of
                                                                Issuer/ইছ্যুকাৰীৰ প্ৰকাৰ
                                                            <th scope="col" class="bold">Type of
                                                                Employer/নিয়োগকৰ্তাৰ প্ৰকাৰ
                                                            <th scope="col" class="bold">Full Name/সম্পূৰ্ণ নাম
                                                            <th scope="col" class="bold">Phone No/ফোন নং
                                                            <th scope="col" class="bold">From Date/তাৰিখৰ পৰা
                                                            <th scope="col" class="bold">To Date/তাৰিখলৈকে
                                                                {{--                                    <th scope="col" class="bold">No of Days/দিনৰ সংখ্যা --}}
                                                            <th scope="col" class="bold">Issue Date/ইছ্যুৰ তাৰিখ
                                                            <th scope="col" class="bold">Issue Number/ইছ্যু নম্বৰ
                                                        </tr>
                                                        <tr>
                                                            @foreach ($twcjoin as $key => $certificate)
                                                                <td class="fixed-width">
                                                                    {{ $certificate->issuer_name }}</td>
                                                                <td class="fixed-width">
                                                                    {{ $certificate->issuer_name }}</td>
                                                                <td class="fixed-width">{{ $certificate->name }}</td>
                                                                <td class="fixed-width">{{ $certificate->mobile }}
                                                                </td>
                                                                <td class="fixed-width">
                                                                    {{ \Carbon\Carbon::parse($certificate->from_date)->format('d-m-y') }}
                                                                </td>
                                                                <td class="fixed-width">
                                                                    {{ \Carbon\Carbon::parse($certificate->to_date)->format('d-m-y') }}
                                                                </td>
                                                                <td class="fixed-width">
                                                                    {{ \Carbon\Carbon::parse($certificate->issue_date)->format('d-m-y') }}
                                                                </td>
                                                                <td class="fixed-width">{{ $certificate->issue_no }}
                                                                </td>
                                                            @endforeach
                                                        </tr>
                                                    </thead>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                {{--                    <h5 style="color: #ffbf49;" class="mt-3"><i class="fa fa-ticket" aria-hidden="true"></i>&nbspSchemes Availed:</h5> --}}
                                <div class="form-row mb-4 mt-4"><!--start 1-->
                                    <div class="form-check col-md-12" style="text-align: center;">
                                        <h5 class="preview-color"><i class="fa fa-ticket"
                                                aria-hidden="true"></i>&nbspSchemes Availed:</h5>
                                    </div>
                                </div><!--end-->
                                <div class="custom-form">
                                    <div class="row">
                                        <div class="col">
                                            <div class="table-container">
                                                @if ($twsjoin->isEmpty())
                                                    <tr>
                                                        <td colspan="5">No Scheme Availed</td>
                                                    </tr>
                                                @else
                                                    <table class="table">
                                                        <thead>
                                                            <tr>
                                                                <th scope="col" class="bold">Schemes</th>
                                                                <th scope="col" class="bold">Registration No</th>
                                                                <th scope="col" class="bold">Date of Registration
                                                                </th>
                                                            </tr>

                                                            @foreach ($twsjoin as $key => $schemes)
                                                                @if ($schemes->enrolled == '0')
                                                                    <tr>
                                                                        <td>No data to display</td>
                                                                    </tr>
                                                                @else
                                                                    <tr>
                                                                        <td>{{ $schemes->scheme_name }}</td>
                                                                        <td>{{ $schemes->registration_id }}</td>
                                                                        <td>{{ \Carbon\Carbon::parse($schemes->date)->format('d-m-y') }}
                                                                        </td>
                                                                    </tr>
                                                                @endif
                                                            @endforeach
                                                @endif
                                                </thead>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                {{--                    <h5 style="color: #ffbf49;" class="mt-3"><i class="fa fa-file"  aria-hidden="true"></i>&nbsp;Uploaded Documents:</h5> --}}
                                <div class="form-row mb-4 mt-4"><!--start 1-->
                                    <div class="form-check col-md-12" style="text-align: center;">
                                        <h5 class="preview-color"><i class="fa fa-file"
                                                aria-hidden="true"></i>&nbsp;Uploaded Documents:</h5>

                                    </div>
                                </div><!--end-->
                                <div class="custom-form">
                                    <div class="table-responsive mt-2">
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th scope="col" class="bold">Sl.No</th>
                                                    <th scope="col" class="bold">Type Of Documents</th>
                                                    <th scope="col" class="bold">Attachments</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <th scope="row">1</th>
                                                    <td>Photo Id Proof</td>
                                                    <td><a href="{{ route('id-proof', ['worker_id' => encrypt($twam->worker_id)]) }}"
                                                            class="href" target="_blank"><i
                                                                class="fa fa-external-link"
                                                                aria-hidden="true"></i>&nbspView Id Proof</a></td>

                                                </tr>
                                                <tr>
                                                    <th scope="row">2</th>
                                                    <td>Address Proof</td>
                                                    <td><a href="{{ route('res-proof', ['worker_id' => encrypt($twam->worker_id)]) }}"
                                                            class="href" target="_blank"><i
                                                                class="fa fa-external-link"
                                                                aria-hidden="true"></i>&nbsp;View Address proof</a>
                                                    </td>

                                                </tr>
                                                <tr>
                                                    <th scope="row">3</th>
                                                    <td>Age Proof</td>
                                                    <td><a href="{{ route('age-proof', ['worker_id' => encrypt($twam->worker_id)]) }}"
                                                            class="href" target="_blank"><i
                                                                class="fa fa-external-link"
                                                                aria-hidden="true"></i>&nbspView Age Proof</a></td>

                                                </tr>
                                                <tr>
                                                    <th scope="row">4</th>
                                                    <td>Worker Bank Photo Copy</td>
                                                    <td><a href="{{ route('bank-pass', ['worker_id' => encrypt($twam->worker_id)]) }}"
                                                            class="href" target="_blank"><i
                                                                class="fa fa-external-link"
                                                                aria-hidden="true"></i>&nbsp;View Worker bank Copy</a>
                                                    </td>

                                                </tr>
                                                <tr>
                                                    <th scope="row">5</th>
                                                    <td>Certificate of working 90 days or more</td>
                                                    <td><a href="{{ route('cert-proof', ['worker_id' => encrypt($twam->worker_id)]) }}"
                                                            class="href" target="_blank"><i
                                                                class="fa fa-external-link"
                                                                aria-hidden="true"></i>&nbsp;View Certificate</a></td>

                                                </tr>
                                                <tr>
                                                    <th scope="row">6</th>
                                                    <td> Applicant Photo</td>
                                                    <td><a href="{{ route('passport', ['worker_id' => encrypt($twam->worker_id)]) }}"
                                                            class="href" target="_blank"><i
                                                                class="fa fa-external-link"
                                                                aria-hidden="true"></i>&nbspView Applicant Photo</a>
                                                    </td>

                                                </tr>
                                                <tr>
                                                    <th scope="row">7</th>
                                                    <td> Applicant Thumb Print</td>
                                                    <td><a href="{{ route('thumb', ['worker_id' => encrypt($twam->worker_id)]) }}"
                                                            class="href" target="_blank"><i
                                                                class="fa fa-external-link"
                                                                aria-hidden="true"></i>&nbspView Thumb Print</a></td>

                                                </tr>
                                                <tr>
                                                    <th scope="row">8</th>
                                                    <td> Nominee Bank Photo Copy</td>
                                                    <td><a href="{{ route('nominee_bank', ['worker_id' => encrypt($twam->worker_id)]) }}"
                                                            class="href" target="_blank"><i
                                                                class="fa fa-external-link"
                                                                aria-hidden="true"></i>&nbsp;View Nominee Bank Photo
                                                            Copy</a></td>

                                                </tr>
                                                <tr>
                                                    <th scope="row">9</th>
                                                    <td>Ration card</td>
                                                    <td><a href="{{ route('ration_card', ['worker_id' => encrypt($twam->worker_id)]) }}"
                                                            class="href" target="_blank"><i
                                                                class="fa fa-external-link"
                                                                aria-hidden="true"></i>&nbsp;View Ration Card</a></td>

                                                </tr>
                                                <tr>
                                                    <th scope="row">10</th>
                                                    <td>Pan card</td>
                                                    <td><a href="{{ route('pan_card', ['worker_id' => encrypt($twam->worker_id)]) }}"
                                                            class="href" target="_blank"><i
                                                                class="fa fa-external-link"
                                                                aria-hidden="true"></i>&nbsp;View Pan Card</a></td>

                                                </tr>
                                            </tbody>
                                        </table>

                                    </div>


                                </div>
                                @if ($username->role_id == 3 && $status->status == 'A')
                                    <div class="d-flex justify-content-center">
                                        <a class="btn btn-outline-info mt-3 float-right margin-left mr-2"
                                            href="javascript:void(0);" data-toggle="modal"
                                            data-target="#approve-modal">
                                            <span class="material-symbols-outlined">check_circle</span>Approve
                                        </a>
                                        <a class="btn btn-outline-warning mt-3 float-right margin-left mr-2 text-white"
                                            href="javascript:void(0);" data-toggle="modal"
                                            data-target="#reject-modal">
                                            <span class="material-symbols-outlined">edit_square</span>Reject</a>

                                        {{-- <a class="btn btn-outline-primary mt-3 float-right margin-left mr-2 text-white" href="javascript:void(0);" data-toggle="modal" data-target="#forward-modal"></a> --}}
                                        <a class="btn btn-outline-success mt-3 float-right margin-left mr-2 text-white"
                                            href="javascript:void(0);" data-toggle="modal"
                                            data-target="#forward-modal">
                                            <span class="material-symbols-outlined">edit_square</span>Forward

                                        </a>
                                        <a class="btn btn-outline-info mt-3 float-right margin-left mr-2 text-white"
                                            href="javascript:void(0);" data-toggle="modal"
                                            data-target="#revertback-modal">
                                            <span class="material-symbols-outlined">edit_square</span>Revert back

                                        </a>
                                        <a class="btn btn-outline-warning mt-3 float-right margin-left mr-2 text-white"
                                            href="{{ route('office.dashboard.index') }}">
                                            <span class="material-symbols-outlined">close</span>Cancel
                                        </a>
                                    </div>
                                    <!--if pulled Back-->
                                @elseif($username->role_id == 3 && $status->status == 'B')
                                    <div class="d-flex justify-content-center">
                                        <a class="btn btn-outline-info mt-3 float-right margin-left mr-2"
                                            href="javascript:void(0);" data-toggle="modal"
                                            data-target="#approve-modal">
                                            <span class="material-symbols-outlined">check_circle</span>Approve
                                        </a>
                                        <a class="btn btn-outline-warning mt-3 float-right margin-left mr-2 text-white"
                                            href="javascript:void(0);" data-toggle="modal"
                                            data-target="#reject-modal">
                                            <span class="material-symbols-outlined">edit_square</span>Reject
                                        </a>

                                        {{-- <a class="btn btn-outline-success mt-3 float-right margin-left mr-2 text-white" href="javascript:void(0);" data-toggle="modal" data-target="#forward-modal"> --}}
                                        {{-- <span class="material-symbols-outlined">edit_square</span>Forward --}}
                                        {{-- </a> --}}
                                        <a class="btn btn-outline-info mt-3 float-right margin-left mr-2 text-white"
                                            href="{{ route('office.dashboard.index') }}">
                                            <span class="material-symbols-outlined">close</span>Cancel
                                        </a>
                                    </div>
                                @elseif($username->role_id == 3 && $status->status == 'C')
                                    <div class="d-flex justify-content-center">
                                        <a class="btn btn-outline-success mt-3  mr-2 text-white"
                                            href="javascript:void(0);" data-toggle="modal"
                                            data-target="#pullback-modal">
                                            <span class="material-symbols-outlined">cloud_download</span>Pull Back
                                            Application
                                        </a>
                                        <a class="btn btn-outline-warning mt-3 float-right margin-left mr-2 text-white"
                                            href="{{ route('office.dashboard.index') }}">
                                            <span class="material-symbols-outlined">close</span>Cancel
                                        </a>
                                    </div>
                                @elseif($username->role_id == 4)
                                    <div class="d-flex justify-content-center">

                                        <a class="btn btn-outline-success mt-3 float-right margin-left mr-2 text-white"
                                            href="javascript:void(0);" data-toggle="modal"
                                            data-target="#forward-modal-ro">
                                            <span class="material-symbols-outlined">forward
                                            </span>Forward
                                        </a>
                                        <a class="btn btn-outline-warning mt-3 float-right margin-left mr-2 text-white"
                                            href="{{ route('officeloginsuccess') }}"><span
                                                class="material-symbols-outlined">
                                                close
                                            </span>Cancel
                                        </a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="forward-modal" aria-hidden="true" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">

                    <!-- Modal Header -->
                    <div class="modal-header text-center d-block p-2 border-bottom-0">
                        <h4 class="modal-title">Assign Application</h4>
                        <button type="button" class="close position-absolute" style="right: 15px; top: 8px;"
                            data-dismiss="modal">&times;</button>
                    </div>

                    <!-- Modal body -->
                    <div class="modal-body">
                        <p class="text-center">Forward the application to respective officer</p>
                        <form action="{{ route('forward_application') }}" method="POST">
                            @csrf
                            <div class="form-group">

                                <div class="col-md-12">

                                    <input type="hidden" name="application_id" value="{{ $tfm->worker_id }}">
                                    <label class="control-label bold col-md-8" for="office">Concerned
                                        Office:</label>

                                    <select name="role_id" class="form-control" id="role_id">
                                        <option value="">--Select Role--</option>
                                        @foreach ($da as $users)
                                            <option value="{{ $users->role_id }}">{{ $users->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-12 mt-2">
                                    <label class="control-label bold col-md-8" for="office">Remarks:</label>
                                    <input type="text" class="form-control" name="remarks" id="remarks">
                                </div>
                            </div>
                            <div class="text-center py-2">
                                <input type="submit" class="btn btn-primary b-btn mx-2">
                                <button class="btn btn-secondary mx-3" data-dismiss="modal">Cancel</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!--Approve modal-->
        <div class="modal fade" id="approve-modal" aria-hidden="true" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <!-- Modal Header -->
                    <div class="modal-header text-center d-block p-2 border-bottom-0">
                        <h4 class="modal-title">Approve Application</h4>
                        <button type="button" class="close position-absolute" style="right: 15px; top: 8px;"
                            data-dismiss="modal">&times;</button>
                    </div>
                    <!-- Modal body -->
                    <div class="modal-body">
                        <form action="{{ route('approve_application') }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label class="control-label bold col-md-8" for="office">Remarks:</label>
                                <div class="col-md-12 mt-2">
                                    <input type="hidden" name="application_id" value="{{ $tfm->worker_id }}">
                                    <input type="text" class="form-control" name="remarks" id="remarks">
                                </div>
                            </div>
                            <div class="text-center py-2">
                                <input type="submit" class="btn btn-primary b-btn mx-2">
                                <button class="btn btn-secondary mx-3" data-dismiss="modal">Cancel</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!--forward to ro-->
            <div class="modal fade" id="forward-modal-ro" aria-hidden="true" tabindex="-1" role="dialog">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <!-- Modal Header -->
                        <div class="modal-header text-center d-block p-2 border-bottom-0">
                            <h4 class="modal-title">Approve Application</h4>
                            <button type="button" class="close position-absolute" style="right: 15px; top: 8px;"
                                data-dismiss="modal">&times;</button>
                        </div>
                        <!-- Modal body -->
                        <div class="modal-body">
                            <p class="text-center">Forward the application to respective officer</p>
                            <form action="{{ route('forwardro-application') }}" method="POST">
                                @csrf
                                <div class="form-group">
                                    <div class="col-md-12">
                                        <input type="hidden" name="application_id" value="{{ $tfm->worker_id }}">
                                        <label class="control-label bold col-md-8" for="office">Concerned Office:</label>
                                        <select name="role_id" class="form-control" id="role_id">
                                            <option value="">--Select Role--</option>
                                            @foreach ($ro as $users)
                                                <option value="{{ $users->role_id }}">{{ $users->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-12 mt-2">
                                        <label class="control-label bold col-md-8" for="office">Remarks:</label>
                                        <input type="text" class="form-control" name="remarks" id="remarks">
                                    </div>
                                </div>
                                <div class="text-center py-2">
                                    <input type="submit" class="btn btn-primary b-btn mx-2">
                                    <button class="btn btn-secondary mx-3" data-dismiss="modal">Cancel</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
    <!--Reject modal-->
    <!--Revert to worker -->
            <div class="modal fade" id="revertback-modal" aria-hidden="true" tabindex="-1" role="dialog">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <!-- Modal Header -->
                        <div class="modal-header text-center d-block p-2 border-bottom-0">
                            <h4 class="modal-title">Revert Back Application</h4>
                            <button type="button" class="close position-absolute" style="right: 15px; top: 8px;"
                                data-dismiss="modal">&times;</button>
                        </div>
                        <!-- Modal body -->
                        <div class="modal-body">
                            <p class="text-center">Revert the application to the worker</p>
                            <form action="{{ route('application-revert') }}" method="POST">
                                @csrf
                                <div class="form-group">
                                    <div class="col-md-12">
                                        <input type="hidden" name="application_id" value="{{ $tfm->worker_id }}">
                                        <input type="hidden" name="revert_back" value="1">
                                        {{-- <label class="control-label bold col-md-8" for="office">Concerned Office:</label> --}}
                                        {{-- <select name="role_id" class="form-control" id="role_id" > --}}
                                        {{-- <option value="">--Select Role--</option> --}}
                                        {{-- @foreach ($pullDa as $users) --}}
                                        {{-- <option value="{{$users->role_id}}">{{$users->role_name}}</option> --}}
                                        {{-- @endforeach --}}
                                        {{-- </select> --}}
                                    </div>
                                    <div class="col-md-12 mt-2">
                                        <label class="control-label bold col-md-8" for="office">Remarks:</label>
                                        <input type="text" class="form-control" name="remarks" id="remarks">
                                    </div>
                                </div>
                                <div class="text-center py-2">
                                    <input type="submit" class="btn btn-primary b-btn mx-2">
                                    <button class="btn btn-secondary mx-3" data-dismiss="modal">Cancel</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
    <!--PullBack-->
    <!--forward to ro-->
            <div class="modal fade" id="pullback-modal" aria-hidden="true" tabindex="-1" role="dialog">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <!-- Modal Header -->
                        <div class="modal-header text-center d-block p-2 border-bottom-0">
                            <h4 class="modal-title">Pullback Application</h4>
                            <button type="button" class="close position-absolute" style="right: 15px; top: 8px;"
                                data-dismiss="modal">&times;</button>
                        </div>
                        <!-- Modal body -->
                        <div class="modal-body">
                            <p class="text-center"></p>
                            <form action="{{ route('application-pullback') }}" method="POST">
                                @csrf
                                <div class="form-group">
                                    <div class="col-md-12">
                                        <input type="hidden" name="application_id" value="{{ $tfm->worker_id }}">
                                        <input type="hidden" name="pull_back" value="1">
                                        <label class="control-label bold col-md-8" for="office">Concerned Office:</label>
                                        <select name="role_id" class="form-control" id="role_id">
                                            <option value="">--Select Role--</option>
                                            @foreach ($pullDa as $users)
                                                <option value="{{ $users->role_id }}">{{ $users->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-12 mt-2">
                                        <label class="control-label bold col-md-8" for="office">Remarks:</label>
                                        <input type="text" class="form-control" name="remarks" id="remarks">
                                    </div>
                                </div>
                                <div class="text-center py-2">
                                    <input type="submit" class="btn btn-primary b-btn mx-2">
                                    <button class="btn btn-secondary mx-3" data-dismiss="modal">Cancel</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal fade" id="reject-modal" aria-hidden="true" tabindex="-1" role="dialog">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">

                        <!-- Modal Header -->
                        <div class="modal-header text-center d-block p-2 border-bottom-0">
                            <h4 class="modal-title">Reject Application</h4>
                            <button type="button" class="close position-absolute" style="right: 15px; top: 8px;"
                                data-dismiss="modal">&times;</button>
                        </div>

                        <!-- Modal body -->
                        <div class="modal-body">

                            <form action="{{ route('reject_application') }}" method="POST">
                                @csrf
                                <div class="form-group">
                                    <label class="control-label bold col-md-8" for="office">Remarks:</label>
                                    <div class="col-md-12 mt-2">
                                        <input type="hidden" name="application_id" value="{{ $tfm->worker_id }}">
                                        <input type="text" class="form-control" name="remarks" id="remarks">
                                    </div>
                                </div>
                                <div class="text-center py-2">
                                    <input type="submit" class="btn btn-primary b-btn mx-2">
                                    <button class="btn btn-secondary mx-3" data-dismiss="modal">Cancel</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
    </div>
</body>

@include('layout.footer')
