@include('layout.workerheader')
<style>
    body{
        font-family: 'Inter', sans-serif;
        background-color: #f4f7fa;
    }
</style>
<div class="d-flex" id="wrapper">
@include('worker.leftmenu')

<!-- Page Content -->
    <div id="page-content-wrapper">
    @include('components.worker.ui.navbar')

    <!-- Breadcrumb -->
        <ul class="breadcrumb d-flex justify-content-between align-items-center bg-white shadow-sm px-3 py-2" style="font-family:'Poppins',Sans-Serif">
            <li class="breadcrumb-item active font-weight-bold">History</li>
        </ul>

        <!-- Table Section -->
        <div class="container-fluid mt-3">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-primary text-white">
                    <h6 class="mb-0">Renewal History</h6>
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover table-bordered text-center">
                            <thead class="thead-light">
                            <tr>
                                <th>#</th>
                                <th>Application ID</th>
                                <th>Status</th>
                                <th>Expiry Date</th>
                                <th>Renewal Date</th>
                                <th>Date</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($history ?? [] as $key => $item)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $item->ack_no ?? '-' }}</td>
                                    <td>
                                        <span class="badge badge-success px-3 py-1">
                                            {{ $item->status ?? 'Approved' }}
                                        </span>
                                    </td>
                                    <td>{{ \Carbon\Carbon::parse($item->id_card_expiry_date)->format('d M Y') }}</td>
                                    <td>{{ \Carbon\Carbon::parse($item->next_renewal_date)->format('d M Y') }}</td>

                                    <td>{{ \Carbon\Carbon::parse($item->created_at)->format('d M Y') }}</td>

                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-muted">No history found</td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@include('components.footer')