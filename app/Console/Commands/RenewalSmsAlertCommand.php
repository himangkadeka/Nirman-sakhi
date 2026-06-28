<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\MainWorkerForm;
use App\Services\SmsGatewayService;
use Carbon\Carbon;
use App\Jobs\SendRenewalSmsBatchJob;

class RenewalSmsAlertCommand extends Command
{
    protected $signature = 'sms:dispatch-renewals';
    protected $description = 'Dispatch SMS reminders for all users expiring today';

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $today = Carbon::today()->format('Y-m-d');

        MainWorkerForm::whereDate('id_card_expiry_date', $today)
            ->chunk(1000, function ($users) {
                dispatch(new SendRenewalSmsBatchJob($users));
            });


        $this->info('SMS Jobs dispatched for expiring users.');
    }
}
