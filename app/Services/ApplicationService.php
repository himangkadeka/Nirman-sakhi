<?php


namespace App\Services;
use Illuminate\Support\Facades\DB;
use App\Models\MainWorkerForm;
use Carbon\Carbon;

class ApplicationService
{
    public function updateApplicationStatus()
    {
        $twoDaysAgo = Carbon::now()->subDays(2);

        $workers = MainWorkerForm::where('status', 'C')
            ->where('updated_at', '<', $twoDaysAgo)
            ->get();
        foreach ($workers as $worker) {
            $worker->update(['status' => env('REGISTERING_OFFICER')]);
        }

        return "Application statuses updated successfully.";
    }
}

