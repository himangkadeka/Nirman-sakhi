@include('layout.workerheader')
<style>
    /* Custom styles */
    .table {
        font-size: 0.9rem;
    }

    th,
    td {
        text-align: center;
    }

    th {
        background-color: #f8f9fa;
        color: #333;
        font-weight: bold;
    }

    tbody tr:nth-child(even) {
        background-color: #f2f2f2;
    }

    tbody tr:hover {
        background-color: #e9ecef;
    }
</style>
<div class="d-flex" id="wrapper">
    @include('worker.leftmenu')
    <!-- Page Content -->
    <div id="page-content-wrapper">
        @include('components.worker.ui.navbar')

        @if ($wmf->payment_status !== 'pending')
            <ul class="breadcrumb">
                <li><a href="#">Payment Details</a></li>
            </ul>
        @endif

        @php
            $current_date = now();
        @endphp
        @if ($renewal_date->gt($current_date))
            <div class="container mt-5">
                <div class="card rounded-card">
                    <div class="card-header card-header-bg text-white font-weight-bold"
                        style="background-color: #248f8f;">Payment Details</div>
                    <div class="card-body">
                        <div class="container">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Description</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td class="border border-black" style=" padding: 10px;">
                                               Registration Fees
                                            </td>
                                            <td class="border border-black">
                                                @if ($wmf->payment_status == 'success')
                                                    Paid&nbsp;<i style="color: green" class="fa fa-check-circle" aria-hidden="true"></i>
                                                @elseif ($wmf->payment_status == 'pending')
                                                    Unpaid&nbsp;<i style="color: red" class="fa fa-times-circle" aria-hidden="true"></i>
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="border border-black" style=" padding: 10px;">
                                               Subscription Fees
                                            </td>
                                            <td class="border border-black">
                                                @if ($wmf->active_status == '1')
                                                Paid&nbsp;<i style="color: green" class="fa fa-check-circle" aria-hidden="true"></i>
                                                @elseif ($wmf->active_status == '0')
                                                Unpaid&nbsp;<i style="color: red" class="fa fa-times-circle" aria-hidden="true"></i>
                                                @elseif ($wmf->active_status == '2')
                                                Unpaid&nbsp;<i style="color: red" class="fa fa-times-circle" aria-hidden="true"></i>
                                                @endif
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>

    <!-- /#page-content-wrapper -->
</div>

<!--view application details-->
<div class="modal fade" id="signout-modal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header text-center d-block p-5 border-bottom-0">
                <h3 class="modal-title">Sign Out?</h3>
                <button type="button" class="close position-absolute" style="right: 15px; top: 8px;"
                    data-dismiss="modal">&times;</button>
            </div>
            <!-- Modal body -->
            <div class="modal-body">
                <p class="text-center">Are you sure you want to Log Out?</p>
                <div class="text-center py-4">
                    <form action="{{ route('user-logout') }}" method="post">
                        @csrf
                        <button type="submit" class="btn btn-primary b-btn mx-2">Sign Out</button>
                        <button class="btn btn-secondary mx-3" data-dismiss="modal">Cancel</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</div>

<!-- Modal -->
<div class="modal fade" id="successModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Welcome to the dashboard!</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                @if ($message = Session::get('success'))
                    <div class="alert alert-success alert-block">
                        <strong>{!! $message !!} </strong>
                    </div>
                @endif
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>


@include('components.worker.payment.payment-verification-form')
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
<script>
    @if ($message = Session::get('success'))
        $(document).ready(function() {
            $('#successModal').modal({
                backdrop: 'static',
                keyboard: false
            }, 'show');
        });
    @endif
</script>
<script>
    function updateTime() {
        var currentTimeElement = document.getElementById('currentTime');
        var currentTime = new Date();
        var hours = currentTime.getHours();
        var minutes = currentTime.getMinutes();
        var seconds = currentTime.getSeconds();

        // Add leading zeros if necessary
        hours = (hours < 10 ? "0" : "") + hours;
        minutes = (minutes < 10 ? "0" : "") + minutes;
        seconds = (seconds < 10 ? "0" : "") + seconds;

        var timeString = hours + ":" + minutes + ":" + seconds;
        currentTimeElement.textContent = timeString;
    }

    // Update the time every second
    setInterval(updateTime, 1000);

    // Call updateTime once to avoid initial delay
    updateTime();
</script>

</body>
@include('layout.footer')

</html>
