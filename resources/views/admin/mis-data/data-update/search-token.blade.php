@extends('layouts.admin-app')

@section('title', 'Admin | App History')
@section('breadcrumb_item_1', 'MIS Data')
@section('breadcrumb_item_2', 'Token Data')
@section('style')
    <style>
        .bg-info {
            color: white;
        }

        .b-dbcard {
            width: 200px;
        }
    </style>
@endsection
@section('content')

    <div class="container-fluid">
        <div class="row">
            {{-- <div class="row text-center py-4" id="sortable-cards" style="width: 100%;">
                <div class="b-customize">
                    <div class="p-2 b-dbcard" style="background-color: #3dc6cb;">

                    </div>
                </div>
            </div> --}}
            <div class="col-md-12 table-responsive mt-4">
                <h5>Search Vault Token with Acknowledgement Number</h5>

                <input type="text" class="form-control" id="ack_no" placeholder="Enter Acknowledgement Number">
                <div class="hello mt-3">
                    <button class="btn btn-warning" onclick="searchVaultToken()">Search</button>
                </div>

                <div id="result" class="mt-4"></div>


            </div>

            <div class="col-md-12 table-responsive mt-4">
                <h5>Search Worker ID with Vault Token from Vault Data Table</h5>

                <input type="text" class="form-control" id="vault_token" placeholder="Enter Vault Token">
                <div class="hello mt-3">
                    <button class="btn btn-warning" onclick="serachWorkerIDFromVaultData()">Search</button>
                </div>

                <div id="result5" class="mt-4"></div>
            </div>

            <div class="col-md-12 table-responsive mt-4">
                <h5>Search Vault Token with Worker ID</h5>

                <input type="text" class="form-control" id="worker_id" placeholder="Enter Worker ID">
                <div class="hello mt-3">
                    <button class="btn btn-success" onclick="searchVaultTokenWithWorkerID()">Search</button>
                </div>

                <div id="result1" class="mt-4"></div>


            </div>

            <div class="col-md-12 table-responsive mt-4">
                <h5>Search Main Vault Token with Worker ID</h5>

                <input type="text" class="form-control" id="main_worker_id" placeholder="Enter Worker ID">
                <div class="hello mt-3">
                    <button class="btn btn-success" onclick="searchMainVaultTokenWithWorkerID()">Search</button>
                </div>

                <div id="result4" class="mt-4"></div>


            </div>

            <div class="col-md-12 table-responsive mt-4">
                <h5>Search Worker ID with Phone Number</h5>

                <input type="text" class="form-control" id="phone_no" placeholder="Enter Phone Number">
                <div class="hello mt-3">
                    <button class="btn btn-danger" onclick="searchWorkerId()">Search</button>
                </div>

                <div id="result2" class="mt-4"></div>


            </div>


            <div class="col-md-12 table-responsive mt-4">
                <h5>Search Subscriptions of a Worker</h5>

                <input type="text" class="form-control" id="inputValue" placeholder="Enter Worker ID or ID Card Number">
                <div class="hello mt-3">
                    <button class="btn btn-primary" onclick="searchSubscriptions()">Search</button>
                </div>

                <div id="result3" class="mt-4"></div>


            </div>
        </div>
    </div>

