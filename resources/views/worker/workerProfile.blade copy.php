@include('layout.workerheader')

<link href="{{ URL::asset('assets/template/css/font-google.css') }}" rel="stylesheet">
<link rel="stylesheet" href="{{ URL::asset('assets/template/flatpickr/flatpickr.min.css') }}">
<script src="{{ URL::asset('assets/template/flatpickr/flatpickr.min.js') }}"></script>
<style>
    body {
        font-family: 'Inter', sans-serif;
        background-color: #f4f7fa;
    }

    /* Professional Card Styling */
    .content-card {
        background: #ffffff;
        border: none;
        border-radius: 10px;
        box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
        padding: 2rem;
        margin-bottom: 2rem;
    }

    .section-title {
        font-weight: 700;
        color: #1e293b;
        font-size: 1.1rem;
        border-left: 4px solid #0d6efd;
        padding-left: 12px;
        margin-bottom: 1.5rem;
    }

    /* Government-style Tab Design */
    .custom-tabs {
        border-bottom: 2px solid #e2e8f0;
        gap: 5px;
    }

    .custom-tabs .nav-link {
        border: none;
        color: #64748b;
        font-weight: 500;
        padding: 10px 24px;
        border-radius: 8px 8px 0 0;
        transition: all 0.2s;
    }

    .custom-tabs .nav-link:hover {
        background-color: #f1f5f9;
        color: #0d6efd;
    }

    .custom-tabs .nav-link.active {
        color: #0d6efd !important;
        background: white !important;
        border-bottom: 3px solid #0d6efd !important;
    }

    /* Form Design */
    .bold {
        font-weight: 600;
        font-size: 0.85rem;
        color: #475569;
        margin-bottom: 0.5rem;
        display: block;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .form-control:disabled,
    .form-control[readonly] {
        background-color: #f8fafc;
        border-color: #e2e8f0;
        color: #1e293b;
        opacity: 1;
        cursor: not-allowed;
    }

    .form-control,
    .form-select {
        border: 1px solid #cbd5e1;
        padding: 0.6rem 0.75rem;
        font-size: 0.9rem;
    }

    .form-control:focus {
        box-shadow: 0 0 0 3px rgba(13, 110, 253, 0.15);
        border-color: #0d6efd;
    }

    /* Table Styling */
    .table-container {
        border-radius: 8px;
        overflow: hidden;
        border: 1px solid #e2e8f0;
    }

    .table thead {
        background-color: #1e293b;
        color: #ffffff;
    }

    .table thead th {
        font-weight: 500;
        font-size: 0.8rem;
        text-transform: uppercase;
        padding: 12px;
        border: none;
    }

    .table tbody td {
        padding: 10px;
        vertical-align: middle;
        font-size: 0.85rem;
    }

    .btn-update {
        background-color: #0d6efd;
        color: white;
        border: none;
        padding: 10px 24px;
        font-weight: 600;
        border-radius: 6px;
        transition: 0.3s;
    }

    .btn-update:hover {
        background-color: #0a58ca;
        box-shadow: 0 4px 12px rgba(13, 110, 253, 0.2);
    }

    .copy-address-box {
        background: #f0f7ff;
        padding: 15px;
        border-radius: 8px;
        border: 1px dashed #0d6efd;
    }

    #page-content-wrapper {
        background: #f4f7fa;
    }

</style>

<!--Bootstrap CSS-->
<link href="{{ URL::asset('assets/template/css/dist-bootstrap.min.css') }}" rel="stylesheet">
<!--Fontawesome-->
<link href="{{ URL::asset('assets/template/css/all-min.css') }}" rel="stylesheet">

