@include('layout.workerheader')
<div class="d-flex" id="wrapper">
    @include('worker.leftmenu')
    <!-- Page Content -->
    <div id="page-content-wrapper">
        @include('components.worker.ui.navbar')


        <ul class="breadcrumb" style="font-family:'Poppins',Sans-Serif ">
            <li><a href="#">Dashboard</a></li>
        </ul>


        @php
            $current_date = now();
        @endphp

        <div class="container">
            <div class="table-responsive">
            <table class="table table-hover">
                <thead class="table-light">
                    <tr>
                        <th width="60%">Scheme Name</th>
                        <th width="20%">Status</th>
                        <th width="20%">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Placeholder for scheme data -->
                    <tr>
                        @foreach ($benefits as $benefit)
                    <tr class="">
                        <td>{{ $benefit->name }}</td>
                        <td><a class="btn btn-sm btn-primary square" href="#">View</a> </td>
                        <td>@if(\App\Models\FormSubmission::where('benefit_id',$benefit->id)->where('applicant_family_member_id',$getDetails->family_id)->where('status','draft')->exists())
                                <a class="btn btn-sm btn-danger square"
                                href="{{ route('worker.edit-now', \App\Models\FormSubmission::where('benefit_id',$benefit->id)->where('applicant_family_member_id',$getDetails->family_id)->where('status','draft')->first()->application_id) }}">Complete Application</a>
                            @else
                            <a class="btn btn-sm btn-danger square"
                                href="{{ route('worker.apply-now', $benefit->id) }}">Apply Now</a>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                    </tr>
                </tbody>
            </table>
        </div>
        </div>
    </div>
</div>

@include('components.footer')
<script src="{{ URL::asset('assets/template/vendor/jquery/jquery.min.js') }}"></script>
<script src="{{ URL::asset('assets/template/js/getVaultData.js') }}"></script>
<script src="{{ URL::asset('assets/template/js/sweetAlert.js') }}"></script>
</body>


</html>