@endsection
<script>
    function searchVaultToken() {
        var ackNo = $("#ack_no").val();

        if (ackNo.trim() === "") {
            $("#result").html("<p class='text-danger'>Please enter ACK No.</p>");
            return;
        }

        $.ajax({
            url: "{{ route('admin.dataupdate.get-token') }}",
            type: "POST",
            data: {
                ack_no: ackNo,
                _token: "{{ csrf_token() }}"
            },
            success: function(response) {
                console.log(response);
                $("#result").html(`
                    <table class="table table-bordered mt-2">
                        <thead>
                            <tr>
                                <th>ACK No</th>
                                <th>Vault Token</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>${ackNo}</td>
                                <td>${response.vault_token ? response.vault_token : 'N/A'}</td>
                            </tr>
                        </tbody>
                    </table>
                `);
            },
            error: function(xhr) {
                $("#result").html(`<p class="text-danger">${xhr.responseJSON.message}</p>`);
            }
        });
    }

    function searchVaultTokenWithWorkerID() {
        var workerId = $("#worker_id").val();

        if (workerId.trim() === "") {
            $("#result1").html("<p class='text-danger'>Please enter Worker ID.</p>");
            return;
        }

        $.ajax({
            url: "{{ route('admin.dataupdate.get-token-worker-id') }}",
            type: "POST",
            data: {
                worker_id: workerId,
                _token: "{{ csrf_token() }}"
            },
            success: function(response) {
                console.log(response);
                $("#result1").html(`
                    <table class="table table-bordered mt-2">
                        <thead>
                            <tr>
                                <th>Worker ID</th>
                                <th>Main Vault Token</th>
                                <th>Vault Token</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>${workerId}</td>
                                <td>${response.main_vault_token ? response.main_vault_token : 'N/A'}</td>
                                <td>${response.vault_token ? response.vault_token : 'N/A'}</td>
                            </tr>
                        </tbody>
                    </table>
                `);
            },
            error: function(xhr) {
                $("#result1").html(`<p class="text-danger">${xhr.responseJSON.message}</p>`);
            }
        });
    }

    function searchMainVaultTokenWithWorkerID() {
        var workerId = $("#main_worker_id").val();

        if (workerId.trim() === "") {
            $("#result4").html("<p class='text-danger'>Please enter Worker ID.</p>");
            return;
        }

        $.ajax({
            url: "{{ route('admin.dataupdate.get-main-token-worker-id') }}",
            type: "POST",
            data: {
                worker_id: workerId,
                _token: "{{ csrf_token() }}"
            },
            success: function(response) {
                console.log(response);
                $("#result4").html(`
                    <table class="table table-bordered mt-2">
                        <thead>
                            <tr>
                                <th>Worker ID</th>
                                <th>Main Vault Token</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                            <td>${workerId}</td>
                            <td>${response.main_vault_token ? response.main_vault_token : 'N/A'}</td>
                            <td>
                                <button class="btn btn-sm btn-danger" onclick="
                                    if (confirm('Are you sure you want to delete this token?')) {
                                        $.ajax({
                                            url: '/admin/dataupdate/search-delete-main-vault-token-worker',
                                            type: 'POST',
                                            data: {
                                                _token: '{{ csrf_token() }}',
                                                worker_id: '${workerId}'
                                            },
                                            success: function(response) {
                                                Swal.fire({
                                                    icon: 'success',
                                                    text: 'Vault token deleted successfully.'
                                                });
                                                $('#result4').html('<p>Vault token deleted successfully.</p>');
                                            },
                                            error: function(xhr) {
                                                alert(xhr.responseJSON.message);
                                            }
                                        });
                                    }
                                ">Delete</button>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                `);
            },
            error: function(xhr) {
                $("#result4").html(`<p class="text-danger">${xhr.responseJSON.message}</p>`);
            }
        });
    }

    function searchWorkerId() {
        var phoneNumber = $("#phone_no").val();

        if (phoneNumber.trim() === "") {
            $("#result2").html("<p class='text-danger'>Please enter Phone Number.</p>");
            return;
        }

        $.ajax({
            url: "{{ route('admin.dataupdate.get-worker-id') }}",
            type: "POST",
            data: {
                phone_no: phoneNumber,
                _token: "{{ csrf_token() }}"
            },
            success: function(response) {
                console.log(response);
                if (response.worker_ids.length > 0) {
                    let tableContent = response.worker_ids.map(workerId => `
                    <tr>
                        <td>${phoneNumber}</td>
                        <td>${workerId}</td>
                    </tr>
                `).join("");

                    $("#result2").html(`
                    <table class="table table-bordered mt-2">
                        <thead>
                            <tr>
                                <th>Phone Number</th>
                                <th>Worker ID</th>
                            </tr>
                        </thead>
                        <tbody>
                            ${tableContent}
                        </tbody>
                    </table>
                `);
                } else {
                    $("#result2").html("<p class='text-danger'>No Worker ID found.</p>");
                }
            },
            error: function(xhr) {
                $("#result2").html(`<p class="text-danger">${xhr.responseJSON.message}</p>`);
            }
        });
    }

    function serachWorkerIDFromVaultData() {
    var vaultToken = $("#vault_token").val();

    if (vaultToken.trim() === "") {
        $("#result5").html("<p class='text-danger'>Please enter Vault Token.</p>");
        return;
    }

    $.ajax({
        url: "{{ route('admin.dataupdate.get-worker-id-vault-token') }}",
        type: "POST",
        data: {
            vault_token: vaultToken,
            _token: "{{ csrf_token() }}"
        },
        success: function(response) {
            console.log(response);

            let tableContent = `
                <tr>
                    <td>${response.vault_token}</td>
                    <td>${response.worker_id}</td>
                </tr>
            `;

            $("#result5").html(`
                <table class="table table-bordered mt-2">
                    <thead>
                        <tr>
                            <th>Vault Token</th>
                            <th>Worker ID</th>
                        </tr>
                    </thead>
                    <tbody>
                        ${tableContent}
                    </tbody>
                </table>
            `);
        },
        error: function(xhr) {
            $("#result5").html(`<p class="text-danger">${xhr.responseJSON.message}</p>`);
        }
    });
}


    function searchSubscriptions() {
        var inputValue = $("#inputValue").val();

        if (inputValue.trim() === "") {
            $("#result3").html("<p class='text-danger'>Please enter Worker ID or ID Card Number.</p>");
            return;
        }

        $.ajax({
            url: "{{ route('admin.dataupdate.get-subscriptions') }}",
            type: "POST",
            data: {
                worker_id: inputValue,
                id_card_no: inputValue,
                _token: "{{ csrf_token() }}"
            },
            success: function(response) {
                console.log(response);

                if (response.subscriptions && response.subscriptions.length > 0) {
                    // Build table rows
                    let tableContent = response.subscriptions.map(sub => `
                <tr>
                    <td>${sub.worker_id}</td>
                    <td>${sub.application_no}</td>
                    <td>${sub.ack_no}</td>
                    <td>${sub.id_card_no}</td>
                    <td>${sub.office_id}</td>
                    <td>${sub.transaction_id}</td>
                    <td>${sub.total_amount}</td>
                    <td>${sub.from_period}</td>
                    <td>${sub.to_period}</td>
                    <td>${sub.payment_status}</td>
                    <td>${sub.month_paid}</td>
                    <td>${sub.amount_paid}</td>
                    <td>${sub.penalty_months}</td>
                    <td>${sub.is_defaulted}</td>
                    <td>${sub.subscription_type}</td>
                    <td>${sub.last_subscription}</td>
                    <td>${sub.fine}</td>
                    <td>${sub.no_of_delayed_months}</td>
                    <td>${sub.created_at}</td>
                </tr>
            `).join("");

                    // Update table
                    $("#result3").html(`
                <table class="table table-bordered mt-2">
                    <thead>
                        <tr>
                            <th>Worker ID</th>
                            <th>Application Number</th>
                            <th>Acknowledgement Number</th>
                            <th>Id Card Number</th>
                            <th>Office ID</th>
                            <th>Transaction ID</th>
                            <th>Total Amount</th>
                            <th>From Period</th>
                            <th>To Period</th>
                            <th>Payment Status</th>
                            <th>Month Paid</th>
                            <th>Amount Paid</th>
                            <th>Penalty Months</th>
                            <th>Is Defaulted</th>
                            <th>Subscription Type</th>
                            <th>Last Subscription</th>
                            <th>Fine</th>
                            <th>No of Delayed Months</th>
                            <th>Created At</th>
                        </tr>
                    </thead>
                    <tbody>
                        ${tableContent}
                    </tbody>
                </table>
            `);
                } else {
                    $("#result3").html("<p class='text-danger'>No subscriptions found.</p>");
                }
            },
            error: function(xhr) {
                const msg = xhr.responseJSON?.message || "An error occurred while fetching subscriptions.";
                $("#result3").html(`<p class="text-danger">${msg}</p>`);
            }
        });

    }
</script>
