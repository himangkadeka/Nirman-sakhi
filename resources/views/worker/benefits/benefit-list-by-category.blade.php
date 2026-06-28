@include('layout.workerheader')

<div class="d-flex" id="wrapper">
    @include('worker.leftmenu')

    <div id="page-content-wrapper">
        @include('components.worker.ui.navbar')

        <div class="container py-5">
            <div class="card shadow-sm">
                <div class="card-header bg-white">
                    <h4 class="mb-0">Benefit List</h4>
                </div>

                <div class="card-body">
                    @php
                        // SAFELY FETCH WORKER DATA ONCE BEFORE THE LOOP
                        $workerSession = session()->get('worker');
                        $workerProfile = null;
                        $yearsDiff = 0;

                        if ($workerSession) {
                            $workerProfile = \App\Models\MainWorkerForm::where(
                                'worker_id',
                                $workerSession->worker_id,
                            )->first();
                            if (
                                $workerProfile &&
                                $workerProfile->last_registration_date &&
                                $workerProfile->subscription_validity_date
                            ) {
                                $regDate = \Carbon\Carbon::parse($workerProfile->last_registration_date);
                                $valDate = \Carbon\Carbon::parse($workerProfile->subscription_validity_date);
                                $yearsDiff = $regDate->diffInYears($valDate);
                            }
                        }
                    @endphp

                    @if ($benefit_lists->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover table-bordered align-middle">
                                <thead class="thead-light">
                                    <tr>
                                        <th scope="col" class="text-center" style="width: 80px;">S.No</th>
                                        <th scope="col">Benefit Name</th>
                                        <th scope="col">Description</th>
                                        <th scope="col" class="text-center" style="width: 150px;">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($benefit_lists as $benefit)
                                        <tr>
                                            <td class="text-center">{{ $loop->iteration }}</td>
                                            <td class="font-weight-bold">
                                                {{ $benefit->name }}<br>
                                                <small class="text-muted">{{ $benefit->benefit_code }}</small>
                                            </td>
                                            <td>{!! $benefit->description !!}</td>
                                            <td class="text-center">
                                                @php
                                                    $isEligible = true;
                                                    $reason = '';

                                                    // Calculate shared variables for all 4 benefits
                                                    if (
                                                        $workerProfile &&
                                                        in_array($benefit->benefit_code, ['MT', 'MR', 'CE', 'EA'])
                                                    ) {
                                                        $registrationDate = \Carbon\Carbon::parse(
                                                            $workerProfile->last_registration_date,
                                                        );
                                                        $validityDate = \Carbon\Carbon::parse(
                                                            $workerProfile->subscription_validity_date,
                                                        );
                                                        $yearsDiff = $registrationDate->diffInYears($validityDate);

                                                        // Get total valid applications for THIS worker
                                                        $applicationCount = App\Models\FormSubmission::where(
                                                            'worker_id',
                                                            $workerProfile->worker_id,
                                                        )
                                                            ->where('benefit_id', $benefit->id)
                                                            ->whereNotNull('submitted_at')
                                                            ->whereNotIn('status', ['draft', 'rejected'])
                                                            ->count();

                                                        // Check Spouse Application for MR, CE, EA
                                                        $spouseAppCount = 0;
                                                        if (in_array($benefit->benefit_code, ['MR', 'CE', 'EA'])) {
                                                            $spouse = App\Models\MainWorkerFamily::where(
                                                                'worker_id',
                                                                $workerProfile->worker_id,
                                                            )
                                                                ->where('relation', 5) // Ensure 5 is Wife/Husband
                                                                ->where('already_registered', 'Yes')
                                                                ->whereNotNull('bocwwb_id')
                                                                ->first();

                                                            if ($spouse) {
                                                                $spouseWorker = App\Models\MainWorkerForm::where(
                                                                    'id_card',
                                                                    $spouse->bocwwb_id,
                                                                )
                                                                    ->orWhere('worker_id', $spouse->bocwwb_id)
                                                                    ->first();

                                                                if ($spouseWorker) {
                                                                    $spouseAppCount = App\Models\FormSubmission::where(
                                                                        'worker_id',
                                                                        $spouseWorker->worker_id,
                                                                    )
                                                                        ->where('benefit_id', $benefit->id)
                                                                        ->whereNotNull('submitted_at')
                                                                        ->whereNotIn('status', ['draft', 'rejected'])
                                                                        ->count();
                                                                }
                                                            }
                                                        }

                                                        // Apply rules based on benefit
                                                        if ($benefit->benefit_code == 'MT' && $yearsDiff < 3) {
                                                            $isEligible = false;
                                                            $reason =
                                                                'You must have at least 3 years of continuous membership.';
                                                        } elseif ($benefit->benefit_code == 'MR' && $yearsDiff < 5) {
                                                            $isEligible = false;
                                                            $reason =
                                                                'You must have at least 5 years of continuous membership for Marriage Assistance.';
                                                        }

                                                        // Global Limit Checks (Applied to MT, MR, CE, EA)
                                                        if (
                                                            $benefit->benefit_code == 'CE' ||
                                                            $benefit->benefit_code == 'EA'
                                                        ) {
                                                            if ($applicationCount >= 20) {
                                                                $isEligible = false;
                                                                $reason =
                                                                    'Maximum of 20 applications are allowed under this benefit.';
                                                            } elseif ($spouseAppCount > 0) {
                                                                $isEligible = false;
                                                                $reason =
                                                                    'Your registered spouse has already applied for this benefit. Only one spouse can claim it.';
                                                            }
                                                        }elseif (
                                                            $benefit->benefit_code == 'MT' ||
                                                            $benefit->benefit_code == 'MR'
                                                        ) {
                                                            if ($applicationCount >= 2) {
                                                                $isEligible = false;
                                                                $reason =
                                                                    'Maximum of two applications are allowed under this benefit.';
                                                            } elseif ($spouseAppCount > 0) {
                                                                $isEligible = false;
                                                                $reason =
                                                                    'Your registered spouse has already applied for this benefit. Only one spouse can claim it.';
                                                            }
                                                        }
                                                    }
                                                @endphp

                                                @if ($isEligible)
                                                    <a href="{{ route('elegible-family-member', $benefit->id) }}"
                                                        class="btn btn-primary btn-sm">
                                                        Apply <i class="fa fa-paper-plane ml-1"></i>
                                                    </a>
                                                @else
                                                    <button type="button" class="btn btn-secondary btn-sm"
                                                        onclick="showIneligibleMsg('{{ $reason }}')">
                                                        Apply <i class="fa fa-lock ml-1"></i>
                                                    </button>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="alert alert-warning text-center">No benefits found for this category.</div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    window.onload = () => {
        if (typeof hideLoader === 'function') setTimeout(hideLoader, 2000);
    };

    function showIneligibleMsg(message) {
        Swal.fire({
            icon: 'error',
            title: 'Not Eligible',
            text: message,
            confirmButtonColor: '#3085d6',
        });
    }
</script>
