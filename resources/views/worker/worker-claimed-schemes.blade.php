
@include('layout.workerheader')
{{--<body>--}}
<div class="d-flex" id="wrapper">
@include('worker.leftmenu')
<!-- Page Content -->
    <div id="page-content-wrapper">
        @include('components.worker.ui.navbar')
{{--        <div class="container-fluid">--}}
{{--            <div class="my-5" id="b-homedb">--}}
{{--                <div class="text-center py-4">--}}
{{--                    <div class="justify-content-center mt-1">--}}

{{--                        <table style="border-collapse: collapse; width: 100%; text-align: center;">--}}
{{--                <tr>--}}
{{--                    <td class="bg-app" colspan="5"><h5 class="text-dark">Already Availed Scheme</h5></td>--}}
{{--                </tr>--}}
{{--                            <tr>--}}
{{--                                <td class="border border-warning font-weight-bold" style="padding:  10px;">Scheme Name</td>--}}
{{--                                <td class="border border-warning font-weight-bold" style="padding:  10px;">Registration No</td>--}}
{{--                                <td class="border border-warning font-weight-bold" style="padding:  10px;">Date Of Registration</td>--}}
{{--                            </tr>--}}
{{--                            @foreach ($schemes as $key=>$scheme)--}}
{{--                                <tr>--}}
{{--                                    <td class="border border-warning" style=" padding: 10px;">{{$scheme->scheme_name}}</td>--}}
{{--                                    <td class="border border-warning" style=" padding: 10px;">{{$scheme->registration_id}}</td>--}}
{{--                                    <td class="border border-warning" style=" padding: 10px;">{{$scheme->date}}</td>--}}

{{--                                </tr>--}}
{{--                            @endforeach--}}
{{--                        </table>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
        <div class="container mt-5">
            <div class="card rounded-card">
                <div class="card-header card-header-bg text-white font-weight-bold" style="background-color: #2badee;">Already Availed Scheme</div>
                <div class="card-body">
                    <div class="container">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered">
                                <thead>
                                <tr>
                                    <th>Scheme Name</th>
                                    <th>Registration No</th>
                                    <th>Date Of Registration</th>
                                </tr>
                                </thead>
                                <tbody>
                                @if ($schemes->isEmpty())
                                    <tr>
                                        <td colspan="3" class="text-center">No data to display</td>
                                    </tr>
                                @else
                                    @foreach ($schemes as $key => $scheme)
                                        <tr>
                                            <td class="border border-black" style="padding: 10px;">{{ $scheme->scheme_name }}</td>
                                            <td class="border border-black">{{ $scheme->registration_id }}</td>
                                            <td class="border border-black">{{ $scheme->date }}</td>
                                        </tr>
                                    @endforeach
                                @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /#page-content-wrapper -->
</div>
<!-- /#wrapper -->
<!-- Signup Modal -->
<div class="modal fade" id="signout-modal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header text-center d-block p-5 border-bottom-0">
                <h3 class="modal-title">Sign Out?</h3>
                <button type="button" class="close position-absolute" style="right: 15px; top: 8px;" data-dismiss="modal">&times;</button>
            </div>
            <!-- Modal body -->
            <div class="modal-body">
                <p class="text-center">Are you sure you want to Log Out?</p>
                <div class="text-center py-4">
                    <form action="{{route('user-logout')}}" method="post">
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
<div class="modal fade" id="successModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
<script>
    @if ($message = Session::get('success'))
    $(document).ready(function(){
        $('#successModal').modal({backdrop: 'static', keyboard: false}, 'show');

    });
    @endif
</script>
</body>
@include('layout.footer');
</html>
