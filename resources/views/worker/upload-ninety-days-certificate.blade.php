@include('layout.workerheader')

<style>
    .table th {
        font-size: 12px;
    }

    .table-container {
        overflow-x: auto;
    }

    .fixed-width {
        min-width: 200px;
        /* Adjust the width as needed */
    }

    .fixed {
        min-width: 100px;
        /* Adjust the width as needed */
    }

    .table thead tr {
        border-top: 2px solid #ffc0b4;
    }

    .table thead th {
        border-bottom: 2px solid black;
    }
</style>
<div class="d-flex" id="wrapper">
@include('sweetalert::alert')
@include('worker.leftmenu')
<!-- Page Content -->
    <div id="page-content-wrapper">
@include('components.worker.ui.navbar')
        <ul class="breadcrumb">
            <li><a href="{{route('worker-dashboard')}}">Dashboard</a></li>
            <li>Upload Certificate</li>

        </ul>
        <div class="container mt-2">
            <div class="card rounded-card">
                <div class="card-header card-header-bg text-white d-flex justify-content-between align-items-center" style="background-color: #248f8f;">
        <span>
            <i class="fa fa-plus-circle" aria-hidden="true"></i>&nbsp; Upload New Certificate
        </span>
                    <button class=" btn btn-primary">
                        All Subscriptions &nbsp;<i class="fa fa-arrow-circle-right" aria-hidden="true"></i>
                    </button>
                </div>

                <div class="container-fluid text-center">
                    <div class="table-responsive">
                        <table class="table" id="user_table">
                            <thead>

                            <tr>

                                <th scope="col">Type Of Documents</th>
                                <th></th>
                                <th scope="col">Status</th>
                                <th></th>
                                <th>Action</th>
                                <th></th>
                            </tr>
                            </thead>

                            <tr style="background-color: rgb(219, 226, 232)">
                                <form action="{{ route('save-certificate') }}" method="post"
                                      enctype="multipart/form-data">
                                    @csrf
                                    <td class="bold" style="width: 300px">Certificate Proof</td>
                                    <td class="bold" style="width: 300px">
                                        <select required name="certificate_id"
                                                class="form-control fixed custom-bottom-border bg-light-gray">
                                            @if (isset($twd->certificate_id))
                                                <option value="{{ $twd->certificate_id }}">
                                                    {{ $twd->issuer_name }}</option>
                                                @foreach ($type_of_issuer as $issuer)
                                                    <option value="{{ $issuer->issuer_code }}">
                                                        {{ $issuer->issuer_name }}</option>
                                                @endforeach
                                            @else
                                                <option value="">Select Certificate Proof</option>
                                                @foreach ($type_of_issuer as $issuer)
                                                    <option value="{{ $issuer->issuer_code }}">
                                                        {{ $issuer->issuer_name }}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </td>
                                    <td>
                                        @php
                                            $certificate_proof = $twd->certificate_proof ?? null;
                                        @endphp
                                        @if (!$certificate_proof)
                                            <span class="badge badge-warning">Pending</span>
                                        @else
                                            <span class="badge badge-success">Uploaded</span>
                                        @endif
                                    </td>
                                    <td>
                                        <input accept="application/pdf" required type="file" name="certificate_proof" onchange="return validateFileSize(this)">
                                    </td>
                                    <td>
                                        <button class="btn btn-primary btn-sm" type="submit">Upload</button>
                                    </td>
                                        @if ($certificate_proof)
                                        <td>
                                            <a class="btn btn-danger btn-sm" target="_blank"
                                               href="{{ route('certificate-view', ['id' => mt_rand(1, 1000)]) }}"><i
                                                    class="fa fa-eye" aria-hidden="true"></i></a>
                                        </td>
                                        @endif

                                </form>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<script>
    function validateFileSize(input) {
        const file = input.files[0];
        const maxSizeKB = 500; // Maximum size allowed in KB
        const minSizeKB = 5; // Minimum size allowed in KB

        // Check file type
        if (!file.type.startsWith('application/pdf')) {
            alert("Please select a PDF file.");
            input.value = '';
            return false;
        }

        // Check file size
        const fileSizeKB = file.size / 1024; // Convert bytes to KB
        if (fileSizeKB < minSizeKB || fileSizeKB > maxSizeKB) {
            alert(`File size must be between ${minSizeKB}KB and ${maxSizeKB}KB.`);
            input.value = '';
            return false;
        }

        return true;
    }
</script>

@include('layout.footer')
