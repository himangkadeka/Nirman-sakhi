@include('layout.workerheader')

<body>
    <div class="d-flex" id="wrapper">
        @include('worker.leftmenu')
        <!-- Page Content -->
        <div id="page-content-wrapper">
            @include('components.worker.ui.navbar')

            <div class="container-fluid">
                <div class="my-5" id="b-homedb">
                    {{-- <div class ="add-butt p-3 "><a href="#"
                            onclick="event.preventDefault(); document.getElementById('generate-id-card-form').submit();"><button
                                type="button" class="btn btn-primary b-btn">Generate<i class="fa fa-plus pl-2"
                                    aria-hidden="true"></i></button></a>
                    </div> --}}
                    <div class="card rounded-card">
                        <div class="card-header card-header-bg text-white font-weight-bold" style="background-color: #248f8f;">Receipts</div>
                    </div>
                    <div class="justify-content-center">
                        <table style="border-collapse: collapse; width: 100%; text-align: center;">
                            <tr>
                                <td class="border border-black font-weight-bold" style=" padding: 10px;">Sl No</td>
                                <td class="border border-black  font-weight-bold" style="padding:  10px;">Receipt Name</td>
                                <td class="border border-black  font-weight-bold" style="padding:  10px;">Status</td>
                                <td class="border border-black  font-weight-bold" style="padding:  10px;">Generated On</td>
                                <td class="border border-black  font-weight-bold" style="padding:  10px;">Action</td>

                            </tr>
                            @foreach($subscriptionreciept as $data)
                            <tbody>

                            <tr>
                                <td class="border border-black font-weight-bold" style=" padding: 10px;">{{$data->id}}</td>
                                <td class="border border-black font-weight-bold" style=" padding: 10px;">{{$data->receipt_name}}</td>
                                <td class="border border-black font-weight-bold" style=" padding: 10px;">{{$data->status}}</td>
                                <td class="border border-black font-weight-bold" style=" padding: 10px;">{{$data->created_at}}</td>
                                <td class="border border-black font-weight-bold" style=" padding: 10px;"></td>
                            </tr>

                            </tbody>
                            @endforeach
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('layout.footer')
