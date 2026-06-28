@include('layout.workerheader')

<body>
    <div class="d-flex" id="wrapper">
        @include('worker.leftmenu')
        <!-- Page Content -->
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
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle b-db-color" href="" id="navbarDropdown"
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

            <div class="container-fluid">

                <div class="my-5" id="b-homedb">
                    @if (!$id)
                        <div class ="add-butt p-3 ">
                            <a href="#"
                                onclick="event.preventDefault(); document.getElementById('generate-id-card-form').submit();">
                                <button type="button" class="btn btn-primary b-btn">Generate<i class="fa fa-plus pl-2"
                                        aria-hidden="true"></i></button>
                            </a>
                        </div>
                    @endif
                    <div class="card rounded-card">
                        <div class="card-header card-header-bg text-white font-weight-bold" style="background-color: #248f8f;">Id Card</div>
                    </div>
                    <div class="justify-content-center">
                        <table style="border-collapse: collapse; width: 100%; text-align: center;">
                            <tr>
                                <td class="border border-black font-weight-bold" style=" padding: 10px;">Id No</td>
                                <td class="border border-black  font-weight-bold" style="padding:  10px;">Generated On
                                </td>
                                <td class="border border-black  font-weight-bold" style="padding:  10px;">Action</td>

                            </tr>

                            <form id="generate-id-card-form" action="{{ route('idcards.store') }}" method="POST"
                                style="display: none;">
                                @csrf
                            </form>

                            @if ($user->status == 'F' && $id)
                                <tr>
                                    <td class="border border-black font-weight-bold" style=" padding: 10px;">
                                        {{ $id->id }}</td>
                                    <td class="border border-black  font-weight-bold" style="padding:  10px;">
                                        {{ $id->created_at }}</td>
                                    <td class="border border-black font-weight-bold" style="padding: 10px;">
                                        <a onclick="openPdf('{{ base64_encode($decodedIdCard) }}')" type="application/pdf" class="btn btn-primary text-white" target="_blank">
                                            <i class="fa fa-external-link" aria-hidden="true"></i>&nbsp;View
                                        </a>
                                        <a onclick="downloadPdf('{{ base64_encode($decodedIdCard) }}')" class="btn btn-danger text-white">
                                            <i class="fa fa-external-link" aria-hidden="true"></i>&nbsp;Download PDF
                                        </a>
                                    </td>
                                </tr>
                            @else
                                <tr>
                                    <td class="border border-black font-weight-bold" style=" padding: 10px;" colspan=3>
                                        No ID Card found</td>
                                </tr>
                            @endif
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function openPdf(pdfData) {
            // Create a new window or tab with the PDF content
            var newWindow = window.open('', '_blank');
            newWindow.document.write('<iframe width="100%" height="100%" src="data:application/pdf;base64,' + pdfData + '"></iframe>');
            return false;
        }
    </script>
    <script>
        function downloadPdf(pdfData) {
            var link = document.createElement('a');
            link.href = 'data:application/pdf;base64,' + pdfData;
            link.download = 'idcard.pdf';
            link.click();
        }
    </script>


    @include('layout.footer')
