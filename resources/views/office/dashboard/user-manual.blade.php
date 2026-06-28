@include('layout.officeheader')
<body>
<div class="d-flex" id="wrapper">
@include('components.sidebar')
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
            <div class="row text-center pl-4" id="sortable-cards">
                <div class="col-lg-12 col-sm-12 p-3 b-customize">
                    <div class="bg-light p-4 b-dbcard">
                        @if ($type == 'dsc')
                        <h5>DSC Manual</h5>
                        <p>Click below to view or download the PDF</p>
                        <button onclick="viewPDF('{{asset('assets/template/pdf/DSC.pdf')}}')" class="btn btn-primary">View PDF</button>
                        <a href="{{asset('assets/template/pdf/DSC.pdf')}}" download class="btn btn-success">Download PDF</a>

                            @elseif($type == 'manual')

                            <h5>User Manual</h5>
                            <p>Click below to view or download the PDF</p>
                            <button onclick="viewPDF('{{asset('assets/template/pdf/ROmanual.pdf')}}')" class="btn btn-primary">View PDF</button>
                            <a href="{{asset('assets/template/pdf/ROmanual.pdf')}}" download class="btn btn-success">Download PDF</a>
                            @endif

                    </div>
                </div>
            </div>


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
    </div>
</div>
</body>
@include('layout.footer')
<script>
    function viewPDF(pdfUrl) {
        window.open(pdfUrl, '_blank');
    }
</script>
