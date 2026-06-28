<?php
/**
 * Created by PhpStorm.
 * User: hp
 * Date: 01-05-2026
 * Time: 21:58
 */

namespace App\Services;

use Carbon\Carbon;

class WorkerStatusService
{
    public function resolve($wmf, $payment = null, $renewal = null): array
    {
        $today = Carbon::today();

        $retirementDate   = $wmf->date_of_retirement;
        $expiryDate       = $wmf->id_card_expiry_date;
        $subscriptionDate = $wmf->subscription_validity_date;

        $activeStatus = $wmf->active_status;

        // derive flags from other models
        $isPaid            = $payment?->is_paid ?? false;
        $isRenewApplied    = $renewal?->is_applied ?? false;
        $isRenewalApproved = $renewal?->is_approved ?? false;
        $isAppPaid         = $renewal?->is_app_paid ?? false;

        if ($activeStatus == '2') {
            return $this->format('Suspended', 'bg-expired-pill');
        }

        if ($retirementDate->lt($today)) {
            return $this->format(
                'Retired',
                'bg-expired-pill',
                'Retired on ' . $retirementDate->format('d-m-Y')
            );
        }

        if ($expiryDate->lt($today)) {
            if ($isRenewApplied) {
                return $this->format(
                    'Renewal Applied',
                    'bg-expired-pill',
                    'Expired on ' . $expiryDate->format('d-m-Y')
                );
            }

            return $this->format(
                'Expired',
                'bg-expired-pill',
                'Expired on ' . $expiryDate->format('d-m-Y')
            );
        }

        if ($subscriptionDate->gt($today)) {
            return $this->format('Active', 'bg-active-pill');
        }

        if ($activeStatus == '1' && $isPaid) {
            return $this->format('Active', 'bg-active-pill');
        }

        if ($activeStatus == '1' && !$isPaid && !$isRenewalApproved) {
            return $this->format('Expired', 'bg-expired-pill');
        }

        if ($activeStatus == '1' && $isRenewalApproved && !$isAppPaid) {
            return $this->format('Inactive', 'bg-expired-pill');
        }

        if ($subscriptionDate->lt($today)) {
            return $this->format('Payment Lapsed', 'bg-warning-pill');
        }

        return $this->format('Unknown', 'bg-secondary');
    }

    private function format($label, $class, $meta = null)
    {
        return compact('label', 'class', 'meta');
    }
}
