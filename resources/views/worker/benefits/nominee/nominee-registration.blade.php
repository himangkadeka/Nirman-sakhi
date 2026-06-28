@include('layout.workerheader')

<style>
    body {
        font-family: Arial, sans-serif;
    }

    .myrow {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 18px;
        padding: 20px;
        margin-bottom: 25px;
    }

    .form_control {
        display: flex;
        flex-direction: column;
        gap: 5px;
    }

    .form_control label {
        font-size: 15.5px;
        color: #565555;
        height: 50px;
        display: flex;
        align-items: flex-end;
    }

    .myrow input,
    textarea,
    select {
        width: 100%;
        height: 45px;
        padding: 12px;
        box-sizing: border-box;
        border: none;
        border-bottom: 2px solid #ccc;
        border-radius: 4px;
        background: #fff;
    }

    .radio-btn,
    .checkbox {
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        gap: 15px;
        background: #fff;
        padding: 10px;
        border-radius: 4px;
        border-bottom: 2px solid #ccc;
    }

    .radio-btn input[type="radio"],
    .checkbox input[type="checkbox"] {
        width: 20px;
        height: 20px;
    }

    .benefits-sec {
        background: linear-gradient(45deg, #cce7ff, #cbf9e07d);
        padding: 10px 20px 30px;
        margin: 0px 30px 30px;
        border-radius: 0px 0px 20px 20px;
    }

    .myrow input[type="file"] {
        height: 50px;
    }

    #benefit-btn button,
    #benefit-btn a {
        width: 150px;
        padding: 7px;
        margin: 10px;
        box-shadow: 1px 1px 4px #959494;
        transition: 0.4s linear;
    }

    #benefit-btn button:hover,
    #benefit-btn a:hover {
        box-shadow: 5px 5px 8px #979696ab;
    }

    .benefit-heading {
        margin: 15px 30px 0;
        background: #38393a;
        padding: 15px 30px;
        border-radius: 25px 25px 0 0;
        color: white;
        font-size: 22px;
        font-weight: 500;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .benefit-heading h3 {
        margin: 0;
        font-size: 21px;
        font-weight: 500;
    }

    ul.breadcrumb {
        font-family: 'Poppins', sans-serif;
    }
</style>



<div class="d-flex" id="wrapper">
    @include('worker.leftmenu')
    <div id="page-content-wrapper">
        @include('components.worker.ui.navbar')

        <ul class="breadcrumb">
            <li>Dashboard</li>
            <li>Nominee Registration</li>
        </ul>

        @php $current_date = now(); @endphp

        <div class="benefit-heading">
            <h3>Nominee List</h3>
        </div>

        <section class="benefits-sec">
            <div class="table-responsive">
                <table class="table table-striped table-bordered table-hover align-middle">
                    <thead class="table-dark">
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Name</th>
                            <th scope="col">Guardain Name</th>
                            <th scope="col">DOB</th>
                            <th scope="col">Relation</th>
                            <th scope="col">Percentage</th>
                            <th scope="col">EKYC Status</th>
                            <th scope="col" class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="table-group-divider">
                        @foreach ($nominees as $nominee)
                            <tr>
                                <th scope="row">1</th>
                                <td>{{ $nominee->first_name }}&nbsp;{{ $nominee->last_name }}</td>
                                <td>{{ $nominee->guardain_name }}</td>
                                <td>{{ $nominee->dob }}</td>
                                <td>{{ $nominee->relationDetails->relation_name }}</td>
                                <td>{{ $nominee->nominee_percentage }}%</td>
                                <td>
                                    @if ($nominee->is_aadhar_verified == true)
                                        <span class="badge bg-success">Completed</span>
                                    @else
                                        <span class="badge bg-warning">Not Initiated</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    @if ($nominee->is_aadhar_verified == false)
                                        <a href="{{route('nominee.ekyc',$nominee->id)}}" class="btn btn-primary btn-sm me-1"><i class="bi bi-pencil-square"></i>
                                        Complete EKYC</a>
                                    @else
                                        <a href="{{route('nominee.ekyc-ack',$nominee->id)}}" target="_blank" class="btn btn-warning"><i class="bi bi-pencil-square"></i>Print Acknowlwdgement</a>
                                    @endif
                                    {{-- <button class="btn btn-primary btn-sm me-1"><i class="bi bi-pencil-square"></i>
                                        Edit</button>
                                    <button class="btn btn-danger btn-sm"><i class="bi bi-trash"></i> Delete</button> --}}
                                </td>
                            </tr>
                        @endforeach


                    </tbody>
                </table>
            </div>
    </div>
    </section>
</div>
</div>

@include('components.footer')

<script src="{{ asset('assets/template/vendor/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('assets/template/js/getVaultData.js') }}"></script>
<script src="{{ asset('assets/template/js/sweetAlert.js') }}"></script>