<body>
    <div class="d-flex" id="wrapper">
        @include('worker.leftmenu')

        <div id="page-content-wrapper">
            @include('components.worker.ui.navbar')
            <!-- Top Navigation -->
            <nav class="navbar navbar-expand-lg navbar-light border-bottom px-3">
                <button class="btn btn-light border" id="menu-toggle">
                    <span class="fas fa-bars"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav ms-auto mt-2 mt-lg-0">
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle fw-bold text-dark" href="#" id="navbarDropdown"
                                role="button" data-bs-toggle="dropdown">
                                <i class="fas fa-user-circle me-1"></i> My Account
                            </a>
                            <div class="dropdown-menu dropdown-menu-end shadow border-0">
                                <a class="dropdown-item" href="#"><i class="fas fa-user me-2"></i>Profile</a>
                                <a class="dropdown-item" href="#"><i class="fas fa-key me-2"></i>Password</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item text-danger" href="javascript:void(0);" data-bs-toggle="modal"
                                    data-bs-target="#signout-modal"><i class="fas fa-sign-out-alt me-2"></i>Sign Out</a>
                            </div>
                        </li>
                    </ul>
                </div>
            </nav>

            <div class="container-fluid px-4 py-4">
                <div class="mb-4">
                    <h3 class="fw-bold text-dark mb-1">User Profile</h3>
                    <p class="text-muted small">Manage your registration details and family information</p>
                </div>

                <!-- Tabs -->
                <nav class="mb-4">
                    <div class="nav nav-tabs custom-tabs" id="nav-tab" role="tablist">
                        <button class="nav-link active" id="nav-home-tab" data-bs-toggle="tab"
                            data-bs-target="#nav-home" type="button" role="tab">
                            <i class="fas fa-info-circle me-2"></i>Basic & Address Details
                        </button>
                        <button class="nav-link" id="nav-profile-tab" data-bs-toggle="tab" data-bs-target="#nav-profile"
                            type="button" role="tab">
                            <i class="fas fa-users me-2"></i>Family Details
                        </button>
                    </div>
                </nav>

                <div class="tab-content" id="nav-tabContent">
                    <!-- Tab 1: Basic & Address -->
                    <div class="tab-pane fade show active" id="nav-home" role="tabpanel">

                        <div class="content-card">
                            <h5 class="section-title">Registration Details</h5>
                            <div class="row g-3">
                                <div class="col-md-4">
                                    <label class="bold">Registration Number</label>
                                    <input type="text" class="form-control" value="{{ $wrkr->worker_id }}" disabled>
                                </div>
                                <div class="col-md-4">
                                    <label class="bold">Full Name <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" value="{{ $getVaultData['name'] }}"
                                        disabled>
                                </div>
                                <div class="col-md-4">
                                    <label class="bold">Phone Number</label>
                                    <input type="text" class="form-control" value="{{ $user->phone_no }}" disabled>
                                </div>
                                <div class="col-md-4">
                                    <label class="bold">Date Of Birth</label>
                                    <input type="text" class="form-control" value="{{ $getVaultData['dob'] }}"
                                        disabled>
                                </div>
                                <div class="col-md-4">
                                    <label class="bold">Gender</label>
                                    <input type="text" class="form-control"
                                        value="{{ $getVaultData['gender'] == 'M' ? 'Male' : ($getVaultData['gender'] == 'F' ? 'Female' : 'Others') }}"
                                        disabled>
                                </div>
                                <div class="col-md-4">
                                    <label class="bold">Category</label>
                                    <input type="text" class="form-control" value="{{ $user->category_name }}"
                                        disabled>
                                </div>
                                @if ($user->pan == 1)
                                    <div class="col-md-4">
                                        <label class="bold">PAN Number</label>
                                        <input type="text" class="form-control" value="{{ $user->pan_no }}"
                                            disabled>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <div class="content-card">
                            <h5 class="section-title">Permanent Address (Locked)</h5>
                            <p class="text-muted small mt-n2 mb-3"><i class="fas fa-lock me-1"></i> Linked with
                                Aadhaar records</p>
                            <div class="row g-3">
                                <div class="col-md-3">
                                    <label class="bold">District</label>
                                    <input type="text" class="form-control"
                                        value="{{ $getVaultData['district'] ?: 'NA' }}" readonly>
                                </div>
                                <div class="col-md-3">
                                    <label class="bold">Subdistrict</label>
                                    <input type="text" class="form-control"
                                        value="{{ $getVaultData['subDistrict'] ?: 'NA' }}" readonly>
                                </div>
                                <div class="col-md-3">
                                    <label class="bold">Post Office</label>
                                    <input type="text" class="form-control"
                                        value="{{ $getVaultData['postOffice'] ?: 'NA' }}" readonly>
                                </div>
                                <div class="col-md-3">
                                    <label class="bold">Pin Code</label>
                                    <input type="text" class="form-control"
                                        value="{{ $getVaultData['pinCode'] ?: 'NA' }}" readonly>
                                </div>
                                <div class="col-md-4">
                                    <label class="bold">Village/Area</label>
                                    <input type="text" class="form-control"
                                        value="{{ $getVaultData['village'] ?: 'NA' }}" readonly>
                                </div>
                                <div class="col-md-4">
                                    <label class="bold">Street/Locality</label>
                                    <input type="text" class="form-control"
                                        value="{{ $getVaultData['street'] ?: 'NA' }}" readonly>
                                </div>
                                <div class="col-md-4">
                                    <label class="bold">Landmark</label>
                                    <input type="text" class="form-control"
                                        value="{{ $getVaultData['landMark'] ?: 'NA' }}" readonly>
                                </div>
                            </div>

                            <div class="copy-address-box mt-4">
                                <div class="form-check d-flex align-items-center">
                                    <input type="checkbox" name="do" value="1"
                                        class="form-check-input me-3" style="width:20px; height:20px;"
                                        {{ $add->do == 1 ? 'checked' : '' }}>
                                    <label class="form-check-label fw-bold text-primary mb-0">
                                        Use Permanent Address as Current Address
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="content-card">
                            <h5 class="section-title">Current Address Details</h5>
                            <form action="{{ route('update-current-address') }}" method="POST">
                                @csrf
                                <div class="row g-3">
                                    <div class="col-md-3">
                                        <label class="bold">Residence Type <span
                                                class="text-danger">*</span></label>
                                        <select class="form-select" name="c_residence">
                                            <option value="{{ $add->c_residence }}">{{ $add->residence_name }}
                                            </option>
                                            @foreach ($residence as $res)
                                                <option value="{{ $res->residence_code }}">{{ $res->residence_name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <label class="bold">House Type <span class="text-danger">*</span></label>
                                        <select class="form-select" name="c_house_type">
                                            <option value="{{ $add->c_house_type }}">{{ $add->house_type }}</option>
                                            @foreach ($house as $hs)
                                                <option value="{{ $hs->house_code }}">{{ $hs->house_type }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <label class="bold">House/Building No</label>
                                        <input type="text" class="form-control" name="c_house_no"
                                            value="{{ $add->c_house_no }}">
                                    </div>
                                    <div class="col-md-3">
                                        <label class="bold">Village/Area <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="c_area"
                                            value="{{ $add->c_area }}">
                                    </div>
                                    <div class="col-md-3">
                                        <label class="bold">Locality <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="c_city"
                                            value="{{ $add->c_city }}">
                                    </div>
                                    <div class="col-md-3">
                                        <label class="bold">Road/Street</label>
                                        <input type="text" class="form-control" name="c_road"
                                            value="{{ $add->c_road }}">
                                    </div>
                                    <div class="col-md-3">
                                        <label class="bold">State <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="c_state"
                                            value="{{ $add->c_state }}">
                                    </div>
                                    <div class="col-md-3">
                                        <label class="bold">District</label>
                                        <input type="text" class="form-control" name="c_district"
                                            value="{{ $add->c_district }}">
                                    </div>
                                    <div class="col-md-3">
                                        <label class="bold">Revenue Circle</label>
                                        <input type="text" class="form-control" name="c_circle"
                                            value="{{ $add->c_circle }}">
                                    </div>
                                    <div class="col-md-3">
                                        <label class="bold">Post Office <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="c_post_office"
                                            value="{{ $add->c_post_office }}">
                                    </div>
                                    <div class="col-md-3">
                                        <label class="bold">Pin Code</label>
                                        <input type="text" class="form-control" name="c_pin"
                                            value="{{ $add->c_pin }}" maxlength="6">
                                    </div>
                                    <div class="col-md-3">
                                        <label class="bold">Landmark</label>
                                        <input type="text" class="form-control" name="landmark"
                                            value="{{ $add->landmark }}">
                                    </div>
                                </div>
                                <div class="mt-4">
                                    <button type="submit" class="btn btn-update btn-primary">
                                        <i class="fas fa-save me-2"></i> Update Current Address
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Tab 2: Family Details -->
                    <style>
                        /* Professional Typography & Background */
                        body {
                            font-family: 'Inter', -apple-system, sans-serif;
                            background-color: #f8fafc;
                        }

                        /* Family Details Table Specifics */
                        .family-table-card {
                            background: #ffffff;
                            border-radius: 12px;
                            border: 1px solid #e2e8f0;
                            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
                            padding: 24px;
                        }

                        .table-responsive-custom {
                            border-radius: 8px;
                            border: 1px solid #e2e8f0;
                            overflow-x: auto;
                        }

                        .table-govt {
                            margin-bottom: 0;
                            min-width: 1800px;
                            /* Forces enough width for all large inputs */
                        }

                        .table-govt thead th {
                            background-color: #1e293b;
                            /* Sleek Navy/Slate */
                            color: #ffffff;
                            font-weight: 600;
                            font-size: 0.75rem;
                            text-transform: uppercase;
                            letter-spacing: 0.05em;
                            padding: 16px 12px;
                            border: none;
                            vertical-align: middle;
                        }

                        .table-govt tbody td {
                            padding: 12px;
                            vertical-align: middle;
                            background-color: #ffffff;
                            border-bottom: 1px solid #f1f5f9;
                        }

                        /* Column Width Management */
                        .col-sr {
                            width: 50px;
                            text-align: center;
                        }

                        .col-large {
                            width: 220px;
                        }

                        /* For Names & IDs */
                        .col-medium {
                            width: 180px;
                        }

                        /* For Relations & Dates */
                        .col-small {
                            width: 120px;
                        }

                        /* For Dropdowns & Share % */

                        /* Form Element Refinement */
                        .table-govt .form-control,
                        .table-govt .form-select {
                            border: 1px solid #cbd5e1;
                            font-size: 0.9rem;
                            padding: 0.6rem;
                            border-radius: 6px;
                            transition: all 0.2s;
                        }

                        .table-govt .form-control:focus,
                        .table-govt .form-select:focus {
                            border-color: #0d6efd;
                            box-shadow: 0 0 0 3px rgba(13, 110, 253, 0.1);
                            outline: none;
                        }

                        .table-govt .form-control[readonly] {
                            background-color: #f8fafc;
                            color: #64748b;
                        }

                        /* Buttons */
                        .btn-add-member {
                            background-color: #ffffff;
                            color: #0d6efd;
                            border: 2px dashed #cbd5e1;
                            padding: 12px;
                            width: 100%;
                            font-weight: 600;
                            border-radius: 8px;
                            transition: 0.3s;
                        }

                        .btn-add-member:hover {
                            background-color: #f0f7ff;
                            border-color: #0d6efd;
                        }

                        .btn-save-all {
                            background-color: #1e293b;
                            color: white;
                            padding: 12px 30px;
                            border-radius: 8px;
                            font-weight: 600;
                            border: none;
                        }

                        .btn-save-all:hover {
                            background-color: #0f172a;
                            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
                        }
                    </style>

                    <!-- Family Details Tab Content -->
                    <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
                        <div class="family-table-card">
                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <div>
                                    <h5 class="fw-bold text-dark mb-1">Family & Nominee Details</h5>
                                    <p class="text-muted small mb-0"><i class="fas fa-info-circle me-1"></i> Add
                                        family members and assign nominee shares.</p>
                                </div>
                                <span class="badge bg-light text-dark border p-2">Total Members:
                                    {{ count($wfd) }}</span>
                            </div>

                            <form method="post" id="dynamic_field"
                                action="{{ route('update-profile-family-details') }}">
                                @csrf
                                <div class="table-responsive-custom">
                                    <table class="table table-govt">
                                        <thead>
                                            <tr>
                                                <th class="col-sr">#</th>
                                                <th class="col-large">First Name <span class="text-warning">*</span>
                                                </th>
                                                <th class="col-large">Last Name <span class="text-warning">*</span>
                                                </th>
                                                <th class="col-medium">Date of Birth <span
                                                        class="text-warning">*</span></th>
                                                <th class="col-large">Guardian Name</th>
                                                <th class="col-medium">Relation <span class="text-warning">*</span>
                                                </th>
                                                <th class="col-small">Nominee?</th>
                                                <th class="col-small">Share %</th>
                                                <th class="col-small">Registered?</th>
                                                <th class="col-medium">State</th>
                                                <th class="col-large">BOCW ID</th>
                                                <th style="width: 80px;" class="text-center">Remove</th>
                                            </tr>
                                        </thead>
                                        <tbody id="tableBody">
                                            @foreach ($wfd as $key => $familyMember)
                                                <tr
                                                    data-rowid="{{ $familyMember->family_db_id ?? $familyMember->id }}">
                                                    <td class="text-center fw-bold text-muted">
                                                        <input type="hidden" name="family_id[{{ $key }}]"
                                                            value="{{ $familyMember->family_db_id ?? $familyMember->id }}">
                                                        {{ $key + 1 }}
                                                    </td>
                                                    <td><input type="text" name="first_name[{{ $key }}]"
                                                            value="{{ $familyMember->first_name }}"
                                                            class="form-control" placeholder="Enter first name"></td>
                                                    <td><input type="text" name="last_name[{{ $key }}]"
                                                            value="{{ $familyMember->last_name }}"
                                                            class="form-control" placeholder="Enter last name"></td>




                                                    <td>

                                                        <input type="text" id="dob_{{ $key }}"
                                                            name="dob[{{ $key }}]"
                                                            class="form-control birthdate white-background"
                                                            placeholder="DD-MM-YYYY" onkeydown="return false;"
                                                            onchange="calculateAge(this)"
                                                            value="{{ \Carbon\Carbon::parse($familyMember->dob)->format('d-m-Y') }}" />
                                                    </td>




                                                    <td>
                                                        @php
                                                            $age = \Carbon\Carbon::parse($familyMember->dob)->age;
                                                        @endphp
                                                        <input type="text"
                                                            name="guardain_name[{{ $key }}]"
                                                            value="{{ $familyMember->guardain_name }}"
                                                            class="form-control"
                                                            placeholder="{{ $age < 18 ? 'Guardian name (required)' : '' }}"
                                                            {{ $age >= 18 ? 'readonly' : '' }}>
                                                    </td>
                                                    <td>
                                                        <select name="relation[{{ $key }}]"
                                                            class="form-select">
                                                            <option value="{{ $familyMember->relation }}">
                                                                {{ $familyMember->relation_name }}</option>
                                                            @foreach ($relations as $relation)
                                                                <option value="{{ $relation->relation_code }}">
                                                                    {{ $relation->relation_name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </td>
                                                    <td>
                                                        <select name="nominee[{{ $key }}]"
                                                            class="form-select"
                                                            onchange="togglePercentageInput({{ $key }})">
                                                            <option value="0"
                                                                {{ $familyMember->nominee == 0 ? 'selected' : '' }}>No
                                                            </option>
                                                            <option value="1"
                                                                {{ $familyMember->nominee == 1 ? 'selected' : '' }}>Yes
                                                            </option>
                                                        </select>
                                                    </td>
                                                    <td><input type="text"
                                                            name="nominee_percentage[{{ $key }}]"
                                                            class="form-control text-center"
                                                            value="{{ $familyMember->nominee_percentage }}"
                                                            {{ $familyMember->nominee == 0 ? 'readonly' : '' }}
                                                            placeholder="0"></td>
                                                    <td>
                                                        <select name="already_registered[{{ $key }}]"
                                                            class="form-select"
                                                            id="already_registered_{{ $key }}"
                                                            onchange="toggleBocwwbInput({{ $key }})">
                                                            <option value="0"
                                                                {{ (int) $familyMember->already_registered === 0 ? 'selected' : '' }}>
                                                                No</option>
                                                            <option value="1"
                                                                {{ (int) $familyMember->already_registered === 1 ? 'selected' : '' }}>
                                                                Yes</option>
                                                        </select>
                                                    </td>
                                                    <td id="state_td_{{ $key }}">
                                                        @if ((int) $familyMember->already_registered === 1)
                                                            <select
                                                                name="already_registered_state[{{ $key }}]"
                                                                class="form-select">
                                                                <option
                                                                    value="{{ $familyMember->already_registered_state }}">
                                                                    {{ $familyMember->state_name ?? 'Select State' }}
                                                                </option>
                                                                @foreach ($states as $state)
                                                                    <option value="{{ $state->state_code }}">
                                                                        {{ $state->state_name }}</option>
                                                                @endforeach
                                                            </select>
                                                        @else
                                                            <input type="text"
                                                                class="form-control text-center text-muted bg-light"
                                                                value="NA" readonly>
                                                        @endif
                                                    </td>
                                                    <td><input type="text" name="bocwwb_id[{{ $key }}]"
                                                            class="form-control"
                                                            value="{{ $familyMember->bocwwb_id }}"
                                                            placeholder="Enter BOCW ID"
                                                            {{ $familyMember->already_registered == '0' ? 'readonly' : '' }}>
                                                    </td>
                                                    <td class="text-center">
                                                        <button type="button"
                                                            class="btn btn-outline-danger btn-sm border-0"
                                                            onclick="removeRow({{ $key }})">
                                                            <i class="fas fa-trash-alt"></i>
                                                        </button>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>

                                <button type="button" onclick="addNewRow(event)" class="btn btn-add-member mt-3">
                                    <i class="fas fa-plus-circle me-2"></i> Add Another Family Member
                                </button>

                                <div class="mt-5 border-top pt-4 text-end">
                                    <button type="submit" class="btn btn-save-all">
                                        <i class="fas fa-save me-2"></i> Save Family Details
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Sign Out Modal -->
    <div class="modal fade" id="signout-modal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow">
                <div class="modal-body p-5 text-center">
                    <div class="mb-4">
                        <i class="fas fa-exclamation-circle text-warning" style="font-size: 3rem;"></i>
                    </div>
                    <h4 class="fw-bold">Sign Out?</h4>
                    <p class="text-muted">Are you sure you want to end your session?</p>
                    <div class="mt-4">
                        <form action="{{ route('user-logout') }}" method="post" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-danger px-4 me-2">Yes, Sign Out</button>
                        </form>
                        <button class="btn btn-light px-4 border" data-bs-dismiss="modal">Cancel</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Success Modal -->
    <div class="modal fade" id="successModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-success text-white">
                    <h5 class="modal-title"><i class="fas fa-check-circle me-2"></i>Success</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body py-4">
                    @if ($message = Session::get('success'))
                        <p class="mb-0 fw-bold">{{ $message }}</p>
                    @endif
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <script src="{{ URL::asset('assets/template/js/jquery.min.js') }}"></script>
    <script src="{{ URL::asset('assets/template/js/bootstrap.bundle.min.js') }}"></script>

   <script>
    // ✅ Now safely runs after DOM + libraries are ready
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('input[name^="dob["]').forEach(function(el) {
            flatpickr(el, {
                dateFormat: "d-m-Y",
                maxDate: new Date(),
                defaultDate: el.value || null
            });
        });
    });
</script>
    <script>
        @if ($message = Session::get('success'))
            $(document).ready(function() {
                var myModal = new bootstrap.Modal(document.getElementById('successModal'));
                myModal.show();
            });
        @endif


        $(document).ready(function() {
            window.addNewRow = function(event) {
                event.preventDefault();
                let rowCount = $('#tableBody tr').length;
                let newRow = `
                <tr data-rowid="">
                    <td class="text-center fw-bold">${rowCount + 1}</td>
                    <td><input type="text" name="first_name[${rowCount}]" class="form-control" /> <span class="text-danger success"  id="first_name.${rowCount}_error"></span></td>
                    <td><input type="text" name="last_name[${rowCount}]" class="form-control" /><span class="text-danger success"  id="last_name.${rowCount}_error"></td>
                    <td><input type="text" name="dob[${rowCount}]" class="form-control birthdate white-background" placeholder="DD-MM-YYYY"
                onkeydown="return false;" max="{{ date('Y-m-d') }}" onchange="calculateAge(this)" /><span class="text-danger success"  id="dob.${rowCount}_error"></td>
                    <td><input type="text" name="guardain_name[${rowCount}]" class="form-control" /><span class="text-danger success"  id="guardain_name.${rowCount}_error"></td>
                    <td>
                        <select name="relation[${rowCount}]" class="form-select">
                            <option value="">Select Relation</option>
                            @foreach ($relations as $relation)
                <option value="{{ $relation->relation_code }}">{{ $relation->relation_name }}</option>
                            @endforeach
                </select>
                <span class="text-danger success"  id="relation.${rowCount}_error">
                    </td>
                    <td>
                        <select name="nominee[${rowCount}]" class="form-select nominee-input" onchange="togglePercentageInput(${rowCount})">
                            <option value="0">No</option>
                            <option value="1">Yes</option>
                        </select>
                    </td>
                    <td><input type="text" name="nominee_percentage[${rowCount}]" class="form-control percentage-input" readonly /></td>
                    <td>
                        <select name="already_registered[${rowCount}]" class="form-select register-input" onchange="toggleBocwwbInput(${rowCount})">
                            <option value="0">No</option>
                            <option value="1">Yes</option>
                        </select>
                    </td>
                    <td id="state_td_${rowCount}">
                        <input type="text" class="form-control text-center text-muted" value="NA" readonly>
                    </td>
                    <td><input type="text" name="bocwwb_id[${rowCount}]" class="form-control bocwwb-input" readonly /></td>
                    <td class="text-center"><button type="button" class="btn btn-outline-danger btn-sm border-0 remove"><i class="fas fa-trash-alt"></i></button></td>
                </tr>`;
                $('#tableBody').append(newRow);
                flatpickr(`input[name="dob[${rowCount}]"]`, {
                    dateFormat: "d-m-Y",
                    maxDate: new Date()
                });
            };

            $(document).on('click', '.remove', function() {
                $(this).closest('tr').remove();
                $('#tableBody tr').each(function(index) {
                    $(this).find('td:first').text(index + 1);
                });
            });

        });
    </script>


    <script>

        window.togglePercentageInput = function(key) {
            let nomineeInput = $(`select[name="nominee[${key}]"]`);
            let percentageInput = $(`input[name="nominee_percentage[${key}]"]`);
            if (nomineeInput.val() == 1) {
                percentageInput.removeAttr('readonly');
            } else {
                percentageInput.val('').attr('readonly', true);
            }
        };

        const states = @json($states);
        window.toggleBocwwbInput = function(row) {
            let registerValue = $(`select[name="already_registered[${row}]"]`).val();
            let bocwInput = $(`input[name="bocwwb_id[${row}]"]`);
            let stateTd = $(`#state_td_${row}`);
            if (registerValue === "1") {
                bocwInput.prop('readonly', false);
                let selectHtml = `<select name="already_registered_state[${row}]" class="form-select">`;
                selectHtml += `<option value="">Select State</option>`;
                states.forEach(state => {
                    selectHtml += `<option value="${state.state_code}">${state.state_name}</option>`;
                });
                selectHtml += `</select>`;
                stateTd.html(selectHtml);
            } else {
                bocwInput.val('').prop('readonly', true);
                stateTd.html(`<input type="text" class="form-control text-center text-muted" value="NA" readonly>`);
            }
        };

        $('#dynamic_field').submit(function(event) {
            event.preventDefault();
            let formData = new FormData(this);
            $.ajax({
                url: $(this).attr('action'),
                method: $(this).attr('method'),
                data: formData,
                contentType: false,
                processData: false,
                success: function(response) {
                    if (response.status === 'success') {
                        window.location.href = response.redirect_url;
                    } else {
                        console.warn('Save family returned non-success response', response);
                        if (response.errors) console.warn(response.errors);
                        alert('Failed to save family details. Check validation messages.');
                    }
                },
                error: function(xhr, status, error) {
                    console.error('AJAX error saving family details:', status, error);
                    try {
                        console.error('Response text:', xhr.responseText);
                    } catch (e) {}
                    try {
                        console.error('Response JSON:', xhr.responseJSON);
                    } catch (e) {}
                    alert('An error occurred while saving family details (see console).');
                }
            });
        });
    </script>

    <script>
        window.calculateAge = function(dobInput) {
            const row = dobInput.closest('tr');
            const guardianInput = row.querySelector('input[name^="guardain_name"]');
            if (!guardianInput) return;

            const parts = dobInput.value.split("-");
            if (parts.length !== 3) return;

            // ✅ Correctly reconstruct: DD-MM-YYYY → new Date(YYYY, MM-1, DD)
            const dob = new Date(parseInt(parts[2]), parseInt(parts[1]) - 1, parseInt(parts[0]));
            if (isNaN(dob)) return;

            const today = new Date();
            let age = today.getFullYear() - dob.getFullYear();
            const m = today.getMonth() - dob.getMonth();
            if (m < 0 || (m === 0 && today.getDate() < dob.getDate())) age--;

            if (age < 18) {
                guardianInput.removeAttribute('readonly');
                guardianInput.removeAttribute('disabled');
                guardianInput.placeholder = 'Guardian name (required)';
            } else {

                guardianInput.setAttribute('readonly', true);

            }
        };
    </script>



</body>

{{-- @include('layout.footer') --}}
@include('components.footer')

</html>
