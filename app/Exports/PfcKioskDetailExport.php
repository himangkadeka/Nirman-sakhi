<?php

namespace App\Exports;

use App\Models\PfcKioskDetail;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class PfcKioskDetailExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        $final = collect();

        PfcKioskDetail::select(
            'kiosk_registration_id',
            \DB::raw('MIN(kiosk_name) as kiosk_name'),
            \DB::raw('MIN(user_type) as user_type')
        )
            ->where('is_login_csc', true)
            ->groupBy('kiosk_registration_id')
            ->orderBy('kiosk_registration_id') // ✅ required
            ->chunk(200, function ($rows) use (&$final) {

                foreach ($rows as $index => $pfc) {

                    $final->push([
                        'Sno' => $final->count() + 1,
                        'PFC/CSC Name' => $pfc->kiosk_name ?? 'NA',
                        'User Type' => $pfc->user_type,
                        'Total No. of Transactions' => $pfc->getCountTemp($pfc->kiosk_registration_id),
                        'Onboarding Registration' => $pfc->getOnboardingCountTemp($pfc->kiosk_registration_id),
                        'New Worker Registration' => $pfc->getNewWorkerCountTemp($pfc->kiosk_registration_id),
                        'Worker Subscription' => $pfc->getSubscriptionCount($pfc->kiosk_registration_id),
                        'Worker Renewal' => $pfc->getRenewalCount($pfc->kiosk_registration_id),
                    ]);
                }
            });

        return $final;
    }

    public function headings(): array
    {
        return [
            'Sno',
            'PFC/CSC Name',
            'User Type',
            'Total No. of Transactions',
            'Onboarding Registration',
            'New Worker Registration',
            'Worker Subscription',
            'Worker Renewal',
        ];
    }
}
