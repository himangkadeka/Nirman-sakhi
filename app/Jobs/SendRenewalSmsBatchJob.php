<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Services\SmsGatewayService;

class SendRenewalSmsBatchJob extends Job
{
    protected $users;

    public function __construct($users)
    {
        $this->users = $users; // chunk of 1000 users
    }

    public function handle()
    {
        $service = new SmsGatewayService();

        foreach ($this->users as $user) {
            $service->renewalDueAlertSMS(
                $user->mobile,
                $user->id_card_no,
                $user->id_card_expiry_date,
                $user->renewal_url
            );
        }
    }
}
