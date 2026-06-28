<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use App\Models\MainWorkerForm;
use Illuminate\Support\Carbon;

class checkMonthlySubscription extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'workers:activeStatus';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Workers Subscription Status Update';

    /**
     * Create a new command instance.
     *
     * @return void
     */
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
        $currentDate = Carbon::now()->format('d-m-y');
        $workers = MainWorkerForm::where('subscription_status','monthly')->where('active_status',1)->get();
        foreach ($workers as $worker){
            $expiryDate = Carbon::parse($worker->expiry_date);
            $month = $expiryDate->diffInMonths($currentDate);
            if ($month>0){
                MainWorkerForm::where('worker_id',$worker->worker_id)->update([
                    'active_status'=>0 ,
                    'subscription_status' => 'expired',
                ]);
            }
            // \Log::info($month);
        }
    }
}
