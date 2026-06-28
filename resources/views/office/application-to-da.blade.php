
@include('layout.officeheader')
<body>
<div class="d-flex" id="wrapper">
@include('office.leftmenu')
<!-- Page Content -->
    <div id="page-content-wrapper">

        <nav class="navbar navbar-expand-lg navbar-light dashboard-bgcolor border-bottom">
            <button class="btn b-db-color" id="menu-toggle">
                <span style="display:none;">Menu</span>
                <span class="fas fa-bars" style="font-size: 1.4rem"></span>
            </button>
            <button class="navbar-toggler b-dropmenubtn" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
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
                        <a class="nav-link dropdown-toggle b-db-color" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <span class="fas fa-users" style="font-size: 20px; padding-right:10px;"></span>Profile
                        </a>
                        <div class="dropdown-menu dropdown-menu-right text-center b-dropmenu-db" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="#">My Profile</a>
                            <a class="dropdown-item" href="#">Change Password</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="javascript:void(0);" data-toggle="modal" data-target="#signout-modal">Sign Out</a>

                        </div>
                    </li>
                </ul>
            </div>
        </nav>
        <div class="container-fluid">
        {{--            <div class="d-flex clearfix mt-4">--}}
        {{--                <h3 class="d-inline-block" style="font-size:32px;">Dashboard</h3>--}}
        {{--                <span class="ml-auto d-inline-block align-self-center"><button type="button" class="btn btn-primary b-btn"><span class="fas fa-download fa-sm"></span> Report</button></span>--}}
        {{--            </div>--}}


        <!-- Content Row -->

            <div class="my-5" id="b-homedb">

                <div class="container">
                    {{--                    <h4 class="text-center mb-3 b-latest-data">Application Received</h4>--}}
                    {{--                    <div class="pl-4 text-right" style="font-size: 24px">--}}
                    {{--					<span class="mr-2" id="one-item-row" style="cursor: pointer;">--}}
                    {{--						<i class="fas fa-bars"></i>--}}
                    {{--					</span>--}}
                    {{--                        <span class="mr-2" id="two-item-row" style="cursor: pointer;">--}}
                    {{--						<i class="fas fa-th-large"></i>--}}
                    {{--					</span>--}}
                    {{--                        <span class="mr-2" id="three-item-row" style="cursor: pointer;">--}}
                    {{--						<i class="fas fa-th"></i>--}}
                    {{--					</span>--}}
                    {{--                    </div>--}}

                    {{--                    <div class="">--}}
                    {{--                        <div class="row text-center pl-4" id="sortable-cards">--}}

                    {{--                        </div>--}}
                    {{--                    </div>--}}

                </div>

            </div>

            <!-- show Latest Application -->
            <div class="row text-center pl-4" id="sortable-cards">
                <div class="col-lg-12 col-sm-12 p-3 b-customize">
                    <div class="bg-light p-4 b-dbcard">
                        {{--                      <i class="fas fa-users position-absolute" style="font-size:35px; right: 40px; top: 40px;"></i>--}}
                        <div class="">
                            <h5 class="text-left font-weight-light"><i class="fa fa-file-text text-dark" aria-hidden="true"></i>&nbspApplications Received :</h5>
                            {{--                          <h3 class="text-left font-weight-bold" style="margin-top: -5px">39.04 Cr</h3>--}}
                            {{--                          <div class="text-left" style="margin: 10px 0px 5px;">--}}
                            {{--                              <span class="badge badge-success">+4%</span>--}}
                            {{--                              <span style="font-size:13px;"> From previous period</span>--}}
                            {{--                          </div>--}}
                            <div class="table-responsive mt-4">
                                <table class="table table-bordered table-secondary text-sm-center">
                                    <thead class="thead-dark">
                                    <tr>
                                        <th >Sl.no</th>
                                        <th >Application No</th>
                                        <th >Name</th>
                                        <th >Date & time</th>
                                        <th >Status</th>
                                        <th >Preview</th>
                                    </tr>
                                    </thead>
                                    @foreach($data as $key=> $application)
                                        <tbody>
                                        <tr>
                                            <td>{{$loop->iteration}}</td>
                                            <td>{{$application->worker_id}}</td>
                                            <td>{{$application->first_name}} {{$application->last_name}}</td>
                                            <td>{{$application->created_at}}</td>
                                            <td>@if($application->status == 'B')<span class=" badge badge-danger">Pending</span>
                                                @elseif($application->status == 'B')<span class="badge badge-primary">Pending</span>
                                                @elseif($application->status == 'C')<span class="badge badge-warning">Pending</span>
                                                @elseif($application->status == 'F')<span class="badge badge-success">Approved</span>
                                                @elseif($application->status == 'D')<span class="badge badge-success">Rejected</span>
                                                @endif</td>
                                            <td>
                                                <a href="{{route('office-applications',['id' =>$application->worker_id])}}" ><i class="fa fa-eye" aria-hidden="true"></i></a>
                                            </td>
                                        </tr>
                                        </tbody>
                                    @endforeach
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
    <div class="modal fade" id="signout-modal" aria-hidden="true" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header text-center d-block p-5 border-bottom-0">
                    <h3 class="modal-title">Sign Out?</h3>
                    <button type="button" class="close position-absolute" style="right: 15px; top: 8px;" data-dismiss="modal">&times;</button>
                </div>

                <!-- Modal body -->
                <div class="modal-body">
                    <p class="text-center">Are you sure you want to Sign Out?</p>
                    <div class="text-center py-4">
                        <form action="logout" method="GET">
                            <button type="submit" class="btn btn-primary b-btn mx-2">Sign Out</button>
                            <button class="btn btn-secondary mx-3" data-dismiss="modal">Cancel</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
@include('layout.footer')
