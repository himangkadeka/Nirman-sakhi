@include('layout.workerheader')
<body>
<div class="d-flex" id="wrapper">
@include('worker.leftmenu')
<!-- Page Content -->
    <div id="page-content-wrapper">
        @include('components.worker.ui.navbar')

        <div class="container-fluid">
            <div class="my-5" id="b-homedb">
                <div class ="add-butt p-3 "><a href="#" onclick="event.preventDefault(); document.getElementById('generate-id-card-form').submit();"><button type="button" class="btn btn-primary b-btn">Generate<i class="fa fa-plus pl-2" aria-hidden="true"></i></button></a>
                </div>
                <div class="justify-content-center">
                <table style="border-collapse: collapse; width: 100%; text-align: center;">
                    <tr>
                        <td class="bg-app" colspan="3" style="padding: 6px"><h5 class="d-inline-block text-dark"><i class='fa fa-id-card'></i> Id Card</h5></td>
                    </tr>
                    <tr>
                        <td class="border border-black font-weight-bold" style=" padding: 10px;">Id No</td>
                        <td class="border border-black  font-weight-bold" style="padding:  10px;">Generated On</td>
                        <td class="border border-black  font-weight-bold" style="padding:  10px;">Action</td>

                    </tr>

                    <form id="generate-id-card-form" action="{{ route('generate.id.card') }}" method="POST" style="display: none;">
                        @csrf
                    </form>

                    @if($user->status == 'F' && $id)
                    <tr>
                        <td class="border border-black font-weight-bold" style=" padding: 10px;">{{ $id->id }}</td>
                        <td class="border border-black  font-weight-bold" style="padding:  10px;">{{ $id->created_at }}</td>
                        <td class="border border-black font-weight-bold" style="padding: 10px;">
                            <a  href="{{route('download-id-card')}}"class="href" target="_blank">
                                <i class="fa fa-external-link" aria-hidden="true"></i>&nbsp;View
                            </a>
                            /
                            <a style="color: red" class="" href="{{ route('get-id-card',['id'=> mt_rand(1,1000)]) }}" >Download <i  class="fa fa-file-pdf-o" aria-hidden="true"></i></a>
                        </td>
                    </tr>
                    @else
                    <tr>
                        <td class="border border-black font-weight-bold" style=" padding: 10px;" colspan=3>No ID Card found</td>
                    </tr>
                    @endif
                </table>
                </div>
            </div>
        </div>
       <!-- Modal -->
        <div class="modal fade" id="idCardModal" tabindex="-1" role="dialog" aria-labelledby="idCardModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document" style="max-width:35%">
                <div class="modal-content">
                    <div style="display:flex; justify-content:center; align-items:center; padding: 20px" class="modal-header">
                        <img src="{{ asset('assets/template/images/emblem-dark.png') }}" alt="National Emblem of India" title="emblem of india logo" style="margin-right: 20px">
                        <h2><span>Assam Building & Other Construction Worker's Welfare Board </span></h2>
                    </div>
                    <div style="display:flex; justify-content:space-between">
                        <div class="modal-body">
                            <!-- Display ID card details here -->
                            <div style="display:flex">
                                <p class="mr-4 font-weight-bold">First Name/প্ৰথম নাম: <span class="font-weight-normal">{{ $wrkr->first_name }}</span> </p>
                                <p class="font-weight-bold">Last Name/উপাধি: <span class="font-weight-normal">{{ $wrkr->last_name }}</span></p>
                            </div>
                            <div style="display:flex">
                                <p class="mr-4 font-weight-bold">Guardian Name/অভিভাৱক নাম: <span class="font-weight-normal">{{ $wrkr->gurdain_name }}</span> </p>
                                <!-- <p class="font-weight-bold">Last Name: <span class="font-weight-normal">{{ $wrkr->last_name }}</span></p> -->
                            </div>
                            <div style="display:flex">
                                <p class="mr-4 font-weight-bold">Date of Birth/জন্ম তাৰিখ: <span class="font-weight-normal">{{ $wrkr->dob }}</span> </p>
                                <!-- <p class="font-weight-bold">Last Name: <span class="font-weight-normal">{{ $wrkr->last_name }}</span></p> -->
                            </div>
                            <div style="display:flex">
                                <p class="mr-4 font-weight-bold">Occupation/বৃত্তি: <span class="font-weight-normal">Earth Cutter</span> </p>
                                <!-- <p class="font-weight-bold">Last Name: <span class="font-weight-normal">{{ $wrkr->last_name }}</span></p> -->
                            </div>
                            <div style="display:flex">
                                <p class="mr-4 font-weight-bold">Phone Number/ফোন নম্বৰ: <span class="font-weight-normal">9999999999</span> </p>
                                <!-- <p class="font-weight-bold">Last Name: <span class="font-weight-normal">{{ $wrkr->last_name }}</span></p> -->
                            </div>
                            <div style="display:flex">
                                <p class="mr-4 font-weight-bold">Address/ঠিকনা: <span class="font-weight-normal">Lorem ipsum Lorem ipsum Lorem ipsum Lorem ipsum Lorem ipsum Lorem ipsum</span> </p>
                                <!-- <p class="font-weight-bold">Last Name: <span class="font-weight-normal">{{ $wrkr->last_name }}</span></p> -->
                            </div>
                        </div>
                        <div class="modal-body">
                            <!-- Display Applicant Photo here -->
                            <div class="mt-3" style="display: flex; justify-content:left">
                                <img src="{{route('worker-passport',['id'=> mt_rand(1,1000),'worker_id'=>$wrkr->worker_id])}}" alt="Applicant Photo" height="150px" width="150px">
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



<script>
    // Function to show the modal
    function showIdCardModal() {
        $('#idCardModal').modal('show');
    }
</script>
@include('layout.footer')
