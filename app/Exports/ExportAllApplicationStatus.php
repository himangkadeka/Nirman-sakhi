<?php

namespace App\Exports;

use App\Models\WorkerApplicationStatus;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;

class ApplicationStatusPageExport implements FromCollection
{
    protected bool $exportAll;

    public function __construct(bool $exportAll = false)
    {
        $this->exportAll = $exportAll;
    }

    public function collection(): Collection
    {
        $query = WorkerApplicationStatus::with([
            'mainWorker.officeName',
            'getReceiver.roles'
        ])->orderBy('created_at', 'asc');

        // 🔹 ONLY difference between export & export-all
        if (!$this->exportAll) {
            // Apply THIS PAGE'S conditions ONLY
            // (example – keep what already exists on this page)
            $query->where('application_status', '!=', 'Draft');
        }

        return $query->get()
            ->values()
            ->map(function ($app, $index) {

                return [
                    'Sl No'    => $index + 1,
                    'Office'   => $app->mainWorker->officeName->office_name ?? 'N/A',
                    'Officer'  => $app->getReceiver
                                    ? $app->getReceiver->firstname.' '.$app->getReceiver->lastname
                                    : 'N/A',
                    'Role'     => $app->getReceiver->roles->first()->name ?? 'N/A',
                    'Status'   => $app->application_status,
                    'Date'     => optional($app->created_at)->format('d-m-Y'),
                ];
            });
    }
}
