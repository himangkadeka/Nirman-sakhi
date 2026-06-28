<div class="dashboard-bgcolor border-right border-bottom" id="sidebar-wrapper">
    <div class="sidebar-heading text-center b-db-color" style="font-size: 20px">
        <span class="fas fa-tachometer-alt"></span> &nbsp;<span>{{ Auth::user()->username }}</span>
    </div>
    {{--    <div class="sidebar-heading border-bottom text-center b-db-color" style="font-size: 14px"> --}}
    {{--        @if (Auth::check() && Auth::user()->role_id == 1) --}}
    {{--        @elseif(Auth::check() && Auth::user()->role_id == 2) --}}
    {{--            <span class="text-white">{{ Auth::user()->office->office_name }}</span> --}}
    {{--        @elseif(Auth::check() && Auth::user()->role_id == 3) --}}
    {{--            <span class="text-white">{{ Auth::user()->office->office_name }}</span> --}}
    {{--        @elseif(Auth::check() && Auth::user()->role_id == 4) --}}
    {{--            <span class="text-white">{{ Auth::user()->office->office_name }}</span> --}}
    {{--        @elseif(Auth::check() && Auth::user()->role_id == 5) --}}
    {{--            <span class="text-white">{{ Auth::user()->office->office_name }}</span> --}}

    {{--        @endif --}}
    {{--    </div> --}}
    <div class="list-group list-group-flush b-leftmenu">
        @if (Auth::check())

            <ul id="sortable-menu">
                @can('admin dashboard')
                    <li><a href="{{ route('admin.dashboard.index') }}"
                            class="dashboard-bgcolor b-db-color border-bottom b-newpage {{ Route::currentRouteName() == 'admin.dashboard.index' ? 'active' : '' }}">Dashboard</a>
                    </li>
                @endcan
                @can('office dashboard')
                    @if (Auth::user()->role_id == 7)
                        <li><a href="{{ route('office.head-office.dashboard.index') }}"
                                class="dashboard-bgcolor b-db-color border-bottom b-newpage">Dashboard</a></li>
                    @elseif(Auth::user()->role_id == 12)
                        <li><a href="{{ route('office.head-office-da.dashboard.index') }}"
                                class="dashboard-bgcolor b-db-color border-bottom b-newpage">Dashboard</a></li>
                        {{-- @elseif (Auth::user()->role_id != 7 || Auth::user()->role_id != 12)
                     --}}
                    @elseif(Auth::user()->role_id == 14)
                        <li><a href="{{ route('office.accounts.dashboard.index') }}"
                                class="dashboard-bgcolor b-db-color border-bottom b-newpage">Dashboard</a></li>
                    @else
                        <li><a href="{{ route('office.dashboard.index') }}"
                                class="dashboard-bgcolor b-db-color border-bottom b-newpage">Dashboard</a></li>
                        <li>
                            <a href="{{ route('office.dashboard.benefit.report') }}"
                                class="dashboard-bgcolor b-db-color border-bottom b-newpage">Benefit Dashboard</a>
                        </li>
                    @endif
                @endcan

                @can('view application list')
                    @php
                        $isChildActive = in_array(request()->route('status'), [
                            'totalreceived',
                            'forwardedByDa',
                            'reverted',
                            'forwarded',
                            'approved',
                            'pulledback',
                        ]);
                    @endphp

                        <li class='sub-menu {{ $isChildActive ? "active" : "" }}'>
                            <a href='javascript:void(0)'
                               class="dashboard-bgcolor border-bottom b-db-color b-newpage {{ $isChildActive ? "active" : "" }}">New Applications
                                <div class='fa fa-caret-down right'></div>
                            </a>
                            <ul>
                            @can('view total received application')
                                <li>
                                    <a class="b-newpage {{ request()->route('status') == 'totalreceived' ? 'active' : '' }}"
                                        href="{{ route('office.applications.index', 'totalreceived') }}">
                                        Total Application Received
                                    </a>
                                </li>
                            @endcan
                            @can('view forwardedbyda application')
                                <li><a class="b-newpage {{ request()->route('status') == 'forwardedByDa' ? 'active' : '' }}"
                                        href="{{ route('office.applications.index', 'forwardedByDa') }}">Application
                                        Reviewed</a>
                                </li>
                            @endcan
                            @can('view reverted application')
                                <li><a class="b-newpage {{ request()->route('status') == 'reverted' ? 'active' : '' }}"
                                        href="{{ route('office.applications.index', 'reverted') }}">Application
                                        Reverted</a>
                                </li>
                            @endcan
                            @can('view forwarded application')
                                <li><a class="b-newpage {{ request()->route('status') == 'forwarded' ? 'active' : '' }}"
                                        href="{{ route('office.applications.index', 'forwarded') }}">Application
                                        Forwarded</a></li>
                            @endcan
                            @can('view approved application')
                                <li><a class="b-newpage {{ request()->route('status') == 'approved' ? 'active' : '' }}"
                                        href="{{ route('office.applications.index', 'approved') }}">Application
                                        Approved</a></li>
                            @endcan
                            @can('view pull back application')
                                <li><a class="b-newpage {{ request()->route('status') == 'pulledback' ? 'active' : '' }}"
                                        href="{{ route('office.applications.index', 'pulledback') }}">Application
                                        Pulled Back</a></li>
                            @endcan




                        </ul>
                    </li>
                @endcan

                    @can('view application list')
                        @php
                            $isChildActive1 = in_array(request()->route('status'), [
                                'receivedRenewal','forwardedByDaRenewal','revertedBackRenewal','approvedRenewal','pendingReviewRenewal',
                                'UnderDocumentVerificationRenewal','UnderDocumentVerificationRo','VerifiedByDaRo','UnderDocumentVerificationRo',
                                'reverted by ro','PendingDocumentVerificationQueue','VerifiedApplicationsHistory','RevertedtoApplicantByRo','application history da'
                                ,'verifiedByDaRenewal'

                            ]);
                        @endphp
                        <li class='sub-menu {{ $isChildActive1 ? "active" : "" }}'>
                            <a href='javascript:void(0)'
                               class="dashboard-bgcolor border-bottom b-db-color b-newpage {{ $isChildActive1 ? "active" : "" }}">
                                Renewal Applications
                                <div class='fa fa-caret-down right'></div>
                            </a>
                            <ul>
                                @can('pendingReviewRenewal')
                                    <li>
                                        <a class="b-newpage {{ request()->route('status') == 'pendingReviewRenewal' ? 'active' : '' }}" href="{{ route('office.applications-renewal.index', 'pendingReviewRenewal') }}">Pending Review</a>
                                    </li>
                                @endcan
                                @can('forwardedByDaRenewal')
                                    <li><a class="b-newpage {{ request()->route('status') == 'forwardedByDaRenewal' ? 'active' : '' }}"
                                           href="{{ route('office.applications-renewal.index', 'forwardedByDaRenewal') }}">Verified by DA</a>
                                    </li>
                                @endcan
                                    @can('verifiedByDaRenewal')
                                        <li><a class="b-newpage {{ request()->route('status') == 'verifiedByDaRenewal' ? 'active' : '' }}"
                                               href="{{ route('office.applications-renewal.index', 'verifiedByDaRenewal') }}">Verified by DA</a>
                                        </li>
                                    @endcan
                                    @can('UnderDocumentVerificationRenewal')
                                        <li><a class="b-newpage {{ request()->route('status') == 'UnderDocumentVerificationRenewal' ? 'active' : '' }}"
                                               href="{{ route('office.applications-renewal.index', 'UnderDocumentVerificationRenewal') }}">Under Document Review</a>
                                        </li>
                                    @endcan

                            @can('view total approved renewal application')
                                <li><a class="b-newpage {{ request()->route('status') == 'approvedRenewal' ? 'active' : '' }}"
                                        href="{{ route('office.applications-renewal.index', 'approvedRenewal') }}">
                                        Approved</a></li>
                            @endcan
                            <!--RO Tab -->
                            @can('view ro review pending queue')
                                <li><a class="b-newpage {{ request()->route('status') == 'RoReviewQueue' ? 'active' : '' }}"
                                        href="{{ route('office.applications-renewal.index', 'RoReviewQueue') }}">
                                        Pending Review Queue</a></li>
                            @endcan

                            @can('view ro verified by da')
                                <li><a class="b-newpage {{ request()->route('status') == 'VerifiedByDaRo' ? 'active' : '' }}"
                                        href="{{ route('office.applications-renewal.index', 'VerifiedByDaRo') }}">
                                        Verified by DA</a></li>
                            @endcan

                            @can('under document verification ro da')
                                <li><a class="b-newpage {{ request()->route('status') == 'UnderDocumentVerificationRo' ? 'active' : '' }}"
                                        href="{{ route('office.applications-renewal.index', 'UnderDocumentVerificationRo') }}">
                                        Under Document Verification</a></li>
                            @endcan
                            @can('reverted by ro')
                                <li><a class="b-newpage {{ request()->route('status') == 'RevertedtoApplicantByRo' ? 'active' : '' }}"
                                        href="{{ route('office.applications-renewal.index', 'RevertedtoApplicantByRo') }}">
                                        Reverted to Applicant</a></li>
                            @endcan

                            <!-- DA End -->

                                <!-- DA End -->

                                    @can('pending at da end renewal')
                                        <li><a class="b-newpage {{ request()->route('status') == 'PendingDocumentVerificationQueue' ? 'active' : '' }}" href="{{ route('office.applications-renewal.index', 'PendingDocumentVerificationQueue') }}">
                                                Under Document Verification</a></li>
                                    @endcan
                                    @can('verified applications history')
                                        <li><a class="b-newpage {{ request()->route('status') == 'VerifiedApplicationsHistory' ? 'active' : '' }}" href="{{ route('office.applications-renewal.index', 'VerifiedApplicationsHistory') }}">
                                                Verified Applications</a></li>
                                    @endcan
                                    @can('application history da')
                                        <li><a class="b-newpage {{  Route::currentRouteName() == 'office.applications-renewal.get-app-history-da' ? 'active' : '' }}" href="{{ route('office.applications-renewal.get-app-history-da') }}">
                                                Applications History</a></li>
                                    @endcan
                                    @can('application history RO')
                                        <li><a class="b-newpage {{  Route::currentRouteName() == 'office.applications-renewal.get-app-history-da' ? 'active' : '' }}" href="{{ route('office.applications-renewal.get-app-history-da') }}">
                                                Applications History</a></li>
                                    @endcan
                                    @can('application history hro')
                                        <li><a class="b-newpage {{  Route::currentRouteName() == 'office.applications-renewal.get-app-history-da' ? 'active' : '' }}" href="{{ route('office.applications-renewal.get-app-history-da') }}">
                                                Applications History</a></li>
                                    @endcan




                        </ul>
                    </li>
                @endcan

                @can('User Guideline')
                    <li><a href="{{ route('office.manual.dsc-manual') }}"
                            class="dashboard-bgcolor b-db-color border-bottom b-newpage {{ Route::currentRouteName() == 'office.manual.dsc-manual' ? 'active' : '' }}">DSC
                            Installation Guideline</a></li>
                @endcan
                @can('User manual')
                    <li><a href="{{ route('office.manual.user-manual') }}"
                            class="dashboard-bgcolor b-db-color border-bottom b-newpage {{ Route::currentRouteName() == 'office.manual.user-manual' ? 'active' : '' }}">User
                            Manual</a></li>
                @endcan
                @can('User manual da')
                    <li><a href="{{ route('office.manual.user-manual-da') }}"
                            class="dashboard-bgcolor b-db-color border-bottom b-newpage {{ Route::currentRouteName() == 'office.manual.user-manual-da' ? 'active' : '' }}">User
                            Manual</a></li>
                @endcan
                @can('digital signature')
                    @php
                        $isDscActive = in_array(Route::currentRouteName(), [
                            'office.dsc.index',
                            'office.manual.dsc-manual',
                            'office.dsc.applications',
                        ]);
                    @endphp

                    <li class='sub-menu {{ $isDscActive ? 'active' : '' }}'>
                        <a href='javascript:void(0)'
                            class="dashboard-bgcolor border-bottom b-db-color b-newpage {{ $isDscActive ? 'active' : '' }}">
                            Digital Signature
                            <div class='fa fa-caret-down right'></div>
                        </a>
                        <ul>
                            @can('dsc registration')
                                <li>
                                    <a class="b-newpage {{ Route::currentRouteName() == 'office.dsc.index' ? 'active' : '' }}"
                                        href="{{ route('office.dsc.index') }}">
                                        Dsc Registration
                                    </a>
                                </li>
                            @endcan

                            @can('sign application')
                                <li>
                                    <a class="b-newpage {{ Route::currentRouteName() == 'office.dsc.applications' ? 'active' : '' }}"
                                        href="{{ route('office.dsc.applications') }}">
                                        Sign Application
                                    </a>
                                </li>
                            @endcan
                        </ul>
                    </li>
                @endcan

                @can('masterdata management')
                    <li class='sub-menu'><a href='javascript:void(0)'
                            class="dashboard-bgcolor border-bottom b-db-color b-newpage">Master Data<div
                                class='fa fa-caret-down right'></div></a>
                        <ul>
                            @can('view state')
                                <li><a class="b-newpage @if (Route::is('admin.states.index')) active @endif"
                                        href="{{ route('admin.states.index') }}">State</a></li>
                            @endcan
                            @can('view district')
                                <li><a class="b-newpage @if (Route::is('admin.districts.index')) active @endif"
                                        href="{{ route('admin.districts.index') }}">Districts</a></li>
                            @endcan
                            @can('view subdistrict')
                                <li><a class="b-newpage @if (Route::is('admin.sub-districts.index')) active @endif"
                                        href="{{ route('admin.sub-districts.index') }}">Sub Districts</a></li>
                            @endcan
                            @can('view postoffice')
                                <li><a class="b-newpage @if (Route::is('admin.post-offices.index')) active @endif"
                                        href="{{ route('admin.post-offices.index') }}">Post Offices</a></li>
                            @endcan
                            @can('view bank')
                                <li><a class="b-newpage @if (Route::is('admin.banks.index')) active @endif"
                                        href="{{ route('admin.banks.index') }}">Bank Details</a></li>
                            @endcan
                            @can('view category')
                                <li><a class="b-newpage @if (Route::is('admin.categories.index')) active @endif"
                                        href="{{ route('admin.categories.index') }}">Categories</a></li>
                            @endcan
                            @can('view education')
                                <li><a class="b-newpage @if (Route::is('admin.educations.index')) active @endif"
                                        href="{{ route('admin.educations.index') }}">Educations</a></li>
                            @endcan
                            @can('view gender')
                                <li><a class="b-newpage @if (Route::is('admin.genders.index')) active @endif"
                                        href="{{ route('admin.genders.index') }}">Genders</a></li>
                            @endcan
                            @can('view housetype')
                                <li><a class="b-newpage @if (Route::is('admin.house-types.index')) active @endif"
                                        href="{{ route('admin.house-types.index') }}">House Types</a></li>
                            @endcan
                            @can('view marital')
                                <li><a class="b-newpage @if (Route::is('admin.merital-statuses.index')) active @endif"
                                        href="{{ route('admin.marital-statuses.index') }}">Marital Statuses</a></li>
                            @endcan
                            @can('view nature of work')
                                <li><a class="b-newpage @if (Route::is('admin.nature-of-works.index')) active @endif"
                                        href="{{ route('admin.nature-of-works.index') }}">Nature of Works</a></li>
                            @endcan
                            @can('view residence type')
                                <li><a class="b-newpage @if (Route::is('admin.residence-types.index')) active @endif"
                                        href="{{ route('admin.residence-types.index') }}">Residence Types</a></li>
                            @endcan
                            @can('view issuer type')
                                <li><a class="b-newpage @if (Route::is('admin.issuer-types.index')) active @endif"
                                        href="{{ route('admin.issuer-types.index') }}">Issuer Types</a></li>
                            @endcan
                            @can('view work type')
                                <li><a class="b-newpage @if (Route::is('admin.work-types.index')) active @endif"
                                        href="{{ route('admin.work-types.index') }}">Work Types</a></li>
                            @endcan
                            @can('view designation')
                                <li><a class="b-newpage @if (Route::is('admin.designations.index')) active @endif"
                                        href="{{ route('admin.designations.index') }}">Designations</a></li>
                            @endcan
                            @can('view age proof')
                                <li><a class="b-newpage @if (Route::is('admin.age-proofs.index')) active @endif"
                                        href="{{ route('admin.age-proofs.index') }}">Age Proofs</a></li>
                            @endcan
                            @can('view scheme')
                                <li><a class="b-newpage @if (Route::is('admin.schemes.index')) active @endif"
                                        href="{{ route('admin.schemes.index') }}">Schemes</a></li>
                            @endcan
                            @can('view profession')
                                <li><a class="b-newpage @if (Route::is('admin.professions.index')) active @endif"
                                        href="{{ route('admin.professions.index') }}">Professions</a></li>
                            @endcan
                            @can('view skill')
                                <li><a class="b-newpage @if (Route::is('admin.skills.index')) active @endif"
                                        href="{{ route('admin.skills.index') }} ">Skills</a></li>
                            @endcan
                            @can('view ration type')
                                <li><a class="b-newpage @if (Route::is('admin.ration-types.index')) active @endif"
                                        href="{{ route('admin.ration-types.index') }}">Ration Types</a></li>
                            @endcan
                            @can('view amount')
                                <li><a class="b-newpage @if (Route::is('admin.amounts.index')) active @endif"
                                        href="{{ route('admin.amounts.index') }}">Amounts</a></li>
                            @endcan
                             @can('view relation')
                            <li><a class="b-newpage @if (Route::is('admin.relation.index')) active @endif"
                                        href="{{ route('admin.relation.index') }}">Relations</a></li>
   @endcan
                             {{-- @can('view relations')
                                <li><a class="b-newpage @if (Route::is('admin.relations.index')) active @endif"
                                        href="{{ route('admin.relations.index') }}">Relations</a></li>
                            @endcan --}}

                            @can('view reasons')
                                <li><a class="b-newpage @if (Route::is('admin.reasons.index')) active @endif"
                                        href="{{ route('admin.reasons.index') }}">Reasons</a></li>
                            @endcan

                        </ul>
                    </li>
                @endcan

                @can('office management')
                    <li class='sub-menu'><a href='javascript:void(0)'
                            class="dashboard-bgcolor border-bottom b-db-color b-newpage">Office Management<div
                                class='fa fa-caret-down right'></div></a>
                        <ul>
                            @can('view office')
                                <li><a class="b-newpage @if (Route::is('admin.offices.index')) active @endif"
                                        href="{{ route('admin.offices.index') }}">Offices</a></li>
                            @endcan

                        </ul>
                    </li>
                @endcan

                @can('user management')
                    <li class='sub-menu'><a href='javascript:void(0)'
                            class="dashboard-bgcolor border-bottom b-db-color b-newpage">User Management<div
                                class='fa fa-caret-down right'></div></a>
                        <ul>
                            @can('view role')
                                <li><a class="b-newpage @if (Route::is('admin.roles.index')) active @endif"
                                        href="{{ route('admin.roles.index') }}">Roles</a></li>
                            @endcan

                            @can('view permission')
                                <li><a class="b-newpage @if (Route::is('admin.permission.index')) active @endif"
                                        href="{{ route('admin.permission.index') }}">Permission</a></li>
                            @endcan

                            @can('view user')
                                <li><a class="b-newpage @if (Route::is('admin.users.index')) active @endif"
                                        href="{{ route('admin.users.index') }}">Users</a></li>
                            @endcan
                                @can('view transferred user')
                                    <li><a class="b-newpage @if (Route::is('admin.users.transfer-index')) active @endif"
                                           href="{{ route('admin.users.transfer-index') }}">Transfer Users</a></li>
                                @endcan

                        </ul>
                    </li>
                @endcan

                @can('content management')
                    <li class='sub-menu'><a href='javascript:void(0)'
                            class="dashboard-bgcolor border-bottom b-db-color b-newpage">Content Management<div
                                class='fa fa-caret-down right'></div></a>
                        <ul>
                            <li><a class="b-newpage @if (Route::is('admin.gallery-categories.index')) active @endif"
                                    href="{{ route('admin.gallery-categories.index') }}">Gallery Category</a></li>
                            <li><a class="b-newpage @if (Route::is('admin.galleries.index')) active @endif"
                                    href="{{ route('admin.galleries.index') }}">Gallery Images</a></li>
                            <li><a class="b-newpage @if (Route::is('admin.contents.index')) active @endif"
                                    href="{{ route('admin.contents.index') }}">Content</a></li>
                            <li><a class="b-newpage @if (Route::is('admin.index_notification.index')) active @endif"
                                    href="{{ route('admin.index_notification.index') }}">Pdf uploads</a></li>
                            {{-- <li class='sub-menu'><a href='javascript:void(0)'
                            class="b-newpage">Returned Benefits
                                    <div class='fa fa-caret-down right'></div>
                                </a>
                                <ul>
                                    <li><a class="b-newpage @if (Route::is('admin.benefitsreturned.2023.index')) active @endif"
                                    href="{{ route('admin.benefitsreturned.2023.index') }}"
                                            href="">2023</a></li>
                                    <li><a class="b-newpage @if (Route::is('admin.benefitsreturned.2024.index')) active @endif"
                                    href="{{ route('admin.benefitsreturned.2024.index') }}"
                                            href="">2024</a></li>
                                    <li><a class="b-newpage @if (Route::is('admin.benefitsreturned.2025.index')) active @endif"
                                    href="{{ route('admin.benefitsreturned.2025.index') }}"
                                            href="">2025</a></li>
                                </ul>
                            </li> --}}
                        </ul>
                    </li>
                @endcan

                @can('view mis data')
                    <li class='sub-menu'><a href='javascript:void(0)'
                            class="dashboard-bgcolor border-bottom b-db-color b-newpage">MIS Data & Report<div
                                class='fa fa-caret-down right'></div></a>
                        <ul>
                            <li><a class="b-newpage @if (Route::is('admin.trackapp.index')) active @endif"
                                   href="{{ route('admin.trackapp.index') }}">Track Application</a></li>
                            <li><a class="b-newpage @if (Route::is('admin.pfcdata.index')) active @endif"
                                    href="{{ route('admin.pfcdata.index') }}">List of PFCs</a></li>
                            <li><a class="b-newpage @if (Route::is('admin.portalusers.index')) active @endif"
                                    href="{{ route('admin.portalusers.index') }}">List of Portal Users</a></li>
                            <li><a class="b-newpage @if (Route::is('admin.workerdata.index')) active @endif"
                                    href="{{ route('admin.workerdata.index') }}">Worker Registration Status</a></li>
                            <li><a class="b-newpage @if (Route::is('admin.alreadyregdata.index')) active @endif"
                                    href="{{ route('admin.alreadyregdata.index') }}">Already Registered Worker</a></li>
                            <li><a class="b-newpage @if (Route::is('admin.renewaldata.index')) active @endif"
                                    href="{{ route('admin.renewaldata.index') }}">Details of Renewal</a></li>
                            <li><a class="b-newpage @if (Route::is('admin.districtwise.index')) active @endif"
                                    href="{{ route('admin.districtwise.index') }}">District Wise Data</a></li>
                            <li><a class="b-newpage @if (Route::is('admin.officewise.index')) active @endif"
                                    href="{{ route('admin.officewise.index') }}">Office Wise Data</a></li>
                            <li><a class="b-newpage @if (Route::is('admin.pfcwise.index')) active @endif"
                                    href="{{ route('admin.pfcwise.index') }}">CSC Wise Data</a>


                            <li><a class="b-newpage @if (Route::is('admin.workerpaddress.index')) active @endif"
                                    href="{{ route('admin.workerpaddress.index') }}">Migrant Worker Details</a></li>
                            <li><a class="b-newpage @if (Route::is('admin.idcarddata.index')) active @endif"
                                    href="{{ route('admin.idcarddata.index') }}">ID Cards</a></li>
                            <li><a class="b-newpage @if (Route::is('admin.dataupdate.index')) active @endif"
                                    href="{{ route('admin.dataupdate.index') }}">Data Update</a></li>
                            <li><a class="b-newpage @if (Route::is('admin.dataupdate.ViewApp')) active @endif"
                                    href="{{ route('admin.dataupdate.ViewApp') }}">Application Update</a></li>
                            <li><a class="b-newpage @if (Route::is('admin.paymentdata.index')) active @endif"
                                    href="{{ route('admin.paymentdata.index') }}">Payments Report</a></li>
                            <li><a class="b-newpage @if (Route::is('admin.csc.csc-data')) active @endif"
                                   href="{{ route('admin.csc.csc-data') }}">Payments Report CSC</a></li>

                            <li><a class="b-newpage @if (Route::is('admin.dataupdate.getToken')) active @endif"
                                    href="{{ route('admin.dataupdate.getToken') }}">Search Data - Token, Worker Id,
                                    Subscription</a></li>
                            <li><a class="b-newpage @if (Route::is('admin.dataupdate.rejected-list')) active @endif"
                                    href="{{ route('admin.dataupdate.rejected-list') }}">Rejected list</a></li>
                            <li><a class="b-newpage @if (Route::is('admin.allusers.index')) active @endif"
                                    href="{{ route('admin.allusers.index') }}">All Users Data</a></li>
                            <li><a class="b-newpage @if (Route::is('admin.profession-wise.index')) active @endif"
                                    href="{{ route('admin.profession-wise.index') }}">Profession wise Data</a></li>

                            <li><a class="b-newpage @if (Route::is('admin.get-application-status')) active @endif"
                                    href="{{ route('admin.get-application-status') }}">Application Status Report</a></li>
                            <li><a class="b-newpage @if (Route::is('admin.get-pan-ration-status')) active @endif"
                                   href="{{ route('admin.get-pan-ration-status') }}">Pan & ration card Report</a></li>
                            <li><a class="b-newpage @if (Route::is('admin.get-subscription')) active @endif"
                                   href="{{ route('admin.get-subscription') }}">Subscription Report</a></li>
                            <li><a class="b-newpage @if (Route::is('admin.eshram.error-log')) active @endif"
                                   href="{{ route('admin.eshram.error-log') }}">error logs eShram</a></li>
                            <li><a class="b-newpage @if (Route::is('admin.otp.user-otp')) active @endif"
                                   href="{{ route('admin.otp.user-otp') }}">User OTP</a></li>
                            <li><a class="b-newpage @if (Route::is('admin.bulk-data')) active @endif"
                                   href="{{ route('admin.bulk-data') }}">Vault Data Decrypted</a></li>
                            <li><a class="b-newpage @if (Route::is('admin.migrant-bulk-data')) active @endif"
                                   href="{{ route('admin.migrant-bulk-data') }}">Migrant Worker Data Decrypted</a></li>

                        </ul>
                    </li>
                @endcan
                    {{--@can('renewal mis data admin')--}}
                        {{--<li class='sub-menu'><a href='javascript:void(0)' class="dashboard-bgcolor border-bottom b-db-color b-newpage">MIS Data Renewal<div--}}
                                        {{--class='fa fa-caret-down right'></div></a>--}}
                        {{--<ul>--}}
                            {{--<li><a class="b-newpage @if (Route::is('admin.pfcdata.index')) active @endif"--}}
                                   {{--href="{{ route('admin.pfcdata.index') }}">Renewal Data</a></li>--}}
                            {{--<li><a class="b-newpage @if (Route::is('admin.officewise.index-renewal')) active @endif"--}}
                                   {{--href="{{ route('admin.officewise.index-renewal') }}">Office Wise Data</a></li>--}}
                            {{--<li><a class="b-newpage @if (Route::is('admin.pfcdata.index')) active @endif"--}}
                                   {{--href="{{ route('admin.pfcdata.index') }}">District Wise</a></li>--}}
                            {{--<li><a class="b-newpage @if (Route::is('admin.pfcdata.index')) active @endif"--}}
                                   {{--href="{{ route('admin.pfcdata.index') }}">Profession Wise</a></li>--}}
                        {{--</ul>--}}
                    {{--@endcan--}}

                @can('view office mis dashboard')
                    @php
                        $isMisActive = Route::is('office.mis-data.*');
                    @endphp

                        <li class='sub-menu {{ $isMisActive ? "active" : "" }}'>
                            <a href='javascript:void(0)'
                               class="dashboard-bgcolor border-bottom b-db-color b-newpage {{ $isMisActive ? "active" : "" }}">
                                MIS Data
                                <div class='fa fa-caret-down right'></div>
                            </a>
                            <ul>
                                <li>
                                    <a class="b-newpage {{ request()->route('application_type') === 'all' ? 'active' : '' }}"
                                       href="{{ route('office.mis-data.mis-report', ['application_type' => 'all']) }}">
                                        All Data
                                    </a>

                                </li>
                            </ul>
                        </li>
            @endcan


                {{-- BENEFIT --}}
                 {{--@can('benefit')--}}
                {{--<li class='sub-menu'><a href='javascript:void(0)'--}}
                        {{--class="dashboard-bgcolor border-bottom b-db-color b-newpage">Benefits<div--}}
                            {{--class='fa fa-caret-down right'></div></a>--}}
                    {{--<ul>--}}
                        {{--<li><a class="b-newpage @if (Route::is('admin.benefit-list.index')) active @endif"--}}
                                {{--href="{{ route('admin.benefit-list.index') }}">Benefit List</a></li>--}}
                    {{--</ul>--}}

                {{--</li>--}}
                 {{--@endcan--}}


                {{-- BENEFIT --}}
        @endif

    </div>
</div>
